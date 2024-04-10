<?php 
    session_start();
    include("Encryption/EncryptionProcess.php");
    $_SESSION['loginChecker'] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="css/indexDesign.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="Login/loginpro.php" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder = "Username" value = "<?php echo isset($_GET['fullname']) ? htmlspecialchars(decryptData($_GET['username'])) : '';  ?>" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password"  placeholder = "Password" required>
                <i class='bx bxs-lock-alt'></i>
                <?php if(isset($_GET['login'])): ?>
                    <?php $logincon = $_GET['login'] ?>
                    <?php if($logincon == "error") : ?>
                        <strong>Invalid Username or Password</strong>
                    <?php endif ?>
                <?php endif ?>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox" name="#" id="#">Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>
            <div class ="button">
                <input type="submit" value="login">
            </div>
            <div class="register-link">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>