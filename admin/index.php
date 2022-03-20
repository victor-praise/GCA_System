<?php session_start(); 

// Include config file
require_once "../connection.php";

$coursename = "";
$course_error = "";
$course_success = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Check if coursename is empty
        if(empty(trim($_POST["coursename"]))){
            $course_error = "Course name cannot be empty.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM course WHERE coursename = ?";
            if($stmt = mysqli_prepare($con, $sql)){
                // Bind variables to the prepared statement as parameters
                // Link - https://www.php.net/manual/en/mysqli-stmt.bind-param.php
                mysqli_stmt_bind_param($stmt, "s", $param_coursename);
                
                // Set parameters
                $param_coursename = trim($_POST["coursename"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $course_error = "This course already exists.";
                    } else{
                        $coursename = trim($_POST["coursename"]);  
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
            //$course = trim($_POST["coursename"]);
        }
        if(empty($course_error)){
        
            // Prepare an insert statement
            $sql = "INSERT INTO course (coursename) VALUES (?)";
             
            if($stmt = mysqli_prepare($con, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_coursename);
                
                // Set parameters
                $param_coursename = trim($_POST["coursename"]);
             
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    $course_success = "Course Added";
                    $course_error = "";
                   
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
         <button class="create--btn" id="btn"><i class="fa-solid fa-plus"></i> Create Course</button>
     </div>
     <div class="admin--welcome">
         <h2>
         Welcome Admin
         </h2>
         
         As an admin you can add new courses by simple clicking the button above, you can also edit existing courses adding or removing instructors by clicking on view courses on your sidebar
     </div>
     <?php 
        if(!empty($course_error)){
            echo '<div class="alert alert-danger">' . $course_error . '</div>';
        }  
        elseif(!empty($course_success)){
            echo '<div class="success">' . $course_success . '</div>';
        }      
        ?>
     <div id="myModal" class="modal" >
   
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
   
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  class="courseForm">
        <div class="form-group">
                <label>Enter course name</label>
                <input type="text" name="coursename" class="form-control" value="<?php echo $coursename; ?>">
                
                <!-- <span class="invalid-feedback"><?php echo $username_err; ?></span> -->
            </div> 
            <div class="btn__container">
            <button class="submit--btn">Create</button>
            </div>
           
        </form>
        </div>

 
     </div>
    <!-- sidebar and content, last two div end -->
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
