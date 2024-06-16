<?php
// edit_product.php

require_once 'php_system/php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $editProductId = $_POST['editProductId'];
    $editName = $_POST['editName'];
    $editBrand = $_POST['editBrand'];
    $editPrice = $_POST['editPrice'];
    $editRating = $_POST['editRating'];

    // 更新数据库记录
    $sql = "UPDATE products SET name=?, brand=?, price=?, rating=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssdii", $editName, $editBrand, $editPrice, $editRating, $editProductId);

    if ($stmt->execute()) {
        // 更新成功
        // 可以选择在此处输出成功消息或重定向
        // 例如：
        // echo "Record updated successfully";

        // 关闭数据库连接
        $stmt->close();
        $conn->close();

        // 重定向回到原始页面
        header("Location: upload_product.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// 如果是 GET 请求，获取产品信息并返回 JSON
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // 查询产品信息
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 输出产品信息作为 JSON
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
