<?php
include("php/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 这里假设你在数据库中存储的是明文密码，这样不安全。最好使用哈希函数（如 password_hash 和 password_verify）
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    

    if ($row) {
        $_SESSION['Id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['address'] = $row['address'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['valid'] = true;
        $_SESSION['user_logged_in'] = true;
       

        if ($row['role'] == 'admin') {
            header('Location: ../admin/admin_generate_invite.php');
            exit;
        } elseif ($row['role'] == 'seller') {
            header('Location: ../upload_product.php');
            exit;
        } else {
            header('Location: home-login.php');
            exit;
        }
    } else {
        echo "<div class='message'><p>Invalid email or password.</p></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-login.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post" onsubmit="return validateForm()">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
