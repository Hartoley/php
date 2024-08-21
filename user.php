<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}
 include("./database/connectdb.php");
 $sql = "SELECT * FROM user";
 $res = mysqli_query($conn, $sql);
 
if ($res) {
    
    $rez = mysqli_fetch_all($res, MYSQLI_ASSOC);
     
    header('Content-Type: application/json');
    echo json_encode($rez);
} else {
    echo json_encode(["error" => "Error fetching data"]);
}

?>