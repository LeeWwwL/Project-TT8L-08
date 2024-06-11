<?php

// 启用错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 连接到数据库
$conn = mysqli_connect("localhost", "root", "", "Project-TT8L-08");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 获取表单输入
$name = $_POST['name'];
$brand = $_POST['brand'];
$price = $_POST['price'];
$rating = $_POST['rating'];
$image = $_FILES['image'];

// 检查并创建上传目录
$target_dir = "img/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($image["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// 检查文件是否为图像
$check = getimagesize($image["tmp_name"]);
if ($check === false) {
    die("File is not an image.");
}

// 检查文件大小（例如，不超过5MB）
if ($image["size"] > 5000000) {
    die("Sorry, your file is too large.");
}

// 允许的文件格式
$allowed_file_types = array("jpg", "jpeg", "png", "gif");
if (!in_array($imageFileType, $allowed_file_types)) {
    die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
}

// 尝试上传文件
if (move_uploaded_file($image["tmp_name"], $target_file)) {
    // 成功上传文件，插入数据库记录
    $sql = "INSERT INTO products (name, brand, price, rating, image_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssdis", $name, $brand, $price, $rating, $target_file);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Sorry, there was an error uploading your file.";
}

$conn->close();
?>
