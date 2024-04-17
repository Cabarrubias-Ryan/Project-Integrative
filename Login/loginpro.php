<?php
    session_start();
    include("../database/connection.php");
    include("../Encryption/EncryptionProcess.php");

    $username = $_POST['username'];
    $password = $_POST['password'];

    // i already have a code to prevent the sqli injection 
    //first is prepare the sql query
    $queryUser = $connection->prepare("SELECT u.id, u.username, u.password, s.firstname, s.lastname, u.accountrole 
                                       FROM user u 
                                       LEFT OUTER JOIN student s ON u.id = s.studentID 
                                       WHERE u.username = ?");
    // second use the bind_param and the 's' represent as a String which is the username
    $queryUser->bind_param("s", $username);
    // then execute the query
    $queryUser->execute();
    // last is get the result 
    $result = $queryUser->get_result();

    $_SESSION['loginChecker'] = false;

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        // Use password_verify to check if the entered password matches the hashed password
        if (password_verify($password, $userData['password'])) {

            $userInfo = [
                'fullname' => $userData['firstname'] . " " . $userData['lastname'],
                'role' => $userData['accountrole'],
                'password' => $userData['password'],
                'Username' => $userData['username'],
                'id' => $userData['id']
            ];

            $_SESSION['Data'] = $userInfo;
            $_SESSION['loginChecker'] = true;
            header("Location: ../Home/welcome.php");
        } else {
            // Incorrect password
            header("Location: ../index.php?login=error&username=" . urlencode(encryptData($username)));
        }
    } else {
        // User not found
        header("Location: ../index.php?login=error&username=" . urlencode(encryptData($username)));
    }

    $queryUser->close();
    $connection->close();
?>
