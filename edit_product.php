<?php
// edit_product.php

require_once 'php_system/php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editProductId = $_POST['editProductId'];
    $editDescription = $_POST['editDescription'];
    $editPrice = $_POST['editPrice'];

    $sql = "UPDATE product_first SET description=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sdi", $editDescription, $editPrice, $editProductId);

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();


        header("Location: upload_product.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM product_first WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        echo "Product not found";
    }

    $stmt->close();
    $conn->close();
}
?>