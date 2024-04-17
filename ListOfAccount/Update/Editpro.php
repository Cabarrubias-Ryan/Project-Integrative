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
    
    $sql =  $connection->prepare("Select u.username, u.password, u.accountrole, u.update_at , u.id, u.student_id, s.firstname, s.lastname, s.birthday, s.course, s.major, s.id from user u 
                                left outer join student s on u.id = s.studentID 
                                 where s.id =?");
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
                    <input type="hidden" name="hiddenStudentId" value ="<?= $Data['student_id']?>" require>
                </div>
                <div class="textbox">
                    <input type="text" name="username" value ="<?= $Data['username'] ?>"  placeholder ="Username" require>
                    <?php if(isset($_GET['username'])): ?>
                        <?php if($_GET['username'] == "duplicate") : ?>
                            <strong>Username already been use.</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="textbox">
                    <input type="password" name="password" placeholder ="Password" require>
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
                <div class="textbox">
                    <select name="accountRole" require>
                        <option hidden>Account Role</option>
                        <option>Administrator</option>
                        <option>Student</option>
                    </select>
                </div>
                <div class="button">
                    <input type="submit" value="Save changes">
                </div>
            </form>
        </div>
    </section>
</body>
</html>