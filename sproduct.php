<?php
// 创建数据库连接
$con = mysqli_connect("localhost", "root", "", "Project-TT8L-08") or die("数据库连接失败：" . mysqli_connect_error());

// 查询数据库，获取产品图像路径
$sql = "SELECT image FROM products";
$result = mysqli_query($con, $sql);

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
            <li><a href="index.html">Home</a></li>
            <li><a class=active href="shop.html">Shop</a></li>
            <li><a href="blog.html">Blog</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li id="lg-bag"><a href="cart.html"><i class="far fa-shopping-bag"></i></a></li>
            <a href="#" id="close"><i class="far fa-times"></i></a>
        </ul>
    </nav>

    <div id="mobile">
        <i id="bar" class="fas fa-outdent"></i>
        <a href="cart.html"><i class="far fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
    </div>
</section>

<section id="prodetails" class="section-p1">
    <div class="single-pro-image">
        <?php
        // 检查是否获取到了图像路径
        if (mysqli_num_rows($result) > 0) {
            // 遍历结果集，输出每个产品图像
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<img src="' . $row['image'] . '" width="100%" id="MainImg" alt="">';
            }
        } else {
            echo "没有找到产品图像。";
        }
        ?>
    </div>
    <div></div>
</section>

<div class="single-pro-details">
    <h6>Home / T-Shirt</h6>
    <h4>Men's Fashion T Shirt</h4>
    <h2>$139.00</h2>
    <select>
        <option>Select Size</option>
        <option>XL</option>
        <option>XXL</option>
        <option>Small</option>
        <option>Large</option>
    </select>
    <input type="number" value="1">
    <button class="normal">Add To Cart</button>
    <h4>Products Details</h4>
    <span>The Gildan Ultra Cotton T-Shirt is made from a substantial 6.0 oz. per sq. yd. fabric constructed from
            100% cotton, this classic fit preshunk jersey knit provides unmatched comfort with each wear. Featuring a
            taped neck and shoulder, and a seamless double-needle collar, and available in a range if colors, it offers
            it all in ultimate head-turning package.</span>
</div>
</section>

<section id="product1" class="section-p1">
    <h2>New Arrivals</h2>
    <p>Summer Collection New Modern Design</p>
    <div class="pro-container">
        <div class="pro">
            <img src="img/products/n1.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fal fa-shopping-cart"></i></a>
        </div>
        <div class="pro">
            <img src="img/products/n2.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fal fa-shopping-cart"></i></a>
        </div>
        <div class="pro">
            <img src="img/products/n3.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fal fa-shopping-cart"></i></a>
        </div>
        <div class="pro">
            <img src="img/products/n4.jpg" alt="">
            <div class="des">
                <span>adidas</span>
                <h5>Cartoon Astronaut T-Shirts</h5>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h4>$78</h4>
            </div>
            <a href="#"><i class="fal fa-shopping-cart"></i></a>
        </div>
    </div>
</section>

<!-- 省略部分其他内容 -->

</body>
</html>

<?php
// 关闭数据库连接
mysqli_close($con);
?>