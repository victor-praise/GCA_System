<?php session_start(); 
        require_once "../connection.php";
        
             $course_id =  $_SESSION["courseid"];
             unset($_SESSION['error']);
            unset($_SESSION['success']);
             $gme_error = "";
             $gme_success = "";
           
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polls</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">   
  <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <link rel="stylesheet" href="../student/student.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

    <div class="admin--welcome">
         <h2>
         Poll
         </h2>
         <div class="header--text">
         Here you can view polls created by the instructor and cast your vote
    </div>   

     </div>
     <?php 
     
        if(!empty($gme_error)){
            echo '<div class="alert alert-danger">' . $gme_error . '</div>';
        }  
        elseif(!empty($gme_success)){
            echo '<div class="success">' . $gme_success . '</div>';
        }  
            
        ?>
         <div class="information--student"> 
     <?php
                // query statement to get marked entities in a course
                $query = "SELECT * from Poll_tbl p where p.course_id = '$course_id';
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="student" >
                           
                        <div class="name"> 
                        <label class="entity-info"> Poll title</label>
                        <?=$row["title"]; ?>
                        </div>
                        <div class="name extra--text"> 
                        <label class="entity-info">Poll description </label>
                            <?=$row["description"]; ?>
                        </div>
                    
                        <div class="delete">
                        <a href="poll_info.php?id=<?=$row["id"]; ?>">
                        Vote<i class="fa-solid fa-check-to-slot"></i>
                            </a>
                                          
                      </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "No polls have been created, check back later";
                }
            ?>
        </div>
        
        <div id="myModal" class="modal" >
           <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data" class="courseForm">     
        <div class="form-group">
            <label>Enter poll name</label>
            <input type="text" name="pollname" class="form-control" required>    
        </div> 
        <div class="form-group">
            <label>Enter description</label>
            <textarea name="polldescription" cols="20" rows="3" class="form-control" required></textarea>
          
        </div> 
        <div class="form-group">
        <label for="answers">Poll options (per line)</label>
        <textarea name="answers" id="answers" placeholder="Enter poll choices line by line" rows="5" required></textarea> 
        </div> 
            <div class="btn__container">
            <button class="submit--btn">Create Poll</button>
            </div>
           
    </form>
   </div>
            </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>


</body>
</html>