<?php
include("php_system/php/config.php");
session_start();
$logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true;

if(!$conn){
    echo "Failed to Connect";
}

if(isset($_GET["action"]) && $_GET["action"] == "delete"){
    $productName = $_GET["name"];
    $deleteQuery = "DELETE FROM `product_second` WHERE description = '$productName'";
    mysqli_query($conn, $deleteQuery);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li id="login-logout">
                    <?php if ($logged_in): ?>
                        <a href="php_system/php/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="php_system/index-login.php">Login</a>
                    <?php endif; ?>
                </li>
                <li id="lg-bag"><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
        </ul>
    </nav>
    <h3>Cart</h3>
    <div class="table_container">
        <table>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Quatity</th>
                <th>Total Price</th>
                <th>Remove Item</th>
            </tr>
            <?php
            $query = "SELECT * FROM `product_second` ORDER BY id ASC";
            $result = mysqli_query($conn, $query);
            $total = 0;
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td><div class="image">
                                <img src="<?php echo $row["image"]; ?>" alt="" style="width: 150px; height: 150px;">
                        </div></td>
                        <td><?php echo $row["description"];?></td>
                        <td><?php echo $row["price"];?></td>
                        <td><?php echo $row["quantity"];?></td>
                        <td><?php echo number_format($row["quantity"]*$row["price"],2);?></td>
                        <td><a href="cart.php?action=delete&name=<?php echo $row["description"];?>"><span>Remove Item</span></a></td>
                        <?php
                        $total = $total + ($row["quantity"]*$row["price"]);
                    }
                }
                ?>
                </tr>
                <tr></tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td><?php echo number_format($total, 2);?></td>
                    <td><button>Proceed to Payment</button></td>
                </tr>
        </table>
    </div>
</body>
</html>