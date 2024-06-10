<?php
session_start();

include ("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index-login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-login.css">
    <title>Home</title>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home-login.php">Logo</a></p>
        </div>

        <div class="right-links">
            <?php

            $id = $_SESSION['id'];
            $query = mysqli_query($conn, "SELECT*FROM users WHERE Id=$id");

            while ($result = mysqli_fetch_assoc($query)) {
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Address = $result['Address'];
                $res_id = $result['Id'];
            }

            echo "<a href='edit.php?Id=$res_id'>Change Profile</a>";
            ?>

            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
        <main>
            <div class="main-box top">
                <div class="top">
                    <div class="box">
                        <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
                    </div>
                    <div class="box">
                        <p>Your email is <b><?php echo $res_Email ?></b>, Welcome</p>
                    </div>
                </div>
                <div class="bottom">
                    <div class="box">
                        <p>And you are address is </address><b><?php echo $res_Address ?></b>.</p>
                    </div>
                    <div class="main-box bottom">
                        <div class="box">
                            <a href="../index.html"><button class="btn">Continue</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

</body>

</html>