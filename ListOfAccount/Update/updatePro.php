<?php
    session_start();
    include("../../database/connection.php");

    if(!isset($_SESSION['EditChecker']))
    {
        header("Location: ../listofAccount.php");
    }
    if($_SESSION['EditChecker'] == false)
    {
        header("Location: ../listofAccount.php");
    }
    if(!isset($_SESSION['loginChecker']))
    {
        header("Location: ../NoEntry.php");
    }
    if($_SESSION['loginChecker'] == false)
    {
        header("Location: ../NoEntry.php");
    }

    $id         = $_POST['hiddenId'];
    $StudentID  = $_POST['hiddenStudentId'];
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $firstname  = $_POST['firstname'];
    $lastname   = $_POST['lastname'];
    $course     = $_POST['course'];
    $major      = $_POST['major'];
    $birthday   = $_POST['birthday'];
    $role       = $_POST['accountRole'];

    $UsernameDuplicate = "SELECT * from user WHERE username = '".$username."'";

    $resultOfQuery = $connection->query($UsernameDuplicate);

    if($resultOfQuery) //Error Trappings
    {
        header("Location: Editpro.php?username=duplicate");
    }
    if(empty($username) || empty($password) || empty($accountrole) || empty($StudentId))
    {
            header("Location: Editpro.php?signup=empty");
    }
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/",$password))
    {
            
        if(!preg_match("/[A-Z]/",$password))
        {
            header("Location: Editpro.php?passwordcondition=UpperCas");
        }
        else if(!preg_match("/[a-z]/",$password))
        {
            header("Location: Editpro.php?passwordcondition=LowerCase");
        }
        else if(!preg_match("/\d/",$password))
        {
            header("Location: Editpro.php?passwordcondition=Number");
        }
        else if(!preg_match("/\W/",$password))
        {
            header("Location: Editpro.php?passwordcondition=SpecialCharacter");
        }
        else if(strlen($password) < 8)
        {
            header("Location: Editpro.php?passwordcondition=invalid");
        }
    }
    if($password !== $reTrypassword)
    {
            header("Location: Editpro.php?password=notmatch");
    }


    $sqlStudent = "UPDATE student
            SET
            firstname   = '".$firstname."' ,
            lastname    = '".$lastname."',
            birthday    = '".$birthday."',
            course      = '".$course."',
            major       = '".$major."',
            updated_at  = CURRENT_TIMESTAMP()
            WHERE id    = $id";
            
    $sqlUser = "UPDATE user
                SET
                username = '".$username."',
                password = '".password_hash($password,PASSWORD_BCRYPT)."',
                accountrole = '".$role."',
                update_at = CURRENT_TIMESTAMP()
                WHERE id = $StudentID";
                
    if($connection->query($sqlStudent) === true && $connection->query($sqlUser) === true)
    {
        header("Location: editSuccessmessage.php");
    }
    else 
    {
        echo "Error: " . $connection->error;
    }
    $connection->close();
?>