<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

session_start();
include("../database/connectdb.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['Id'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $cartItems = mysqli_fetch_assoc($result);

        header('Content-Type:application/json');
        echo json_encode(['message' => 'Cart items retrieved successfully', 'data' => $cartItems]);
    } else {
        echo json_encode(['message' => 'No cart items found']);
    }

    $stmt->close();
}