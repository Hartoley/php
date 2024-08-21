<?php
include("./database/connectdb.php");
if (isset($_GET['error'])) {
    $message =$_GET['error'];
    echo "<h6>" . $message . "</h6>";
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
        <form action="processForm.php" method="POST" class="w-50 mx-auto px-4 py-3 shadow">
            <h1>Register</h1>
            <?php  
                
            ?>
            <input class="form-control my-3"  name="first_name" type="text" placeholder="First Name">
            <input class="form-control my-3" name="last_name"  type="text" placeholder="Last Name">
            <input class="form-control my-3" name="email" type="email" placeholder="Email">
            <input class="form-control my-3" name="password"  type="password" placeholder="Password">
            <input class="form-control my-3" name="confirm_password"  type="password" placeholder="Confirm Password">
            <button name="register" class="btn btn-success my-3" >Register</button>

        </form>
    </main>
</body>
</html>