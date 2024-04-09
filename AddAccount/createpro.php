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
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $UsernameDuplicate = "SELECT * from user WHERE username = '".$username."'";
        $resultOfQuery = $connection->query($UsernameDuplicate);

        if($resultOfQuery->num_rows > 0)
        {
            header("Location: SignUp.php?username=duplicate&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
        }
        else if(empty($username) || empty($password) || empty($firstname) || empty($lastname))
        {
            header("Location: SignUp.php?signup=empty&user=". urlencode(encryptData($username))."&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
        }
        else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/",$password))
        {
            
            if(!preg_match("/[A-Z]/",$password))
            {
                header("Location: SignUp.php?passwordcondition=UpperCase&user=". urlencode(encryptData($username))."&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
            }
            else if(!preg_match("/[a-z]/",$password))
            {
                header("Location: SignUp.php?passwordcondition=LowerCase&user=". urlencode(encryptData($username))."&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
            }
            else if(!preg_match("/\d/",$password))
            {
                header("Location: SignUp.php?passwordcondition=Number&user=". urlencode(encryptData($username))."&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
            }
            else if(!preg_match("/\W/",$password))
            {
                header("Location: SignUp.php?passwordcondition=SpecialCharacter&user=". urlencode(encryptData($username))."&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
            }
            else if(strlen($password) < 8)
            {
                header("Location: SignUp.php?passwordcondition=invalid&user=". urlencode(encryptData($username))."&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
            }
        }
        else if($password !== $reTrypassword)
        {
            header("Location: SignUp.php?password=notmatch&user=". urlencode(encryptData($username))."&firstname=". urlencode(encryptData($firstname))."&lastname=". urlencode(encryptData($lastname)));
        }
        else
        {
            // Count the number of rows in the 'student' table  
            $sqlIndex = "SELECT * FROM user ORDER By Id DESC limit 1";
            $result = $connection->query($sqlIndex);
            
            $Data = $result->fetch_assoc();
            $StudentID = $Data['id'] + 1;
            // Insert into 'user' table
            $sqlUSER = "INSERT INTO user(username, password, accountrole, created_at, deleted_at, update_at) 
                        VALUES('".$username."' , '".password_hash($password,PASSWORD_BCRYPT)."' , 'Student', CURRENT_TIMESTAMP(), NULL, NULL)";

            // Insert into 'student' table
            $sqlStudent = "INSERT INTO student(studentID, firstname, middlename, lastname, course, major, birthday,created_at, updated_at, deleted_at)
                VALUES( $StudentID,'". $firstname."' , NULL, '".$lastname."', 'BS INFORMATON TECHNOLOGY', 'PROGRAMMING', CURRENT_DATE() ,  CURRENT_TIMESTAMP(), NULL, NULL)";

            if($connection->query($sqlUSER) === TRUE && $connection->query($sqlStudent) === TRUE) 
            {
                header("Location:checkMessage.php");
            } 
            else 
            {
                echo "Error: " . $connection->error;
            }
        }

        $connection->close();
    }
    else
    {
        header("Location: SignUp.php");
    }

    
?>
