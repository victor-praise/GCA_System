<?php session_start(); 
        require_once "connection.php";
    
             $announcement_error = "";
             $announcement_success = "";        
            // unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">   
  <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('./includes/header.php'); ?>
    <?php include('./includes/sidebar.php'); ?>
    <div class="admin--welcome">
         <h2>
        Announcement
         </h2>
         <div class="header--text">
         Announcements made by admin can be viewed here
        </div>   

     </div>
     <?php 
     
        if(!empty($announcement_error)){
            echo '<div class="alert alert-danger">' . $announcement_error . '</div>';
        }  
        elseif(!empty($announcement_success)){
            echo '<div class="success">' . $announcement_success . '</div>';
        }  
            
        ?>
         <div class="information--student"> 
     <?php
                // query statement to get marked entities in a course
                $query = "SELECT * from Announcement_tbl;
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="student announcement-container" >       
                        <div class="name announcement"> 
                        <label class="entity-info">Announcement</label>
                            <?=$row["announcement"]; ?> 
                        </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There are no announcements, please check back later";
                }
            ?>
        </div>

      <!-- last two divs are for the sidebar and content -->
      </div>
</div>


</body>
</html>