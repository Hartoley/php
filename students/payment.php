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

   
    $paystack_secret_key = 'sk_test_1bc61b4143f3f54c3f52f5c24d92ce168d89bf3c'; 
    $url = "https://api.paystack.co/transaction/initialize";
    $fields = [
        'email' => "customer@domain.com",
        'amount' => $user_total,
        'reference' => uniqid('PAYSTACK-')
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        echo json_encode(['message' => "cURL Error #:" . $err]);
    } 
    else {
        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] === true) {
         
            $data = [
                'message' => 'Payment initialization successful',
                'data' => [
                    'authorization_url' => $result['data']['authorization_url'],

                   
                ]
            ];
            
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'Payment initialization failed: ' . $result['message']]);
        }
    }

    // Uncomment the following section if you need to retrieve cart items
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

    // $stmt->close();
}

?>