<?php
    session_start();
    include("../../database/connection.php");
    include("../../Encryption/EncryptionProcess.php");

    if (!isset($_SESSION['EditChecker']) || !$_SESSION['EditChecker'] ||
        !isset($_SESSION['loginChecker']) || !$_SESSION['loginChecker']) {
        header("Location: ../NoEntry.php");
        exit(); // Exit after redirect
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $sqlcheck = "SELECT * FROM user WHERE username = ?";
        $stmt = $connection->prepare($sqlcheck);
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result();
        $Data = $result->fetch_assoc();

        if($result->num_rows > 0 && $Data['id'] != $StudentID){
            header("Location: Editpro.php?username=duplicate&id=".urlencode(encryptData($id))); // username error trappings
            exit();
        }
        else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/",$password))
        {
            
            if(!preg_match("/[A-Z]/",$password))
            {
                header("Location: Editpro.php?passwordcondition=UpperCase&id=".urlencode(encryptData($id)));
                exit();
            }
            else if(!preg_match("/[a-z]/",$password))
            {
                header("Location: Editpro.php?passwordcondition=LowerCase&id=".urlencode(encryptData($id)));
                exit();
            }
            else if(!preg_match("/\d/",$password))
            {
                header("Location: Editpro.php?passwordcondition=Number&id=".urlencode(encryptData($id)));
                exit();
            }
            else if(!preg_match("/\W/",$password))
            {
                header("Location: Editpro.php?passwordcondition=SpecialCharacter&id=".urlencode(encryptData($id)));
                exit();
            }
            else if(strlen($password) < 8)
            {
                header("Location: Editpro.php?passwordcondition=invalid&id=".urlencode(encryptData($id)));
                exit();
            }
        }
        
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

    }
?>