<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('../database/connectdb.php');

    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data)) {
        $product_id = $data['product_id'] ?? '';
        $product_name = $data['product_name'] ?? '';
        $product_price = $data['product_price'] ?? '';
        $quantity = $data['quantity'] ?? '';
        $user_id = $data['user_id'] ?? '';

        // Sanitize input to prevent SQL injection
        $product_id = mysqli_real_escape_string($conn, $product_id);
        $product_name = mysqli_real_escape_string($conn, $product_name);
        $product_price = mysqli_real_escape_string($conn, $product_price);
        $quantity = mysqli_real_escape_string($conn, $quantity);
        $user_id = mysqli_real_escape_string($conn, $user_id);

        // Check if product already exists in the cart
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ss", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // If product exists, update its quantity
            $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("iis", $quantity, $user_id, $product_id);
            $stmt->execute();
            $message = "Product quantity updated in the cart.";
        } else {
            // If product doesn't exist, insert it into the cart
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $user_id, $product_id, $product_name, $product_price, $quantity);
            $stmt->execute();
            $message = "Product added to the cart.";
        }

        $stmt->close();

        echo json_encode(['message' => $message]);
    } else {
        echo json_encode(['message' => 'Invalid input data.']);
    }
}