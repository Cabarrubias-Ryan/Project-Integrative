<?php
    session_start();
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
    <title>Document</title>
    <link rel="stylesheet" href="../css/homeDesign.css">
</head>
<body>
    <section id="Home">Welcome User</section>
</body>
</html>