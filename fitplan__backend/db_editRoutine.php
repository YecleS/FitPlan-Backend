<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json');


    include 'db_connect.php';
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(!empty($data)){
        $routineId = $data['routineID'];
        $schedule = $data['schedule'];
        $scheduleToString = implode(', ', $schedule);
        $reps = $data['reps'];
        $sets = $data['sets'];
        $time = $data['time'];

        $stmt = $conn->prepare('UPDATE tbl_routines SET schedule = ?, repetitions = ?, sets = ?, time = ? WHERE routine_id = ?');
        $stmt->bind_param('siisi', $scheduleToString, $reps, $sets, $time, $routineId);

        if($stmt->execute()){
            echo json_encode(['success' => 'Row Updated']);
        }else {
            echo json_encode(['error' => $stmt->error]);
        }

    }else {
        echo json_encode(['error' => 'Data is empty']);
    }

    $conn->close();
?>