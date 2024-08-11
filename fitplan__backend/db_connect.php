<?php
    header('content-type: application/json');

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'fitplan_db';

    $conn = new mysqli($host, $user, $password, $database);

    if($conn -> connect_error){
        echo json_encode(['error' => 'Connection Failed:' .$conn -> connect_error]);
        exit();
    }
?>