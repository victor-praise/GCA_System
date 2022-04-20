<?php session_start(); 
        require_once "../connection.php";
        // Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $course_id = $_POST["course_delete"];
        $delete_err = "";
        // echo "$course_id";
        $query = "DELETE FROM CourseSection_tbl WHERE course_id='$course_id'";
        $query_run = mysqli_query($con,$query);
        if($query_run){
            header("location: ../admin/courses.php");
            exit(0);
        }
        else{
            $delete_err = "Unable to delete";
            exit(0);
        }
        
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussions</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>

    <!-- makes toastr work -->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <div class="container">
                <div class="subforum">
                <div class="subforum-title" style="display: flex;align-items: center;">
                        <h1>General Discussions</h1>
                        <button class="create--btn" id="btn" style="margin-left: 55%;"><i class="fa-solid fa-plus"></i> Create Discussion</button>
                    </div>
    <?php 
        if(!empty($delete_err)){
            echo '<div class="alert alert-danger">' . $delete_err . '</div>';
        }        
        ?>
    <?php 
                if(isset($_SESSION["message"])){
                    if($_SESSION["message"] == 'updated'){
                        // script for toastr
                        echo "<script type='text/javascript'>
                        toastr.options = {
                            'closeButton': false,
                            'debug': false,
                            'newestOnTop': false,
                            'progressBar': false,
                            'positionClass': 'toast-bottom-right',
                            'preventDuplicates': false,
                            'onclick': null,
                            'showDuration': '2000',
                            'hideDuration': '2000',
                            'timeOut': '2000',
                            'extendedTimeOut': '2000',
                            'showEasing': 'swing',
                            'hideEasing': 'linear',
                            'showMethod': 'fadeIn',
                            'hideMethod': 'fadeOut'
                          }
                        toastr.success('Course Updated')
                        
                        </script>";
                    }
                }
        ?>
     </div>
    <?php
                // query statement to get course information and instructor
                $query = "SELECT p.*,(SELECT user_name from Users_tbl where user_id=p.user_id) as user_name FROM DiscussionPagesPost_tbl p";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        
                ?>
                    <div class="subforum-row">
                        <div class="subforum-description  subforum-column">
                        <p>Discussion <?=$row["post_id"]; ?></p>
                            <p><?=$row["post_text"]; ?></p>
                        </div>
                        <!-- <div class="subforum-stats  subforum-column center">
                            <span>24 Posts | 12 Topics</span>
                        </div> -->
                        <div class="subforum-info  subforum-column">
                            <b><a href="">Last post</a></b> by <?=$row["user_name"]; ?> 
                            <br>on <small><?=$row["post_date"]; ?></small>
                        </div>
                        <div class="subforum-info  subforum-column">
                        <a href="discussionDetails.php?id=<?=$row["post_id"]?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            </div>
                    </div>
                    <hr class="subforum-divider">
                    <?php  
                    } 
                    
                }
            ?>
    
       
    </div>
    <!-- last two divs are for the sidebar and content -->
    </div>
</div>
<div id="myModal" class="modal" >
   
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
   
        <form action="createDiscussion.php" method="post"  class="courseForm">
        <div class="form-group">
            <label>Enter discussion text</label>
            <textarea type="text" rows="10" cols="110" class="form-control" name="discussionText" value="" required></textarea>
        </div>
            <div class="form-group form--term">
                <div class="form--input">
                    <label>Select Course</label>
                    <select name="courseId" value="<?php echo $course_instructor; ?>" class="select--instructor" required>
                <!-- gets instructors from user table -->   
                <?php
                // query statement to get course information and instructor
                $query = "SELECT * from CourseSection_tbl";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        echo "<option class='instructor--names' value='{$row['course_id']}'> {$row['course_name']}</option>";
                    }
                }
                ?>
                </select>
                </div>
            </div>
            <div class="btn__container">
            <button class="submit--btn" name="create_discussion">Create</button>
            </div>
            <!-- modal script -->
<script>
    console.log("test");
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
