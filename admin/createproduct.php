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

    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['product_price'] ?? '';
    $product_category = $_POST['product_category'] ?? '';
    $product_description = $_POST['product_description'] ?? '';
    $in_stock = $_POST['in_stock'] ?? '';
    
    if (isset($_FILES['product_img'])) {
        $img_path = "images/";
        if (!file_exists($img_path)) {
            mkdir($img_path, 0777, true);
        }

        $file_name = basename($_FILES['product_img']['name']);
        $file = $img_path . $file_name;

        if (move_uploaded_file($_FILES['product_img']['tmp_name'], $file)) {
            $stmt = $conn->prepare("INSERT INTO products (product_name, product_price, product_category, product_desc, in_stock, product_img) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $product_name, $product_price, $product_category, $product_description, $in_stock, $file);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Product created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'File upload failed']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    }

    $conn->close();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: adminlogin.php");
    exit();
}
?>
