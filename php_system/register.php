<?php
include ("php/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'buyer'; // 默认角色为买家
    $invitation_code = $_POST['invitation_code']; // 获取邀请码字段
    

    // 首先检查用户名是否已经存在
    $check_username_query = mysqli_query($conn, "SELECT * FROM users WHERE Username='$username'");
    if (mysqli_num_rows($check_username_query) > 0) {
        echo "<div class='message'><p>This username is already taken. Please choose a different username.</p></div>";
    } else {
        // 检查邀请码是否有效且未使用
        $check_invitation_query = mysqli_query($conn, "SELECT * FROM invitations WHERE code='$invitation_code' AND used=0");
        if (mysqli_num_rows($check_invitation_query) > 0 || $invitation_code === "") { // 允许邀请码为空
            // 插入新用户
            $sql = "INSERT INTO users (Username, Email, Address, Password, Role) VALUES ('$username', '$email', '$address', '$password', '$role')";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='message'><p>Registration successful!</p></div>";
                echo "<a href='index-login.php'><button class='btn'>Login Now</button></a>";
                // 更新邀请码状态为已使用
                if ($invitation_code !== "") {
                    mysqli_query($conn, "UPDATE invitations SET used=1 WHERE code='$invitation_code'");
                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "<div class='message'><p>Invalid or already used invitation code.</p></div>";
        }
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
    <title>Register</title>

    <script>
        function toggleInvitationCodeField() {
            var role = document.getElementById('role').value;
            var invitationCodeField = document.getElementById('invitation_code_field');

            if (role === 'seller') {
                invitationCodeField.style.display = 'block';
            } else {
                invitationCodeField.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
            <form action="" method="post" onsubmit="return validateForm()">
                <!-- 角色选择 -->
                <div class="field">
                    <label for="role">Account Type:</label>
                    <select name="role" id="role" onchange="toggleInvitationCodeField()">
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>
                 <!-- 邀请码字段，仅在选择卖家时显示 -->
                 <div class="field input" id="invitation_code_field" style="display: none;">
                    <label for="invitation_code">Invitation Code</label>
                    <input type="text" name="invitation_code" id="invitation_code" autocomplete="off">
                </div>
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register">
                </div>
                <div class="links">
                    Already have an account? <a href="index-login.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>