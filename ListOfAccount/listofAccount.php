<?php
    session_start();
    include("../Encryption/EncryptionProcess.php");
    include("../database/connection.php");

    if(!isset($_SESSION['loginChecker']))
    {
        header("Location: NoEntry.php");
    }
    if($_SESSION['loginChecker'] == false)
    {
        header("Location: NoEntry.php");
    }
?>
<?php
    include("../Navbar/Menu-NavBar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="../css/tableDesign.css">
</head>
<body>
<div class="table-wrapper">
    <table class  = "fl-table">
        <tr>
            <thead>
                <th>Username</th>
                <th>Password</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>  
                <th>Created at</th>
                <th>Action</th>
            </thead>
        </tr>
            <tbody>
                <?php

                $sql = "SELECT * FROM user LEFT OUTER JOIN student on student.studentID = user.id";
                $result =  $connection->query($sql);

                if ($result->num_rows > 0) 
                {
                        // output data of each row
                        while($row = $result->fetch_assoc()) 
                        {
                            ?>
                                    <tr>
                                        <td><?=$row['username']?></td>
                                        <td><?=$row['password']?></td>
                                        <td><?=$row['firstname']?></td>
                                        <td><?=$row['middlename']?></td>
                                        <td><?=$row['lastname']?></td>
                                        <td><?=date('F j, Y', strtotime($row['created_at']))?></td>
                                        <td><a href="#" class="icon"><i class='bx bxs-edit'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="icon"><i class='bx bx-trash'></i></a></td>
                                    </tr>
                            <?php
                        }

                }
                $connection->close();

                ?>
            </tbody>
    </table>
</div>
</body>
</html>