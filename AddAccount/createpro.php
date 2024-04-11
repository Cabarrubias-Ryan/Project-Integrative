<?php
    session_start();
    include("../database/connection.php");
    include("../Encryption/EncryptionProcess.php");

    if(!isset($_SESSION['loginChecker']))
    {
        header("Location: NoEntry.php");
    }
    if($_SESSION['loginChecker'] == false)
    {
        header("Location: NoEntry.php");
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $reTrypassword = $_POST['retypePassword'];
        $accountrole = $_POST['accountRole'];
        $StudentId = $_POST['StudentID'];

        $UsernameDuplicate = "SELECT * from user WHERE username = '".$username."'";
        $resultOfQuery = $connection->query($UsernameDuplicate);

        if($resultOfQuery->num_rows > 0)
        {
            header("Location: SignUp.php?username=duplicate");
        }
        else if(empty($username) || empty($password) || empty($accountrole) || empty($StudentId))
        {
            header("Location: SignUp.php?signup=empty&user=". urlencode(encryptData($username)));
        }
        else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/",$password))
        {
            
            if(!preg_match("/[A-Z]/",$password))
            {
                header("Location: SignUp.php?passwordcondition=UpperCase&user=". urlencode(encryptData($username)));
            }
            else if(!preg_match("/[a-z]/",$password))
            {
                header("Location: SignUp.php?passwordcondition=LowerCase&user=". urlencode(encryptData($username)));
            }
            else if(!preg_match("/\d/",$password))
            {
                header("Location: SignUp.php?passwordcondition=Number&user=". urlencode(encryptData($username)));
            }
            else if(!preg_match("/\W/",$password))
            {
                header("Location: SignUp.php?passwordcondition=SpecialCharacter&user=". urlencode(encryptData($username)));
            }
            else if(strlen($password) < 8)
            {
                header("Location: SignUp.php?passwordcondition=invalid&user=". urlencode(encryptData($username)));
            }
        }
        else if($password !== $reTrypassword)
        {
            header("Location: SignUp.php?password=notmatch&user=". urlencode(encryptData($username)));
        }
        else
        {
            $sqlUSER = "INSERT INTO user (id, username, password, accountrole, student_id, created_at, deleted_at, update_at) 
            VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), NULL, NULL)";

            $stmt = $connection->prepare($sqlUSER);
            if ($stmt) {
                // Bind parameters
                $stmt->bind_param("isssi", $StudentId, $username, password_hash($password,PASSWORD_BCRYPT), $accountrole, $StudentId);

                // Execute the statement
                $stmt->execute();

                // Check for errors
                if ($stmt->error) {
                    echo "Error: " . $stmt->error;
                } else {
                    header("Location:checkMessage.php");
                }

                // Close statement
                $stmt->close();
            } else {
                echo "Error in preparing statement: " . $connection->error;
            }
        }

        $connection->close();
    }
    else
    {
        header("Location: SignUp.php");
    }

    
?>
