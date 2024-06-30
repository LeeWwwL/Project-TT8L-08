<?php
// delete_product.php

require_once 'php_system/php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "DELETE FROM product_first WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        http_response_code(200); 
    } else {
        http_response_code(500); 
    }

    $stmt->close();
    $conn->close();
}
?> 