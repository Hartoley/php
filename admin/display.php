<?php
    header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
   
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit();
    };
    session_start();
    include("../database/connectdb.php");
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql); 
    
    if ($result) {
        $result= mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($result);
    }else{
        echo json_encode(['message' => 'error occured while fetching products']);
    }
  
   

?>