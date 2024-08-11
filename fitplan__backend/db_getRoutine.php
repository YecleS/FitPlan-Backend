<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json');

    include 'db_connect.php';
    $data = json_decode(file_get_contents('php://input'), true);
    
    $user_id = $data['user_id'];

    $stmt = $conn->prepare('SELECT * FROM tbl_routines WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $results = $stmt->get_result();

    $routines = [];

    if($results->num_rows > 0){
        while($row = $results->fetch_assoc()){
            $routines[] = $row;
        }
        
        echo json_encode(['success' => $routines]);
    }else {
        echo json_encode(['error' => 'no data']);
    }

    $conn->close();
?>