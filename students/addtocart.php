<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("../database/connectdb.php");

    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['items'])) {
        $items = $data['items'];

        foreach ($items as $item) {
            $product_name = $item['product_name'] ?? '';
            $product_price = $item['product_price'] ?? '';
            $quantity = $item['quantity'] ?? 1;   
            $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE product_name = ? AND product_price = ?");
            $stmt->bind_param("ss", $product_name, $product_price);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $current_quantity = $row['quantity'];
                
                $new_quantity = $current_quantity + 1; 

                $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE product_name = ? AND product_price = ?");
                $stmt->bind_param("iss", $new_quantity, $product_name, $product_price);
            } else {
                $stmt = $conn->prepare("INSERT INTO cart (product_name, product_price, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $product_name, $product_price, $quantity);
            }

            if (!$stmt->execute()) {
                echo json_encode(['message' => 'Error: ' . $stmt->error]);
                exit();
            }

            $stmt->close();
        }

        echo json_encode(['message' => 'Cart updated successfully']);
    } else {
        echo json_encode(['message' => 'Invalid data']);
    }
}

?>
