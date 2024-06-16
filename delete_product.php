<?php
// delete_product.php

require_once 'php_system/php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // 执行删除操作
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        http_response_code(200); // 成功响应
    } else {
        http_response_code(500); // 服务器错误
    }

    $stmt->close();
    $conn->close();
}
?>
