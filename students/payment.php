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
    $user_total = trim($data['total'] ?? '');
    
    $curl = curl_init();

    $data = [
        "email" => "customer@domain.com",
        "amount" => $user_total, 
        "callback_url" => "http://localhost:54709/studentdash"
    ];

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer sk_test_1bc61b4143f3f54c3f52f5c24d92ce168d89bf3c",
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    echo json_encode(['message' => 'Cart items retrieved successfully', 'data' => $user_total]);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo "Response ". $response;
    }

    // $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    // $stmt->bind_param("s", $user_id);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // if ($result) {
    //     $cartItems = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $cartItems[] = $row;
    //     }

    //     header('Content-Type:application/json');
    //     echo json_encode(['message' => 'Cart items retrieved successfully', 'data' => $cartItems]);
    // } else {
    //     echo json_encode(['message' => 'No cart items found']);
    // }
   

    $stmt->close();
}

?>