<?php
// 创建数据库连接
$con = mysqli_connect("localhost","root","","Project-TT8L-08") or die("Couldn't connect");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// 处理文件上传
if(isset($_POST["submit"])) {
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // 将图像路径插入到数据库
    $image_path = $target_file;
    $sql = "INSERT INTO products (image) VALUES ('$image_path')";
    
    if ($con->query($sql) === TRUE) {
        echo "Image uploaded successfully and inserted into database.";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// 关闭数据库连接
$con->close();
?>
