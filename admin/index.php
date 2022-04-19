<?php session_start(); 

// Include config file
require_once "../connection.php";

$coursename = "";$course_error = "";$course_term = "";
$course_year = "";$course_section = ""; $course_success = "";$course_id = mt_rand(100000,999999);
$course_subject="";$course_number = "";$role = "instructor";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $course_instructor = $_POST["instructor"];
        // Checks if fields are empty
        if(empty(trim($_POST["coursename"]))){
            $course_error = "Course name cannot be empty.";
        } elseif(empty(trim($_POST["instructor"]))){
            $course_error = "Please enter an instructor name";
        }
         elseif(empty(trim($_POST["courseterm"]))){
            $course_error = "Please select a term";
        }
         elseif(empty(trim($_POST["courseyear"]))){
            $course_error = "Please enter course year";
        }
        else{
            // Prepare a select statement
            $sql = "SELECT course_id FROM CourseSection_tbl WHERE course_subject = ? AND course_number = ?";
            // ensures course does not exists before creating
            if($stmt = mysqli_prepare($con, $sql)){
                // Bind variables to the prepared statement as parameters
                // Link - https://www.php.net/manual/en/mysqli-stmt.bind-param.php
                mysqli_stmt_bind_param($stmt, "ss", $param_coursename,$param_coursenumber);
                
                // Set parameters
                $param_coursename = trim($_POST["coursesubject"]);
                $param_coursenumber = trim($_POST["coursenumber"]);
                
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
   
          
        }
        if(empty($course_error)){
        
            // Prepare an insert statement for course table
            $sql = "INSERT INTO CourseSection_tbl (course_id,course_name,course_subject,course_number,course_section,course_term,course_year) VALUES (?,?,?,?,?,?,?)";

            $sql_instructor = "INSERT INTO Instructor_tbl (user_id,course_id) VALUES (?,?)";

            if($stmt = mysqli_prepare($con, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssss",$param_cid, $param_coursename,$param_coursesubject,$param_coursenumber,$param_coursesection,$param_term,$param_year);
                
                // Set parameters
                $param_cid = $course_id;
                $param_coursename = trim($_POST["coursename"]);
                $param_term = trim($_POST["courseterm"]);
                $param_year = trim($_POST["courseyear"]);
                $param_coursesubject = trim($_POST["coursesubject"]);
                $param_coursenumber = trim($_POST["coursenumber"]);
                $param_coursesection = trim($_POST["coursesection"]);
             
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                   
                    $course_success = "Course Added";
                    $course_error = "";
                   
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
      
            //insert into instructor table
            if($stmt = mysqli_prepare($con, $sql_instructor)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss",$param_userid,$param_courseid);
                
                // Set parameters
                $param_courseid = $course_id;
                $param_userid = trim($_POST["instructor"]);
             
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                  
                   
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
            <input type="text" name="coursename" class="form-control" value="<?php echo $coursename; ?>" required>
        </div>
        <div class="form-group form--term">
            <div class="form--input">
                <label>Enter course subject</label>
                <input type="text" name="coursesubject" class="form-control" value="<?php echo $course_subject; ?>" required>
            </div>
            <div class="form--input">
                <label>Enter course number</label>
                <input type="number" name="coursenumber" class="form-control" value="<?php echo $course_number; ?>" required>
            </div>
                
                
                <!-- <span class="invalid-feedback"><?php echo $username_err; ?></span> -->
            </div> 
            <div class="form-group form--term">
                <div class="form--input">
                    <label>Select Term</label>
                    <select name="courseterm" value="<?php echo $course_term; ?>">
                        <option>FALL</option>
                        <option>WINTER</option>
                        <option>SUMMER</option>
                    </select>
                </div>
                <div class="form--input">
                    <label>Course Year</label>
                    <input type="number" name="courseyear" value="<?php echo $course_year ?>" required>
                </div>
            </div>
        <div class="form-group form--term">
                <div class="form--input">
                    <label>Course Section</label>
                    <input type="text" name="coursesection" value="<?php echo $course_section ?>" required>
                </div>
                <div class="form--input">
                <label>Select Instructor</label>
                <select name="instructor" value="<?php echo $course_instructor; ?>" class="select--instructor" required>
                <!-- gets instructors from user table -->   
                <?php
                // query statement to get course information and instructor
                $query = "SELECT * from Users_tbl WHERE user_role = 'instructor'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        echo "<option class='instructor--names' value='{$row['user_id']}'> {$row['user_name']}</option>";
                    }
                }
                ?>
                </select>
                </div>
            
                
            
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
