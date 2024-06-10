<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-login.css">
    <title>Login</title>
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
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            session_start();
            include ("php/config.php");

            if (isset($_POST['submit'])) {
                // 检查 'email' 和 'password' 是否存在
                if (isset($_POST['email']) && isset($_POST['password'])) {
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']);

                    // 查询数据库
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE Email='$email' AND Password='$password'") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);

                    if (is_array($row) && !empty($row)) {
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['username'] = $row['Username'];
                        $_SESSION['address'] = $row['Address'];
                        $_SESSION['id'] = $row['Id'];
                    } else {
                        echo "<div class='message'>
                    <p>Wrong Username or Password</p>
                  </div> <br>";
                        echo "<a href='index-login.php'><button class='btn'>Go Back</button></a>";
                    }

                    if (isset($_SESSION['valid'])) {
                        header("Location: home-login.php");
                    }
                } else {
                    echo "<div class='message'>
                <p>Please enter both email and password.</p>
              </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
                }
            } else {
                ?>
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
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        Don't have account? <a href="register.php">Sign Up Now</a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>

</body>

</html>