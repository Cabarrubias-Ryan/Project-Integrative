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
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $firstname  = $_POST['firstname'];
    $lastname   = $_POST['lastname'];
    $course     = $_POST['course'];
    $major      = $_POST['major'];
    $birthday   = $_POST['birthday'];
    
    

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
                update_at = CURRENT_TIMESTAMP()
                WHERE id = $id";
                
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