<?php
    session_start();
    if(!isset($_SESSION['loginChecker']))
    {
        header("Location: ../NoEntry.php");
    }
    if($_SESSION['loginChecker'] == false)
    {
        header("Location: ../NoEntry.php");
    }

    include("../../database/connection.php");
    include("../../Encryption/EncryptionProcess.php");

    if(decryptData($_GET['id']) == null && decryptData($_GET['StudentId']))
    {
        header("Location: ../listofAccount.php");
    }

    $id = decryptData($_GET['id']);

    $sql = $connection->prepare("Select s.* from student s left join user u on s.StudentID = u.student_id where s.StudentID = ?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $StudentData = $sql->get_result();
    $studentID = $StudentData->fetch_assoc();
    $ResultId = $studentID['id']; 

    $sqlStudent = $connection->prepare("Delete from student where id =?");
    $sqlUser = $connection->prepare("Delete from user where id =?");

    $sqlStudent->bind_param("i",$ResultId);
    $sqlStudent->execute();
    $resultStudent = $sqlStudent->get_result();

    $sqlUser->bind_param("i",$id);
    $sqlUser->execute();
    $resultUser = $sqlUser->get_result();

    if(empty($resultStudent->num_rows) && empty($resultStudent->num_rows))
    {
        header("Location: ../listofAccount.php");
    }
    else
    {   
        header("Location: deleteSuccessmessage.php");
    }
    $connection->close(); 
?>