<?php
  if(!isset($_SESSION['loginChecker']))
  {
      header("Location: NoEntry.php");
  }
  if($_SESSION['loginChecker'] == false)
  {
      header("Location: NoEntry.php");
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
   <meta charset="UTF-8">
   <title>WebPage</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/NavbarDesign.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   </head>
<body>
  <nav>
  <div class="navbar">
      <ul class="sidebar">
        <li onclick=hideSidebar()><a href="#"><i class='bx bxs-x-circle' ></i></a></li>
        <li><a href="../Home/welcome.php"><i class='bx bx-home-alt-2'> Home</i></a></li>
        <li><a href="../ListOfAccount/listofAccount.php"><i class='bx bxs-user'> Account List</i></a></li>
        <li><a href="../AddAcount/SignUp.php"><i class='bx bxs-user-plus'> Add Account</i></a></li>
        <li><a href="../Logout/logout.php"><i class='bx bx-log-out'> Logout</i></a></li>
      </ul>
    </div>
    <div class="navbar">
      <ul class="menu">
        <li class="logo"><a href="#"><i class='bx bxs-user'> <?= $_SESSION['Data']['fullname'] ?></i></a></li>
        <li class="hideOnMobile"><a href="../Home/welcome.php"><i class='bx bx-home-alt-2'></i></a></li>
        <li class="hideOnMobile"><a href="../ListOfAccount/listofAccount.php"><i class='bx bxs-user'></i></i></a></li>
        <li class="hideOnMobile"><a href="../AddAccount/SignUp.php"><i class='bx bxs-user-plus'></i></a></li>
        <li class="hideOnMobile"><a href="../Logout/logout.php"><i class='bx bx-log-out'></i></a></li>
        <li class= "menu-Button" onclick=showSidebar()><a href="#"><i class='bx bx-menu' ></i></a></li>
      </ul>
    </div>
  </nav>
  <script>
    function showSidebar(){
      const sidebar = document.querySelector('.sidebar')
      sidebar.style.display = 'flex'
    }
    function hideSidebar(){
      const sidebar = document.querySelector('.sidebar')
      sidebar.style.display = 'none'
    }
  </script>
</body>
</html>