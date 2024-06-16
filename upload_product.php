<?php
// 启用错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 连接到数据库
    include ("php_system/php/config.php");
    session_start();
    // 获取表单输入
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];

    // 处理上传的图像文件
    $target_dir = "img/";
    $target_file = $target_dir . uniqid() . '_' . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 检查文件是否为图像
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // 检查文件大小（例如，不超过5MB）
    if ($_FILES["image"]["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }

    // 允许的文件格式
    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_file_types)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // 尝试上传文件
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // 插入数据库记录
        $sql = "INSERT INTO products (name, brand, price, rating, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssdis", $name, $brand, $price, $rating, $target_file);

        if ($stmt->execute()) {
            // 关闭连接和语句
            $stmt->close();
            $conn->close();

            // 重定向到当前页面的 GET 请求，避免重复提交
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// 查询产品列表
include("php_system/php/config.php");
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Upload Product</title>
</head>
<body>
    <h2>Upload Product</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <button type="submit">Upload</button>
    </form>

    <hr>

 <!-- 列表展示已有的产品 -->
 <h2>Products List</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Rating</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 假设 $result 是从数据库查询得到的产品结果集
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["brand"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["price"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["rating"]) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($row["image_url"]) . '" alt="Product Image" class="product-image"></td>';
                    echo '<td><button onclick="editProduct(' . $row["id"] . ')">Edit</button> <button onclick="deleteProduct(' . $row["id"] . ')">Delete</button></td>';
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='6'>0 results</td></tr>";
            }
    // 关闭连接
    $conn->close();
    ?>
        </tbody>
    </table>

<!-- 模态框 -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Product</h2>
        <form id="editForm" action="edit_product.php" method="post">
            <input type="hidden" id="editProductId" name="editProductId">
            <label for="editName">Product Name:</label>
            <input type="text" id="editName" name="editName" required><br>

            <label for="editBrand">Brand:</label>
            <input type="text" id="editBrand" name="editBrand" required><br>

            <label for="editPrice">Price:</label>
            <input type="number" step="0.01" id="editPrice" name="editPrice" required><br>

            <label for="editRating">Rating (1-5):</label>
            <input type="number" id="editRating" name="editRating" min="1" max="5" required><br>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
    function editProduct(productId) {
        // 使用 JavaScript 或 jQuery 填充模态框中的表单字段
        // 这里可以使用 AJAX 请求获取产品详细信息并填充表单字段
        document.getElementById("editProductId").value = productId;

        // 假设你已经在后端实现了一个根据产品 ID 获取详细信息的接口 edit_product.php
        fetch('edit_product.php?id=' + productId)
            .then(response => response.json())
            .then(data => {
                document.getElementById("editName").value = data.name;
                document.getElementById("editBrand").value = data.brand;
                document.getElementById("editPrice").value = data.price;
                document.getElementById("editRating").value = data.rating;
            });

        // 打开模态框
        var modal = document.getElementById("editModal");
        modal.style.display = "block";
    }

    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            // AJAX 请求来删除产品
            fetch('delete_product.php?id=' + productId, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    // 删除成功后刷新页面或更新产品列表
                    window.location.reload(); // 重新加载页面
                } else {
                    console.error('Error deleting product');
                }
            });
        }
    }

    function closeModal() {
        // 关闭模态框
        var modal = document.getElementById("editModal");
        modal.style.display = "none";
    }
</script>

</body>
</html>
