<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include ("php_system/php/config.php");
    session_start();
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];

    $target_dir = "img/";
    $target_file = $target_dir . uniqid() . '_' . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    if ($_FILES["image"]["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }

    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_file_types)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (name, brand, price, rating, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssdis", $name, $brand, $price, $rating, $target_file);

        if ($stmt->execute()) {
            
            $stmt->close();
            $conn->close();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

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
<div class="right-links">
            <a href="php_system/php/logout.php"><button class="btn">Log Out</button></a>
        </div>
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
    $conn->close();
    ?>
        </tbody>
    </table>

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
        document.getElementById("editProductId").value = productId;

        fetch('edit_product.php?id=' + productId)
            .then(response => response.json())
            .then(data => {
                document.getElementById("editName").value = data.name;
                document.getElementById("editBrand").value = data.brand;
                document.getElementById("editPrice").value = data.price;
                document.getElementById("editRating").value = data.rating;
            });

        var modal = document.getElementById("editModal");
        modal.style.display = "block";
    }

    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            fetch('delete_product.php?id=' + productId, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Error deleting product');
                }
            });
        }
    }

    function closeModal() {
        var modal = document.getElementById("editModal");
        modal.style.display = "none";
    }
</script>

</body>
</html>
