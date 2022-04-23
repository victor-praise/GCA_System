<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        
             $course_id =  $_SESSION["courseid"];
         
             $gme_error = "";
          
             if(isset($_GET['id'])){ 
                 $poll_id = $_GET['id'];

             }
             else{
                 $gme_error="There was a problem. please try again later";
             }
           
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


     <?php 
      if(!empty($gme_error)){
        echo '<div class="alert alert-danger">' . $gme_error . '</div>';
    } 
        if(isset($_SESSION["error"])){
              echo '<div class="alert alert-danger">' .$_SESSION['error']. '</div>';
      }  
      if(isset($_SESSION["success"])){
         echo '<div class="success">  Voting successful <a href="../student/student_poll.php" class="back">back to polls</a> </div>';
      }  
  
            
        ?>
         <div class="information--student poll__infocontainer"> 
     <?php
                // query statement to get marked entities in a course
                $query = "SELECT * from Poll_tbl p where p.id = '$poll_id';
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>

                <div class="poll--information">
                    <div class="poll-title">
                        <h2>
                        <?=$row["title"]; ?>
                        </h2>
                    </div>
                    <div class="poll-description">
                    <?=$row["description"]; ?>
                    </div>
                    <div class="poll-options">
                        Please pick an option from the options listed below
                        <div>
                            <form action="vote.php" method="post">
                            <?php 
                            // gets all available option
                            $query_polloptions = "select * from PollAnswers_tbl where poll_id='$poll_id'";
                            $query_run = mysqli_query($con, $query_polloptions);
                            if(mysqli_num_rows($query_run) > 0)        
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                echo "
                                <div class='poll-option'>
                                <label>
                                <input type='radio' class='poll-value' name='polloptionid' value='{$row['id']}'>
                                {$row['title']}
                                </label>
                                
                                </div>"
                                ;
                                }
                            }
                        
                        ?>
                        <div class="submit__button">
                        <button class="edit--btn" name="poll_vote" value=<?=$poll_id;?>>Vote</button>
                        <a href="../student/student_poll.php" class="cancel--link">
                            Cancel
                        </a>
                        
                    </div>
                            </form>
                       
                        </div>
                        
                    </div>
                   
                </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "No polls have been created, please click button above to add poll";
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