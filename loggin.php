<?php
include("./database/connectdb.php");
if (isset($_GET["message"])) {
    $message = $_GET["message"];
    echo $message;
};
if (isset($_POST['loggin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE email ='$email'";
    $response= mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($response);

    if ($result) {
        if (password_verify($password, $result['password'])) {
            // print_r($result);
            session_start();
            $token = bin2hex(random_bytes(16));
            $token_expire = time() + (60 * 10);
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;
            $_SESSION['firstName'] = $result['first_name'];
            $_SESSION['lastName'] = $result['last_name'];
            $_SESSION['id'] = $result['id'];
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['tokenExp'] = $token_expire;


            // header("Location: dashboard.php");
            header("Location: admin/admindash.php");
        } else { 
            echo "Invalid password";
        }
       
    }else {
        echo"Account does not exist";
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
    <form action="loggin.php" method="POST" class="w-50 mx-auto px-4 py-3 shadow">
        <input class="form-control my-3" name="email" type="email" placeholder="Email">
        <input class="form-control my-3" name="password"  type="password" placeholder="*********">
        <button name="loggin" class="btn btn-success my-3" >login</button>
    </form>
</body>
</html>