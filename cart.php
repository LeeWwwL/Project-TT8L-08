<?php

require_once 'connection.php';

$sql_cart = "SELECT * FROM cart";
$all_cart = $conn->query($sql_cart);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font/css/all.min.css">
    <link rel="stylesheet" href="cart.css">
    <title>In cart products</title>
</head>
<body>
    <?php
       include_once 'header.php';

    ?>
    
    <main>
        <h1>0 Items</h1>
        <hr>
        <div class="card">
            <div class="images">
                <img src="" alt="">
            </div>

            <div class="caption">
                <p class="rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </p>
                <p class="product_name">Product name</p>
                <p class="price"><b>$300</b></p>
                <p class="discount"><b><del>$450</del></b></p>
                <button class="remove">Remove from cart</button>
            </div>
        </div>
    <main>
        
    <script>
        var remove = document.getElementByClassName("remove");
        for(var i=0, i<remove.length; i++){
            remove[i].addEventListener("click",function(event){
                var g=target
            }
        }
    </script>