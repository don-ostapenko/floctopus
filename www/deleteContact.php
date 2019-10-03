<?php

require __DIR__ . '/../src/App/Services/Db.php';
$dbOptions = (require __DIR__ . '/../src/settings.php')['db'];
$db = \App\Services\Db::getInstance();

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);


$entitie = $db->query('SELECT * FROM `contacts` WHERE id = :id;', [':id' => $data['id']]);


if ($entitie[0]['img']) {
    $filePath = __DIR__ . '/img/' . $entitie[0]['img'] . '.jpg';
    unlink($filePath);
}

$db->query('DELETE FROM `contacts` WHERE id = :id', [':id' => $data['id']]);


$result = $db->query('SELECT * FROM `contacts`;', []);

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

echo json_encode($result);