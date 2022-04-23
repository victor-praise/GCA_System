<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        
             $course_id =  $_SESSION["courseid"];
         
             $gme_error = "";
             $gme_success = "";
             $gme_file = "";
            $gme_name = "";
                    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $poll_id = mt_rand(1000000,9999999);
        // Checks if fields are empty
              if(empty(trim($_POST["pollname"]))){
                $gme_error = "Poll name cannot be empty.";
            } 
              elseif(empty(trim($_POST["polldescription"]))){
                $gme_error = "Poll description cannot be empty.";
            } 
            
            if(empty($gme_error)){
              
                $sql_poll = "INSERT INTO Poll_tbl (id,title,description,course_id) VALUES (?,?,?,?)";
                $poll_options = explode(PHP_EOL, $_POST['answers']);
                //insert into poll table
                if($stmt = mysqli_prepare($con, $sql_poll)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssss",$param_pollid,$param_polltitle,$param_description,$param_courseid);
                    
                    // Set parameters
                    $param_pollid = $poll_id;
                    $param_courseid = $course_id;
                    $param_polltitle = trim($_POST["pollname"]);
                    $param_description = trim($_POST["polldescription"]);
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        foreach($poll_options as $answer) {
                            // If the answer is empty there is no need to insert
                            if (empty($answer)){ continue;}

                            $sql_pollanswers = "INSERT INTO PollAnswers_tbl (poll_id,title) VALUES (?,?)";
                            if($stmt = mysqli_prepare($con, $sql_pollanswers)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "ss",$param_pollid,$param_title);
                                $param_pollid = $poll_id;   
                                $param_title = $answer;
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    echo '';
                                }
                            }
                          
                        }
                      $gme_success = "Poll created";
                      $gme_error = "";
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
                
            }
        
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
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

    <div class="create--course">
         <button class="create--btn" id="btn"><i class="fa-solid fa-plus"></i> Create a poll</button>
     </div>
    <div class="admin--welcome">
         <h2>
         Poll
         </h2>
         <div class="header--text">
         Here polls can be created for possible resolution of issues, you can also delete and view results of polls
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
                $query = "SELECT * from Poll_tbl p where p.course_id = '$course_id' ORDER BY title;
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
                        <a href="viewpoll.php?id=<?=$row["id"]; ?>">
                        <i class="fa-solid fa-eye"></i>
                            </a>
                          <form action="updategroup_groupmember.php" method="post"> 
                             <input type="hidden" name="course_id" value="<?=$course_id; ?>">
                          <button class="delete--group-btn" name="poll_delete" value="<?=$row["id"]; ?>">
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                          </form>  
                       
                      
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

<!-- modal script -->
<script>
   
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
 
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>