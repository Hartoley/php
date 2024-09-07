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
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : null;
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : null;
    $product_category = isset($_POST['product_category']) ? $_POST['product_category'] : null;
    $product_description = isset($_POST['product_description']) ? $_POST['product_description'] : null;
    $in_stock = isset($_POST['in_stock']) ? $_POST['in_stock'] : null;

    if ($id && $product_name && $product_price && $product_category && $product_description && $in_stock) {
        $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_price = ?, product_category = ?, product_desc = ?, in_stock = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $product_name, $product_price, $product_category, $product_description, $in_stock, $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            echo json_encode(['message' => 'Error updating product: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['message' => 'Invalid data']);
    }
}


?>
