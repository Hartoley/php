<?php
$conn = mysqli_connect("localhost", "root", "", "julyphp");

if ($conn) {
    // echo "Database connected";
   
}else {
    die(mysqli_error(). 'error');
}
?>