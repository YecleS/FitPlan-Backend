<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json');

    include 'db_connect.php';

    $data = json_decode(file_get_contents('php://input'), true);

    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $email = $data['email'];
    $username = $data['username'];
    $password = $data['password'];

    $stmt = $conn->prepare('INSERT INTO tbl_users (email, username, firstname, lastname, password) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $email, $username, $firstname, $lastname, $password);

    if($stmt->execute()){
        $userId = $stmt->insert_id;

        $stmt->prepare('SELECT id, username FROM tbl_users WHERE id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $results = $stmt->get_result();
        $user = $results->fetch_assoc();

        echo json_encode(['success' => 'Insertion Success', 'user_id' => $user['id'], 'username' => $user['username']]);
    }else {
        echo json_encode(['error' => 'Insertion Failed']);
    }

    $stmt->close();
    $conn->close();
?>