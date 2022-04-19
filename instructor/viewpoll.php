<?php session_start(); 
        require_once "../connection.php";         
             $gme_error = "";
          
             if(isset($_GET['id'])){ 
                 $poll_id = $_GET['id'];
                 $total_votes = 0;
                 $query = "SELECT * from PollAnswers_tbl p where p.poll_id = '$poll_id' ORDER BY votes DESC;
                 ";
                 $query_run = mysqli_query($con, $query);
                 
                 if(mysqli_num_rows($query_run) > 0)        
                 {
                     while($row = mysqli_fetch_assoc($query_run))
                     {  
                         $total_votes += $row['votes'];
                     }
                    }

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
    
    <link rel="stylesheet" href="../student/student.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <a href="../instructor/polls.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
        <div class="information--student view__poll"> 
            <?=$total_votes?> student(s) have voted
     <?php
                // query statement to get marked entities in a course
                $query = "SELECT * from PollAnswers_tbl p where p.poll_id = '$poll_id' ORDER BY votes DESC;
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                       
                ?>

                <div class="poll__results">
                        <div class="poll-title">
                        <?=$row["title"]; ?> (<?=$row["votes"]; ?>) Votes
                        </div>

                        <div class="result-bar" style= "width:<?=@round(($row['votes']/$total_votes)*100)?>%">
                <?=@round(($row['votes']/$total_votes)*100)?>%
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