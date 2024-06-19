<?php
include("../php_system/php/config.php");

session_start();
if (!isset($_SESSION['Id']) || $_SESSION['role'] != 'admin') {
    header('Location:../php_system/index-login.php');
    exit;
}

$message = '';

// 处理表单提交，生成邀请码
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 生成一个唯一的邀请码
    $code = bin2hex(random_bytes(8));

    // 检查邀请码是否已经存在
    $check_query = "SELECT * FROM invitations WHERE code = '$code'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $message = "The invitation code already exists, please try again.";
    } else {
        // 插入邀请码到数据库
        $insert_query = "INSERT INTO invitations (code) VALUES ('$code')";
        if ($conn->query($insert_query) === TRUE) {
            $message = "Invitation code generated successfully: $code";
        } else {
            $message = "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}

// 处理删除邀请码的请求
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = "DELETE FROM invitations WHERE id = $delete_id";

    if ($conn->query($delete_query) === TRUE) {
        $message = "The invitation code was deleted successfully.";
    } else {
        $message = "Error: " . $delete_query . "<br>" . $conn->error;
    }
}

// 查询所有未使用的邀请码
$result = $conn->query("SELECT * FROM invitations WHERE used = 0");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate invitation code</title>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('The invitation code has been copied to your clipboard');
            }, function(err) {
                console.error('Unable to copy to clipboard: ', err);
            });
        }
    </script>
</head>
<body>
<div class="right-links">
            <a href="../php_system/php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    <h1>Generate invitation code page</h1>
    <form method="post" action="">
        <input type="submit" value="Generate invitation code">
    </form>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <h2>Generated invitation code</h2>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $invitation_code = $row['code'];
            echo "<p>Invitation code: $invitation_code 
                  <button onclick=\"copyToClipboard('$invitation_code')\">copy</button>
                  <a href='?delete=" . $row['id'] . "'>delete</a></p>";
        }
    } else {
        echo "<p>No invitation code has been generated yet.</p>";
    }
    ?>
</body>
</html>

<?php
$conn->close();
?>