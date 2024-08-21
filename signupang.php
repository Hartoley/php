<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
    

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit();
    }
        // header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
    

        if ($data) {
            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $email = $data['email'];
            $password = $data['password'];

           include("./database/connectdb.php");
        
            $sql = "INSERT INTO user (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['message' => 'Registration successful']);
                
            } else {

                if (mysqli_errno($conn) === 1062) {
                    echo json_encode(['message' => 'Email already exists']);
                } else {
                    echo json_encode(['message' => 'Error: ' . mysqli_error($conn)]);
                }
            }
        
            mysqli_close($conn);
        } else {
            echo json_encode(['message' => 'Invalid data received']);
        }
?>