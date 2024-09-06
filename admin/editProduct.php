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

    if ($data && isset($data['id']) && isset($data['product_name']) && isset($data['product_price']) && isset($data['product_category']) && isset($data['product_description']) && isset($data['in_stock'])) {
        $id = (int) $data['id'];
        $product_name = $data['product_name'];
        $product_price = $data['product_price'];
        $product_category = $data['product_category'];
        $product_description = $data['product_description'];
        $in_stock = $data['in_stock'];

        $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_price = ?, product_category = ?, product_description = ?, in_stock = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $product_name, $product_price, $product_category, $product_description, $in_stock, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['message' => 'Product updated successfully']);
            } else {
                echo json_encode(['message' => 'No changes made or product not found']);
            }
        } else {
            echo json_encode(['message' => 'Error updating product: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['message' => 'Invalid data']);
    }
}

?>
