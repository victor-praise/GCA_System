<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit course</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>


    <div class="course__edit">
 
        <div class="edit__header">
            Edit User
        </div>
        
        <!-- get particular user from database using id -->
        <?php 
        // ensures data exists
            if(isset($_GET['id'])){
                $user_id = $_GET['id'];     
                if(isset($_SESSION["updateusererror"])){
                    echo '<div class="alert alert-danger"> '.$_SESSION['updateusererror'].' </div>';
                }  
            // queries database
            $query = "SELECT * from Users_tbl u WHERE u.user_id = '$user_id';
            ";
             $query_run = mysqli_query($con, $query);

             if(mysqli_num_rows($query_run) > 0){
                 foreach($query_run as $user){
                    ?>
                       
                    
                <form action="edit.php" method="POST" class="edit__form">
                    <input type="hidden" name="user_id" value="<?=$user['user_id'];?>">
                    <div class="formGroup">
                        <label for="">User Name</label>
                        <input type="text"
                        onkeypress="return /[a-z ]/i.test(event.key)"
                        name="newusername" value="<?=$user['user_name'];?>">
                    </div>
                    <div class="formGroup email--input">
                       
                        <label for="">User Email</label>
                        <input type="text" placeholder="Enter new email" name="newemail" value="<?=$user['user_email'];?>">
                       
                    </div>
           
                    <div class="formGroup">
                       
                        <label for="">Role</label>
                        <select name="newrole" class="student--select role--select" value="<?=$user['user_role'];?>" class="select--instructor" required>
                        <option value="instructor"<?php if($user['user_role'] == "instructor"){ echo " selected='selected'"; } ?>>Instructor</option>
                        <option value="ta"<?php if($user['user_role'] == "ta"){ echo " selected='selected'"; } ?>>Ta</option>
                        <option value="student"<?php if($user['user_role'] == "student"){ echo " selected='selected'"; } ?>>Student</option>
                </select>         
                    </div>
                 
                    <div class="submit__button">
                        <button class="edit--btn" name="update_user">Edit</button>
                        <a href="../admin/users.php" class="cancel--link">
                            Cancel
                        </a>
                        
                    </div>
                </form>
        <?php
                 }
                
             }      
             else{
                    ?>
                        <h4>No Record found</h4>
                    <?php
             }
            }
        ?>
    </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
</body>
</html>