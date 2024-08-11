<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json');
 
    include 'db_connect.php';

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $routineID = $data['routineID'];

        $stmt = $conn->prepare('DELETE FROM tbl_routines WHERE routine_id = ?');
        $stmt->bind_param('i', $routineID);
        $stmt->execute();

        echo json_encode(['success' => 'Row Has Successfully Deleted']);
    
    }else{
        echo json_encode(['error' => 'No Data Received']);
    }

    $conn->close();
?>