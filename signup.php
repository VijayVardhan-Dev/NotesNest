
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet"href="./assets/register.css">
</head>
<body>
   <div class="container">
    <div class="card">
        <div class="box">
            <div class="glass"></div>
            <div class="content">
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <div class="form">
    <form action = "register.php"method="POST">
    <p>Register</p>
    <input type="text" name="name" placeholder="Full Name" required><br>
        <input id = "mail"type="email" name="email" placeholder="Email" required>
        
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    </div>
   
    <div class="signup">
        <p>Already a member? <a href="login.php">Login</a></p>
    </div>
            </div>
        </div>
    </div>
   </div>
</body>
</html
