// Функция рендера блока карточки контакта
function render(data) {
  var text = "";
  $.each(data, function(key, value) {
    text += "<div class='card-wrap'>" +
      "<div class='card-top'>" +
        "<div class='name-block'>" +
          "<div id='imgData' class='photo' style='background-image: " + "url(/img/" + ((!value.img) ? 'default' : value.img) + ".jpg)'></div>" +
          "<div class='text'>" +
            "<h5>" + value.name + "</h5>" +
            "<span>" + value.phone + "</span>" +
          "</div>" +
        "</div>" +
        "<div class='btns-block'>" +
          "<button type='button' class='btn btn-primary' data-id='" + value.id + "' onclick='openEdit($(this))'><i class='far fa-pencil'></i></button>" +
          "<button type='button' class='btn btn-danger' data-id='" + value.id + "' onclick='openDel($(this))'><i class='fal fa-times'></i></button>" +
        "</div>" +
      "</div>" +
      "<div class='card-bottom'>" +
        "<p>" + ((!value.info) ? 'Some additional info' : value.info) + "</p>" +
      "</div>" +
    "</div>"
  })
  $("#card").html(text);
}


// Функция зполнения полей формы редактирования контакта
function fillFields(data) {
  $("#modal-edit").find("[name = id]").val(data[0]['id']);
  $("#modal-edit").find("[name = name]").val(data[0]['name']);
  $("#modal-edit").find("[name = phone]").val(data[0]['phone']);
  $("#modal-edit").find("textarea").val(data[0]['info']);
  $("#checkbox").change(function(){
    if(this.checked) {
      $("#fileEdit").attr("class", "d-none");
      $("#checkbox").val("yes");
    } else {
      $("#fileEdit").attr("class", "");
      $("#checkbox").val("no");
    }
  })
}

// По готовности старницы
$(document).ready(function() {
  // Функция инициализации скроллбара
  $("#app").mCustomScrollbar({
    axis: "y",
    theme: "minimal-dark"
  });
  // Функция инициализации маски
  $(function() {
    $("#phone").mask("(999) 999-99-99");
  });
});


// По готовности старницы получаем список всех контактов
$(document).ready(function() {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      var res = JSON.parse(request.responseText);
      render(res);
    }
  }
  request.open("GET", "getList.php", true);
  request.send(null);
})


// Открываем модалку добавления контакта
function openAdd() {
  $("#overlay-add").css("display", "flex");
}
// Отслеживаем клик и сохраняем данные
$("#modal-add").submit(function(e) {
  e.preventDefault();
  var file = $('#file');
  // создаём объект FormData
  var formData = new FormData();
  // добавляем в объект FormData файл
  formData.append('file', file.prop('files')[0]);
  $("#modal-add input, #modal-add textarea").each(function () {
    var id = $(this).attr("id");
    var val = String($(this).val());
    formData.append(id, val);
  });
  $.ajax({
    // ajax-запрос (пример использования formdata в jquery):
    // url - адрес на который будет отправлен запрос
    // data - данные, которые необходимо отправить на сервер
    // processData - отменить обработку данных
    // contentType - не устанавливать заголовок Content-Type
    // type - тип запроса
    // dataType - тип данных ответа сервера
    // success - функция, которая будет выполнена после удачного запроса
    url: 'addContact.php',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST'
  }).done(function(data) {
    $("#modal-add").find("input").val("");
    $("#modal-add").find("textarea").val("");
    $("#overlay-add").css("display", "none");
    render(data);
  })
})

// Закрываем модалку добавления контакта
$("#cancel-add").click(function() {
  $("#modal-add").find("input").val("");
  $("#modal-add").find("textarea").val("");
  $("#overlay-add").css("display", "none");
})


// Открываем модалку ред.контакта
function openEdit(el) {
  $("#overlay-edit").css("display", "flex");
  var id = {
    id: el.data("id")
  }
  $.ajax({
    type: "POST",
    url: "getId.php",
    cache: false,
    dataType: "json",
    contentType: 'application/json; charset=utf-8',
    data: JSON.stringify(id)
  }).done(function (data) {
    $("#overlay-edit").find("h4").append("Edit contact " + data[0]['name']);
    fillFields(data);
  })
}
// Отслеживаем сохранение данных
$("#modal-edit").submit(function(e) {
  e.preventDefault();
  var file = $('#fileEdit');
  // создаём объект FormData
  var formData = new FormData();
  // добавляем в объект FormData файл
  formData.append('file', file.prop('files')[0]);
  $("#modal-edit input, #modal-edit textarea").each(function () {
    var id = $(this).attr("id");
    var val = String($(this).val());
    formData.append(id, val);
  })
  $.ajax({
    url: 'editContact.php',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST'
  }).done(function(data) {
    $("#modal-edit").find("input").val("");
    $("#modal-edit").find("textarea").val("");
    $("input:checked").prop("checked", false);
    $("#fileEdit").attr("class", "");
    $("#overlay-edit").css("display", "none");
    $("#overlay-edit h4").html("");
    render(data);
  })
})
// Закрываем модалку ред.контакта
$("#cancel-edit").click(function() {
  $("#modal-edit").find("input").val("");
  $("#modal-edit").find("textarea").val("");
  $("input:checked").prop("checked", false);
  $("#fileEdit").attr("class", "");
  $("#overlay-edit").css("display", "none");
  $("#overlay-edit h4").html("");
})


// Открываем модалку удаления контакта
function openDel(el) {
  $("#overlay-del").css("display", "flex");
  var id = {
    id: el.data("id")
  }
  $.ajax({
    type: "POST",
    url: "getId.php",
    cache: false,
    dataType: "json",
    contentType: 'application/json; charset=utf-8',
    data: JSON.stringify(id)
  }).done(function (data) {
    $("#overlay-del").find("h4").append("Delete a contact " + data[0]['name'] + "?");
    $("#overlay-del").find("[name = id]").val(data[0]['id']);
  })
}
// Отслеживаем удаление данных
$("#modal-del").submit(function(e) {
  e.preventDefault();
  var myData = {};
  $("#modal-del input").each(function () {
    var id = $(this).attr("id");
    var val = String($(this).val());
    myData[id] = val;
  });
  var strData = JSON.stringify(myData);
  $.ajax({
    type: "POST",
    url: "deleteContact.php",
    cache: false,
    dataType: "json",
    contentType: 'application/json; charset=utf-8',
    data: strData
  }).done(function(data) {
    $("#overlay-del").css("display", "none");
    $("#overlay-del h4").html("");
    render(data);
  });
})
// Закрываем модалку удаления контакта
$("#cancel-del").click(function() {
  $("#overlay-del").css("display", "none");
  $("#overlay-del h4").html("");
})
