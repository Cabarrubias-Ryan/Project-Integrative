<?php
    session_start();
    $_SESSION['EditChecker'] = true;
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
    if(decryptData($_GET['id']) == null)
    {
        header("Location: ../listofAccount.php");
    }
    $id = decryptData($_GET['id']);
    
    $sql =  $connection->prepare("Select u.*, s.firstname, s.lastname, s.birthday, s.course, s.major from user u 
                                left outer join student s on u.id = s.studentID 
                                 where u.id =?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $result = $sql->get_result();

    if(empty($result->num_rows)){
        echo "Invalid User";
        exit();
    }
    $Data = $result->fetch_assoc();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/EditStyle.css">
</head>
<body>
    <div class="return-button">
        <a href="../listofAccount.php">Back</a>
    </div>
    <section>
        <div class="SignUp-form">
            <form action="updatePro.php" method="post">
                <div class="textbox">
                    <h1>UPDATE</h1>
                    <input type="hidden" name="hiddenId" value ="<?= $Data['id']?>" require>
                </div>
                <div class="textbox">
                    <input type="text" name="username" value ="<?= $Data['username'] ?>"  placeholder ="Username" require>
                </div>
                <div class="textbox">
                    <input type="text" name="password"   placeholder ="Password" require>
                </div>
                <div class="textbox">
                    <input type="text" name="firstname" value ="<?= $Data['firstname'] ?>"  placeholder ="First Name" require>
                </div>
                <div class="textbox">
                    <input type="text" name="lastname" value ="<?= $Data['lastname'] ?>"  placeholder ="Last Name" require>
                </div>
                <div class="textbox">
                    <input type="text" name="course" value ="<?= $Data['course'] ?>"  placeholder ="Course"  require>
                </div>
                <div class="textbox">
                    <input type="text" name="major" value ="<?= $Data['major'] ?>" placeholder ="Major" require>
                </div>
                <div class="textbox">
                    <input type="date" name="birthday" value="<?= $Data['birthday'] ?>"  placeholder ="BirthDate" require>
                </div>
                <div class="button">
                    <input type="submit" value="Save changes">
                </div>
            </form>
        </div>
    </section>
</body>
</html>