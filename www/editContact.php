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
unset($data['fileEdit']);
unset($data['file']);


if ($data['checkbox'] == 'yes') {
    $entitie = $db->query('SELECT * FROM `contacts` WHERE id = :id;', [':id' => $data['id']]);
    $filePath = __DIR__ . '/img/' . $entitie[0]['img'] . '.jpg';
    unlink($filePath);
    $sql = 'UPDATE `contacts` SET img = :img WHERE id = ' . $data['id'];
    $db->query($sql, [':img' => null]);
}

if ($file['name']) {
    $generatedNameImg = bin2hex(random_bytes(5));
    $data['img'] = $generatedNameImg;
    $newFilePath = __DIR__ . '/img/' . $generatedNameImg . '.jpg';
    move_uploaded_file($file['tmp_name'], $newFilePath);
}

unset($data['checkbox']);


$columns2params = [];
$params2values = [];
$index = 1;
foreach ($data as $column => $value) {
    $param = ':param' . $index; // :param1
    $columns2params[] = $column . ' = ' . $param; // column1 = :param1
    $params2values[':param' . $index] = $value; // [:param1 => value1]
    $index++;
}
$sql = 'UPDATE `contacts` SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $data['id'];
$db->query($sql, $params2values);


$result = $db->query('SELECT * FROM `contacts`;', []);

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

echo json_encode($result);