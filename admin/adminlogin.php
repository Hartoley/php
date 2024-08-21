<?php
    header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
   
   if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
       exit();
   };

   
    if ($_GET['message']) {
        $message = $_GET['message'];
        echo $message;
}
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        include ("../database/connectdb.php");
        $sql = "SELECT * FROM user WHERE email='$email'";
        $response = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($response);

        if ($result) {
            // if ($result['password'] !== $password) {
            //     header("Location: adminlogin.php?message=Incorrect details");
            //     echo "Incorrect details";
            //     return;
            // }
            if ($result['role'] !== "admin") {
                header("Location: adminlogin.php?message=You are not authorised to access this page");
                exit();
            }
            session_start();
            $token = bin2hex(random_bytes(16));
            $token_expires = time() + (60 * 10);
            $_SESSION['token'] = $token;
            $_SESSION['role'] = $result['role'];
            $_SESSION['email'] = $email;
            $_SESSION['tokenExp'] = $token_expires;
            header("Location: createProduct.php");
        }else{
            header("Location: adminlogin.php?message=user doesn't exist");
        }
    }

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <main>
        <form class="w-50 mx-auto px-4 py-3 shadow"  action="adminlogin.php" method="POST">
            <input class="form-control my-3" type="email" placeholder="Email" name="email">
            <input class="form-control my-3" type="password" placeholder="*" name="password">
            <button class="btn btn-success my-3"  name="login">Login</button>
        </form>
    </main>
</body>
</html>