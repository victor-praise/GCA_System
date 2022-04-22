<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        $course_error = "";
        $course_student = "";
      

        if(isset($_GET['id'])){
          $course_id = $_GET['id'];
        
        }
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <div class="create--course">
         <button class="create--btn add--student" id="btn"><i class="fa-solid fa-plus"></i> Add Student</button>
     </div>
     <?php 
          if($_SESSION["role"] == 'admin'){
            echo '<a href="../admin/edit_course.php?id='. $course_id .'" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>';
        }
        elseif($_SESSION["role"] == 'instructor'){
          echo '<a href="../instructor/instructor_course.php?id='. $course_id .'" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>';
        }
       
       ?>
    <h2 class="student__header">Students</h2>
       
    <?php 
            if(isset($_SESSION["error"])){
              if($_SESSION["error"]='add error'){
                echo '<div class="alert alert-danger">  This Student is already in the course </div>';
              }
              elseif($_SESSION["error"]='delete error'){
                echo '<div class="alert alert-danger">  Student cannot be deleted </div>';
              }
              elseif($_SESSION["error"]=''){
                echo '<div class="alert alert-danger"> </div>';
              }
              
            
        }  
        // elseif(!empty($course_success)){
        //     echo '<div class="success">' . $course_success . '</div>';
        // }      
        ?>
    <div class="information--student">
   
        <?php
                // query statement to get course information and instructor
                $query = "SELECT * from Student_tbl t, Users_tbl c where t.course_id = '$course_id' and t.user_id = c.user_id;
                ";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        
                ?>
                
                      <div class="student" >
                        <div class="name"> <?=$row["user_name"]; ?> </div>
                        <div class="email"><?=$row["user_email"]; ?></div>
                        <div class="delete">
                          <form action="add-delete_student.php" method="post">
                          <input type="hidden" name="course_studentid" value="<?=$course_id;?>">  
                          <button class="delete--student-btn" value="<?=$row["user_id"]?>" name="student_delete">
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                          </form>  
                       
                      
                      </div>
                      </div>
                        <?php  
                    } 
                    
                }
                else {
                    echo "No Student Added";
                }
            ?>

    </div>

    <div id="myModal" class="modal" >
   
   <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="add-delete_student.php" method="post"  class="courseForm">     
        <div class="form-group">
                <input type="hidden" name="course_id" value="<?=$course_id;?>">
                <div class="form--input student--select">
                <label>Select Student</label>
                <select name="student" value="<?php echo $course_student; ?>" class="student--select" required>
                <!-- gets instructors from user table -->   
                <?php
                // query statement to get course information and instructor
                $query = "SELECT * from Users_tbl WHERE user_role = 'student'";
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
            <button class="submit--btn" name="add__student">Add student</button>
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