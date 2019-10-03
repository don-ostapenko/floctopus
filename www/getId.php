<?php

require __DIR__ . '/../src/App/Services/Db.php';
$dbOptions = (require __DIR__ . '/../src/settings.php')['db'];
$db = \App\Services\Db::getInstance();

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$entitie = $db->query('SELECT * FROM `contacts` WHERE id = :id;', [':id' => $data['id']]);

echo json_encode($entitie);