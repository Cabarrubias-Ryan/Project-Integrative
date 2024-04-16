<?php
    session_start();
    include("../../database/connection.php");

    if (!isset($_SESSION['EditChecker']) || !$_SESSION['EditChecker'] ||
        !isset($_SESSION['loginChecker']) || !$_SESSION['loginChecker']) {
        header("Location: ../NoEntry.php");
        exit(); // Exit after redirect
    }

    $id = $_POST['hiddenId'];
    $StudentID = $_POST['hiddenStudentId'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $course = $_POST['course'];
    $major = $_POST['major'];
    $birthday = $_POST['birthday'];
    $role = $_POST['accountRole'];

    $sqlStudent = "UPDATE student
            SET
            firstname = ?,
            lastname = ?,
            birthday = ?,
            course = ?,
            major = ?,
            updated_at = CURRENT_TIMESTAMP()
            WHERE id = ?";
            
    $stmt = $connection->prepare($sqlStudent);
    $stmt->bind_param("sssssi", $firstname, $lastname, $birthday, $course, $major, $id);
    $stmt->execute();

    $sqlUser = "UPDATE user
                SET
                username = ?,
                password = ?,
                accountrole = ?,
                update_at = CURRENT_TIMESTAMP()
                WHERE id = ?";
                
    $stmt = $connection->prepare($sqlUser);
    $stmt->bind_param("sssi", $username, password_hash($password, PASSWORD_BCRYPT), $role, $StudentID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: editSuccessmessage.php");
        exit();
    } else {
        echo "Error: " . $connection->error;
    }

    $connection->close();
?>