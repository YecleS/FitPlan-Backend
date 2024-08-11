<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json');

    include 'db_connect.php';

        // Get data from the client
        $data = json_decode(file_get_contents('php://input'), true);

    // Check if the sent data is null
    if( !empty($data['username']) && !empty($data['password']) ){
        //Destructure the received data
        $username = $data['username'];
        $password = $data['password'];

        //Prepare the query
        $stmt = $conn->prepare('SELECT * FROM tbl_users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $fetchedData = $result->fetch_assoc();
            if($password === $fetchedData['password']){
                echo json_encode([
                    'id' => $fetchedData['id'],
                    'username' => $fetchedData['username'],
                    'success' => 'Login Successfully'
                ]);
            }else {
                echo json_encode(['error' => 'Incorrect Password']);
            }
        }else {
            echo json_encode(['error' => 'User Not Registered']);
        }
        
    }else {
        echo json_encode(['error' => 'Invalid Username & Password']);
    }
    
    $conn->close();
?>