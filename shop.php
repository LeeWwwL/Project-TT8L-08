<?php

require_once 'php_system/php/config.php';
$logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true;
$sql = "SELECT * FROM product_first";
$all_product = $conn->query($sql);

if(isset($_POST["add"])){
    $productId = $_GET["id"];
    $productName = $_POST["hidden_name"];
    $productImage = $_POST["hidden_image"];
    $productPrice = $_POST["hidden_price"];
    $productQuantity = $_POST["quantity"];

    $sql = "INSERT INTO product_second (id, description, image, price, quantity) VALUES ('$productId', '$productName', '$productImage', '$productPrice', '$productQuantity');";
    mysqli_query($conn, $sql);
}

require_once 'php_system/php/config.php';

$sql = "SELECT * FROM product_first";
$all_product = $conn->query($sql);

session_start();
$logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <section id="header">
        <a href="#"><img src="img/logo.png" class="logo" alt="Company Logo"></a>

        <nav>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="shop.php">Shop</a></li>
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
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
            </ul>
        </nav>

        <div id="mobile">
            <i id="bar" class="fas fa-outdent"></i>
            <a href="cart.html"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="page-header">

        <h2>#stayhome</h2>

        <p>Save more with coupons & up to 70% off!</p>


    </section>
    <main>
        <div class="container">
            <?php
            $query = "SELECT * FROM product_first ORDER BY id ASC";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    ?>
                    <div class="product">
                        <form action="shop.php?action=add&id=<?php echo $row["id"]?>"method="post">
                        
                            <div class="image">
                                <img src="<?php echo $row["image"]; ?>" alt="Pendant" style="width: 150px; height: 150px;">
                            </div>
                            <h3><?php echo $row["description"]?></h3>
                            <p>RM<?php echo $row["price"];?></p>
                            <input type="text" id="quantity" name="quantity" value="1">
                            <input type="hidden" name="hidden_image" value="<?php echo $row["image"];?>">
                            <input type="hidden" name="hidden_name" value="<?php echo $row["description"];?>">
                            <input type="hidden" name="hidden_price" value="<?php echo $row["price"];?>">
                            <input type="submit" name="add" value="Add to Cart">
                        </div>  
                        </form> 
                    </div>    
                    <?php
                }
            }
?>            

    </main>
    
        
    <script>
        var product_id = document.getElementsByClassName("add");
        for (var i = 0; i < product_id.length; i++) {
            product_id[i].addEventListener("click", function (event) {
                var target = event.target;
                var id = target.getAttribute("data-id");
                var xml = new XMLHttpRequest();
                xml.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        target.innerHTML = data.in_cart;
                        document.getElementById("badge").innerHTML = data.num_cart + 1;
                    }
                }

                xml.open("GET", "connection.php?id=" + id, true);
                xml.send();

            })
        }

    </script>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletter</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img src="img/logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong> 562 Wellington Road, Street 32, San Francisco</p>
            <p><strong>Phones:</strong> +01 2222 365 /(+91) 01 2345 6789</p>
            <p><strong>Hours:</strong> 10.00-18.00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>About</h4>
            <a href="#">About us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>

        <div class="install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="img/pay/app.jpg" alt="">
                <img src="img/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways</p>
            <img src="img/pay/pay.png" alt="">
        </div>
        <div class="copyright">
            <p>@ 2021, Tech2 etc - HTML CSS Ecommerce Template</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>



</html>
</head>