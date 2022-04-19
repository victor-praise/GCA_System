<?php session_start(); 
        require_once "../connection.php";
        
             $course_id =  $_SESSION["courseid"];       
             $submit_error = "";
             $submit_success = "";
             $deadlinepassed = false;
            if(isset($_GET['gme_id'])){
                $gme_id = $_GET['gme_id'];
                $group_id = $_SESSION["group_id"];
                $currentdate = date("Y-m-d");
                // checks if deadline has passed
                $query = "SELECT * FROM GroupMarked_tbl WHERE GME_id='$gme_id' AND course_id = '$course_id' AND deadline <= '$currentdate'";
                $query_run = mysqli_query($con,$query);
                if(mysqli_num_rows($query_run) > 0) {
                    $deadlinepassed = true;
                }
                else{
                    $deadlinepassed = false;
                }
               
            }
            else{
                $submit_error = "A problem Occurred! Contact Admin";
            }
                    // Processing form data when form is submitted
                    
           
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entity Submission</title>
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
        if($deadlinepassed){
            echo '<div class="deadline--passed">
                    Entity deadline has passed and there can be no more submissions
        </div>';
        }
        else{
            echo '<div class="create--course">
            <button class="create--btn" id="btn"><i class="fa-solid fa-plus"></i> Submit/update entity</button>
        </div>';
        }
    ?>
    <a href="markedentity.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
    <div class="admin--welcome">
         <h2>
         Entity submission
         </h2>
         <div class="header--text">
         As the group leader you can submit solution to entites or update submission. However once deadline passes submission button will be unavilable.
    </div>   

     </div>
     <?php 
     
        if(!empty($submit_error)){
            echo '<div class="alert alert-danger">' . $submit_error . '</div>';
        }  
        elseif(!empty($submit_success)){
            echo '<div class="success">' . $submit_success . '</div>';
        } 
        if(isset($_SESSION["error"])){
              echo '<div class="alert alert-danger"> '.$_SESSION['error'].'</div>';
      }  
      if(isset($_SESSION["success"])){
         echo '<div class="success">  '.$_SESSION['success'].' </div>';
      }  
            
        ?>
      
         <div class="information--student"> 
     <?php
                // query statement to get marked entities in a course
                $query = "SELECT * from GroupMarked_tbl g where g.GME_id = '$gme_id' AND g.course_id='$course_id';
                ";
                
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="student entitycontainer" >
                           <div class="assignment-title">
                           <label class="entity-info">Entity name</label>
                           <?=$row["entity_name"]; ?>
                           </div>
                           <div class="assignment-filename">
                           <label class="entity-info">File name</label>
                           <?=$row["file_name"]; ?>
                           </div>
                           <div class="assignment-deadline">
                           <label class="entity-info">Deadline</label>
                           <?=$row["deadline"]; ?>
                           </div>
                           <?php 
                            // checks if entity has been submitted
                            $query_submitted = "SELECT * from FinalSubmission_tbl where GME_id = '$gme_id' AND group_id = '$group_id'";

                            $query_runSubmission = mysqli_query($con, $query_submitted);
                            if(mysqli_num_rows($query_runSubmission) > 0) {
                                while($submittedrow = mysqli_fetch_assoc($query_runSubmission))
                                {
                                    if($submittedrow['GME_id'] == $row['GME_id']){
                                        echo '
                                        <div class="email submitted">
                                        <label class="entity-info">Submission</label>
                                        '.$submittedrow['file_name'].' 
                                        <a href="download-solution.php?file_id='.$submittedrow['GME_id'].'"><i class="fa-solid fa-download"></i></a> 
                                        </div>            
                                        ';
                                    } 
                                    else {
                                        // used to make styling consistent
                                        echo "<div class=''>not submitted</div>";
                                    }
                                }
                            }
                            else{
                                echo '

                                <div class="email not-submitted">
                                <label class="entity-info">Submission</label>
                                No file has been submitted, kindly submit before the deadline
                                </div>            
                                ';
                            }
                        ?>
                           <div class="assignment-submissionFile"></div>
         
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "An error occured. Contact Admin";
                }
            ?>
        </div>
        
        
        <div id="myModal" class="modal" >
           <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="upload.php" method="post"  enctype="multipart/form-data" class="courseForm">     
        
        <div class="form-group">
            <input type="hidden" name="gme_id" value="<?=$gme_id;?>">
            <label>Upload file</label>
            <input type="file" name="gmefile" class="form-control" value="<?php echo $gme_file; ?>" required>    
        </div> 
            <div class="btn__container">
            <button class="submit--btn" name="submit-entity">Make submission</button>
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