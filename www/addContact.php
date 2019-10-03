<?php

require __DIR__ . '/../src/App/Services/Db.php';
$dbOptions = (require __DIR__ . '/../src/settings.php')['db'];
$db = \App\Services\Db::getInstance();

//$postData = file_get_contents('php://input');
//$data = json_decode($postData, true);


// Обрабатываем фото
$file = $_FILES['file'];

// Обрабатываем данные формы
$data = $_POST;
unset($data['file']);


if ($file['name']) {
    $generatedNameImg = bin2hex(random_bytes(5));
    $data['img'] = $generatedNameImg;
    $newFilePath = __DIR__ . '/img/' . $generatedNameImg . '.jpg';
    move_uploaded_file($file['tmp_name'], $newFilePath);
} else {
    $data['img'] = null;
}


// Работаем с данными POST
$filteredProperties = array_filter($data);
$columns = [];
$paramsNames = [];
$params2values = [];
foreach ($filteredProperties as $columnName => $value) {
    $columns[] = '`' . $columnName . '`'; // `column`
    $paramName = ':' . $columnName; // :param1
    $paramsNames[] = $paramName;
    $params2values[$paramName] = $value; // [:param1 = value1], [:param2 = value2] ...
}

$columnsViaSemicolon = implode(', ', $columns);
$paramsNamesViaSemicolon = implode(', ', $paramsNames);

$sql = 'INSERT INTO `contacts` (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
$db->query($sql, $params2values);


$result = $db->query('SELECT * FROM `contacts`;', []);

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

$d = json_encode($result);

echo $d;
