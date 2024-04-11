<?php
    session_start();
    include("../database/connection.php");
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
                    <input type="text" name="username" placeholder = "Username" required>
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
                    <select name="accountRole">
                        <option hidden>Account Role</option>
                        <option>Administrator</option>
                        <option>Student</option>
                    </select>
                </div>
                <div class="textbox">
                    <select name="StudentID">
                        <option hidden>Account Role</option>
                        <?php
                            $sql = "SELECT student.studentID, student.firstname, student.lastname from student 
                            where student.studentID Not in (SELECT user.id FROM user LEFT JOIN student on student.studentID = user.id where student.studentID)";

                            $result =  $connection->query($sql);

                            if ($result->num_rows > 0) 
                            {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) 
                                    {
                                        ?>
                                            <option value = "<?=$row['studentID']?>" >
                                                <?= $row['firstname']." ".$row['lastname']?>
                                            </option>
                                        <?php
                                    }
                            }
                            $connection->close();
                        ?>
                    </select>
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