<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-login.css">
    <title>Register</title>
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
         
         include("php/config.php");
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $password = $_POST['password'];

            //verifying the unique email
        
            $verify_query = mysqli_query($conn, "SELECT Email FROM users WHERE Email='$email'");

            if (mysqli_num_rows($verify_query) != 0) {
                echo "<div class='message'>
                      <p>This email is used, Try another One Please!</p>
                  </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            } else {

                mysqli_query($conn, "INSERT INTO users(Username,Email,Address,Password) VALUES('$username','$email','$address','$password')") or die("Erroe Occured");

                echo "<div class='message'>
                      <p>Registration successfully!</p>
                  </div> <br>";
                echo "<a href='index-login.php'><button class='btn'>Login Now</button>";


            }

        }else{
        ?>
            <header>Sign Up</header>
            <form action=""method="post" onsubmit="return validateForm()">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>

                </div>
                <div class="field input">
                    <label for="email ">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off">
                </div>

                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" autocomplete="off" required>
                </div>
                                
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password"  id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already have account? <a href="index-login.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    
</body>
</html>