<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}
session_start();

include("../database/connectdb.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['items'])) {
        $product_id = (int) $data['items'];

        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE id = ?");
        $checkStmt->bind_param("i", $product_id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count == 0) {
            echo json_encode(['message' => 'Product not found']);
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        if (!$stmt) {
            echo json_encode(['message' => 'Error: Could not prepare statement']);
            exit();
        }

        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['message' => 'Product deleted successfully', 'data'=> $product_id]);
            } else {
                echo json_encode(['message' => 'No product found with the given ID']);
            }
        } else {
            echo json_encode(['message' => 'Error deleting product: ' . $stmt->error]);
        }

        $stmt->close();
        
    } else {
        echo json_encode(['message' => 'Invalid data']);
    }

}

?>
