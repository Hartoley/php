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
            $product_id = $item['id'];

            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
            $stmt->bind_param("i", $product_id);

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
