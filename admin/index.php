<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="admin.scss">
    <link rel="stylesheet" href="../style.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
   
</head>
<body>
  
        <nav class="navbar">
            <div class="systemName">
                GCA Portal
            </div>
            <div class="userName">
                <div class="user-details">
                    <i class="fa-solid fa-circle-user"></i>
                    <?= $_SESSION['name'] ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
          
                <div class="dropdown__content">
                <p class="dropdown--item"> 
                    <a href=""><i class="fa-solid fa-key"></i> Change Password</a>
                 </p>
                <p class="dropdown--item">
                     <a href="../logout.php"><i class="fa-solid fa-power-off"></i> Logout</a>
                    </p>
                </div>
            </div>
        </nav>
    <aside class="sidebar">
        testing
    </aside>
</body>
</html>