<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json');

    include 'db_connect.php';
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        $user_Id = isset($data['user_Id']) ? $data['user_Id'] : null;
        $workoutName = isset($data['workoutName']) ? $data['workoutName'] : null;
        $scheduleArray = isset($data['schedule']) ? $data['schedule'] : [];
        $scheduleToString = implode(', ', $scheduleArray);
        $reps = isset($data['reps']) ? $data['reps'] : null;
        $sets = isset($data['sets']) ? $data['sets'] : null;
        $time = isset($data['time']) ? $data['time'] : null;

        $stmt = $conn->prepare('INSERT INTO tbl_routines (user_id, name, schedule, repetitions, sets, time) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issiis', $user_Id, $workoutName, $scheduleToString, $reps, $sets, $time);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'inserted']);
        } else {
            echo json_encode(['error' => 'Failed to execute SQL statement']);
        }
    } else {

        echo json_encode(['error' => 'Invalid data']);
    }

    $conn->close();
?>