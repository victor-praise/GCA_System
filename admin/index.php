<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCA Portal</title>
    
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
   
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
     <div class="create--course">
         <button class="create--btn"><i class="fa-solid fa-plus"></i> Create Course</button>
     </div>
     <div class="admin--welcome">
         <h2>
         Welcome Admin
         </h2>
         
         As an admin you can add new courses by simple clicking the button above, you can also edit existing courses adding or removing instructors by clicking on view courses on your sidebar
     </div>
     <div class="createCourse--modal">
   
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
        <p>Some text in the Modal..</p>
        </div>

 
     </div>
    <!-- sidebar and content, last two div end -->
    </div>
</div>
</body>
</html>
