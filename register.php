<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-login.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action=""method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>

                </div>
                <div class="field input">
                    <label for="email ">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off">
                </div>

                <div class="field input">
                    <label for="age ">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                                
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" autocomplete="off" id="password" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Already have account? <a href="index-login.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>