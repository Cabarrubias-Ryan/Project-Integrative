<?php
    session_start();
    include("../Navbar/Menu-NavBar.php");
    include("../Encryption/EncryptionProcess.php");


    if(!isset($_SESSION['loginChecker']))
    {
        header("Location: NoEntry.php");
    }
    if($_SESSION['loginChecker'] == false)
    {
        header("Location: NoEntry.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Signup.css">
    <title>Sign up</title>
</head>
<body>
    <section>
        <div class="SignUp-form">
            <h1>Sign Up</h1>
            <form action="createpro.php" method="post">
                <div class="textbox">
                    <input type="text" name="username" placeholder = "Username" value = "<?php echo isset($_GET['user']) ? htmlspecialchars(decryptData($_GET['user'])) : '';  ?>"required>
                    <?php if(isset($_GET['username'])): ?>
                        <?php if($_GET['username'] == "duplicate") : ?>
                            <strong>Username already been use.</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="textbox">
                    <input type="password" name="password" placeholder = "Password" required>

                    <?php if(isset($_GET['passwordcondition'])): ?>
                        <?php $invalidpasswordChecker = $_GET['passwordcondition'] ?>
                        <?php if($invalidpasswordChecker == "invalid") : ?>
                            <strong>Password must have at least 8 characters.</strong>
                        <?php elseif($invalidpasswordChecker == "UpperCase") : ?>
                            <strong>Password must have at least one Upper Case.</strong>
                        <?php elseif($invalidpasswordChecker == "LowerCase") : ?>
                            <strong>Password must have at least one Lower Case.</strong>
                        <?php elseif($invalidpasswordChecker == "Number") : ?>
                            <strong>Password must have at least one number.</strong>
                        <?php elseif($invalidpasswordChecker == "SpecialCharacter") : ?>
                            <strong>Password must have at least one special Character.</strong>
                        <?php endif ?>
                    <?php endif ?>     
                </div>
                <div class="textbox">
                    <input type="password" name="retypePassword" placeholder = "Re-Enter Password" required>
                    <?php if(isset($_GET['password'])): ?>
                        <?php $signupChecker = $_GET['password'] ?>
                        <?php if($signupChecker == "notmatch") : ?>
                            <strong>Your Password didn't match</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="textbox">
                    <input type="text" name="firstname" placeholder = "First Name" value = "<?php echo isset($_GET['firstname']) ? htmlspecialchars(decryptData($_GET['firstname'])) : '';  ?>" required>
                </div>
                <div class="textbox">
                    <input type="text" name="lastname" placeholder = "Last Name" value = "<?php echo isset($_GET['lastname']) ? htmlspecialchars(decryptData($_GET['lastname'])) : '';  ?>" required>
                    <?php if(isset($_GET['signup'])): ?>
                        <?php $signupChecker = $_GET['signup'] ?>
                        <?php if($signupChecker == "empty") : ?>
                            <strong>You should not enter a empty data</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="button">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </section>
</body>
</html>