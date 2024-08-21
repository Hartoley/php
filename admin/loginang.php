<?php
    header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
   
   if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
       exit();
   };

   $data = json_decode(file_get_contents('php://input'), true);

   if ($data) {
    $email = $data['email'];
    $password = $data['password'];
    include("../database/connectdb.php");
    $sql = "SELECT * FROM user WHERE email ='$email'";
    $response= mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($response);
   

    if ($result) { 
        if (password_verify($password, $result['password'])) {
            if ($result['role'] !== "admin") {
                echo json_encode(["Location: adminlogin.php?message=You are not authorised to access this page"]);
                exit();
            
            }else {
                session_start();
                $token = bin2hex(random_bytes(16));
                $token_expire = time() + (60 * 100);
                $_SESSION['token'] = $token;
                $_SESSION['email'] = $email;
                echo json_encode([
                    'message' => 'Login to dashboard successful',
                    'token' => $token,
                    'email' => $email,
                    "success" => true,
                ]);
                // header("Location: createProduct.php");  
            };
           
        }else {
            echo json_encode(['message' => 'error occured while loggin into dashboard']);
        }
    }
    mysqli_close($conn);
   } else {
    echo json_encode(['message' => 'Invalid loggin data received']);
   }
   


?>