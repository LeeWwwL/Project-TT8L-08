<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
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
    <title>Change Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home-login.php">Logo</a></p>
        </div>

        <div class="right-links">
            <a href="#">Change Profile</a>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
        <?php 
               if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $address = $_POST['address'];

                $id = $_SESSION['id'];

                $edit_query = mysqli_query($con,"UPDATE users SET Username='$username', Email='$email', Address='$address' WHERE Id=$id ") or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Profile Updated!</p>
                </div> <br>";
              echo "<a href='home-login.php'><button class='btn'>Go Home</button>";
       
                }
               }else{

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Address = $result['Address'];
                }

            ?>
            <header>Change Profile</header>
            <form action=""method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?> "autocomplete="off" required>

                </div>
                <div class="field input">
                    <label for="email ">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off">
                </div>

                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="<?php echo $res_Address; ?>" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>