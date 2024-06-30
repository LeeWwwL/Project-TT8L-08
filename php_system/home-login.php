<?php
session_start();

include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index-login.php");
    exit;
}

$id = $_SESSION['Id'];

$query = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $res_Uname = $row['username'];
    $res_Email = $row['email'];
    $res_Address = $row['address'];
    $res_id = $row['id'];
} else {
    die("User not found.");
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
            <a href="edit.php?Id=<?php echo $res_id ?>">Change Profile</a>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
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
                    <p>And your address is <b><?php echo $res_Address ?></b>.</p>
                </div>
                <div class="main-box bottom">
                    <div class="box">
                        <a href="../index.php"><button class="btn">Continue</button></a>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>

