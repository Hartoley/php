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

    if ($data) {
        $product_name = $data['product_name'?? ''];
        $product_price = $data['product_price'?? ''];
        $quantity = $data['quantity'?? ''];

        $stmt = $conn->prepare("INSERT INTO cart (product_name, product_price, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $product_name, $product_price, $quantity);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Product added successfully']);
        } else {
            if (mysqli_errno($conn) === 1062) {
                echo json_encode(['message' => 'Product already exists']);
            } else {
                echo json_encode(['message' => 'Error: ' . mysqli_error($conn)]);
            }
        }

        $stmt->close();
    }
}
?>
