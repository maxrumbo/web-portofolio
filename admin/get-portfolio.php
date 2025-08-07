<?php
header('Content-Type: application/json');
$dataFile = __DIR__ . '/portfolio-data.json';
if (!file_exists($dataFile)) {
    echo json_encode([]);
    exit();
}
$data = json_decode(file_get_contents($dataFile), true);
echo json_encode($data);
