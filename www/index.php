<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
    <!-- Стили для сколл-бара -->
    <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.min.css">
    <!-- Иконки font awesome -->
    <link rel="stylesheet" href="/css/all.min.css">
    <title><?= $title ?? 'Контакты' ?></title>
</head>
<body>
<main>
    <section class="container">
        <!-- Модалка для добавления контакта -->
        <div id="overlay-add">
            <form action="#" id="modal-add" enctype="multipart/form-data" method="post">
                <h3 class="mb-3">Add contact</h3>
                <div class="form-group">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone*</label>
                    <input type="text" class="form-control" id="phone" placeholder="Enter phone" required>
                </div>
                <div class="form-group">
                    <label for="info">Additional info</label>
                    <textarea class="form-control" id="info" name="info" rows="3"></textarea>
                </div>
                <input type="file" id="file" accept="image/x-png,image/jpeg">
                <div style="display: flex; padding-top: 30px;">
                    <button type="submit" class="btn btn-success">Add</button>
                    <span id="cancel-add">Close</span>
                </div>
            </form>
        </div>

        <!-- Модалка для редактирования контакта -->
        <div id="overlay-edit">
            <form action="#" id="modal-edit" enctype="multipart/form-data" method="post">
                <h4 class="mb-3"></h4>
                <div class="form-group">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone*</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="" required>
                </div>
                <div class="form-group">
                    <label for="info">Additional info</label>
                    <textarea class="form-control" id="info" name="info" rows="3"></textarea>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" value="" id="checkbox">
                  <label class="custom-control-label" for="checkbox">Delete photo</label>
                </div>
                <input type="hidden" id="id" class="" name="id" value="no">
                <input type="file" id="fileEdit" accept="image/x-png,image/jpeg">
                <div style="display: flex; padding-top: 10px;">
                    <button type="submit" class="btn btn-success">Save</button>
                    <span id="cancel-edit">Cancel</span>
                </div>
            </form>
        </div>

        <!-- Модалка для удаления контакта -->
        <div id="overlay-del">
            <form action="#" id="modal-del">
                <h4 class="mb-3"></h4>
                <input type="hidden" id="id" name="id" value="">
                <div style="display: flex; padding-top: 10px;">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <span id="cancel-del">Cancel</span>
                </div>
            </form>
        </div>

        <!-- Основная часть -->
        <div class="row justify-content-center">
            <div class="col-6 d-flex my-height">
                <div id="app" class="app align-self-center">
                    <div class="app_top-block">
                        <h4>My contact list</h4>
                        <button type="button" class="btn btn-outline-success" onclick="openAdd()">Add new</button>
                    </div>
                    <div id="card" class="app_main-block">

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="/js/script.js"></script>
<!-- Плагин для скролл-бара -->
<script src="/js/jquery.mCustomScrollbar.min.js"></script>
<!-- Плагин для маски поля ввода телефона -->
<script src="/js/jquery.maskedinput.min.js"></script>
</body>
</html>
