<?php 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-type: application/json');

    include 'db_connect.php';

    $stmt = $conn->prepare('SELECT * FROM tbl_workouts');
    $stmt->execute();
    $result = $stmt->get_result();

    $fetchedRows = [];

    if($result->num_rows > 0){  
        while($rows = $result->fetch_assoc()){
            $fetchedRows[] = $rows;
        };

        echo json_encode($fetchedRows);
    }else {
        echo json_encode('no rows');
    }
?>