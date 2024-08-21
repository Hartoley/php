<?php
include("./database/connectdb.php");
// $first_name = $_POST['first_name'];
// $last_name = $_POST['last_name'];



if (isset($_POST['register'])) {
    if (empty($_POST['first_name'])) {
        die("First name is required");
        header("Location: forms.php?error= First name is required");
        return;
    }
    if (empty($_POST['last_name'])) {
        header("Location: forms.php?error= Last name is required");
        return;
    }

    if (empty($_POST['email'])) {
        header("Location: forms.php?error= Email is required");
        return;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
       die('Must be a valid email');
    }

    if (empty($_POST['password'])) {
        header("Location: forms.php?error= Password is required");
        return;
    }

    if (strlen($_POST['password']) < 8) {
        die('Password must not be less than 8 characters');
    }

    if (!preg_match('/[A-Z]/i', $_POST['password'])) {
        die('Password must contain a CAPITAL LETTER');
    }

    if (!preg_match('/[a-z]/i', $_POST['password'])) {
        die('Password must contain an alphabet');
    }


    if (!preg_match('/[0-9]/i', $_POST['password'])) {
        die('Password must contain a number');
    }


    if (empty($_POST['confirm_password'])) {
        header("Location: forms.php?error= Confirm Password is required");
        return;
    }

    if (($_POST['confirm_password'] !== $_POST['password'])) {
        header("Location: forms.php?error= Confirm Password and Password must match");
        return;
    }

    $hashpassword= password_hash($_POST['password'] , PASSWORD_DEFAULT);
    echo $hashpassword;
    echo "<br/>";
    $first_name = mysqli_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_escape_string($conn, $_POST['last_name']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    
    $sql = "INSERT INTO user (first_name, last_name, email, password) VALUE ('$first_name', '$last_name', '$email', '$hashpassword')";
    if (mysqli_query($conn, $sql)) {
       echo "data saved";
       header("Location: loggin.php");
    }else {
        mysql_error($conn);
        echo "data not saved";
   }

    $sql = "UPDATE";
    $sql = "DELETE";
}

// echo "My First name is " . $first_name . "<br/>";
// echo "My Last name is " . $last_name . "<br/>";

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: loggin.php");
 
}

?>