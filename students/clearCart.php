<?php
include("../database/connectdb.php");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Methods');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

$user_data = json_decode(file_get_contents('php://input'), true);

if ($user_data) {
    $user_id = $user_data['Id'] ?? '';
    $user_email = $user_data['email'] ?? '';
    $user_total = trim($user_data['total'] ?? '');

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();


    $response = [
        "cart_message" =>  'Cart items DELETED successfully'
    ];


    echo json_encode($response);

    $stmt->close();
}




?>