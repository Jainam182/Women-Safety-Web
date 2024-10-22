<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
file_put_contents('error_log.txt', "Request received: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regionName = $_POST['regionName'] ?? 'undefined';
    $latitude = $_POST['latitude'] ?? 'undefined';
    $longitude = $_POST['longitude'] ?? 'undefined';

    file_put_contents('error_log.txt', "Data received: $regionName, $latitude, $longitude\n", FILE_APPEND);

    if (!empty($regionName) && !empty($latitude) && !empty($longitude)) {
        $csvData = "$latitude,$longitude,$regionName\n";
        $file = 'RandomLocations.csv';

        if (file_put_contents($file, $csvData, FILE_APPEND | LOCK_EX) !== false) {
            echo json_encode(['success' => true]);
            file_put_contents('error_log.txt', "Data written successfully\n", FILE_APPEND);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to write to file']);
            file_put_contents('error_log.txt', "Failed to write to file\n", FILE_APPEND);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        file_put_contents('error_log.txt', "Missing required data\n", FILE_APPEND);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    file_put_contents('error_log.txt', "Invalid request method\n", FILE_APPEND);
}
?>
