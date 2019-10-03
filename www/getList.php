<?php

require __DIR__ . '/../src/App/Services/Db.php';
$dbOptions = (require __DIR__ . '/../src/settings.php')['db'];
$db = \App\Services\Db::getInstance();
$result = $db->query('SELECT * FROM `contacts`;', []);

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

echo json_encode($result);

