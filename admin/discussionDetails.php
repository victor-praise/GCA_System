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
    <title>Discussion Detail</title>
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
    <div class="courses__list">
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
    <?php
    if(isset($_GET['id'])){
        $post_id = $_GET['id'];
                // query statement to get course information and instructor
                $query = "SELECT p.*,u.* FROM DiscussionPagesPost_tbl p inner join Users_tbl u on u.user_id = p.user_id where post_id='$post_id'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    $row = mysqli_fetch_assoc($query_run);
                        
                ?>
                <a class="backIcon" href="discussion.php">
                                <i class='fa-solid fa-arrow-left'></i>
                                </a>
                        <div class="discussions">
                        <div>
                            <div class='courseName'>
							<p>Discussion <?=$row["post_id"]; ?>  On: <?=$row["post_date"]; ?> <?=$row["post_time"]; ?> By: <?=$row["user_name"]; ?></p>
                            </div>
                            <div class="discussionText">
                                <p class="plainText"><?=$row["post_text"]; ?></p> 
                            </div>
                            
                        </div>

                        
                    </div>
                    <?php  
                    
                    
                }
            }
            ?>
            
            <div class="discussions" style="display:block !important">
            <p>Replies: </p>
            <?php
    if(isset($_GET['id'])){
        $post_id = $_GET['id'];
                // query statement to get course information and instructor
                $query = "SELECT r.*,u.* FROM DiscussionReply_tbl r inner join Users_tbl u on u.user_id = r.user_id where post_id='$post_id'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        
                ?>
                        <div>
                            <div class='courseName'>
							
                            </div>
                            <div class="discussionText">
                                <p class="plainText"><?=$row["reply_text"]; ?></p> 
                                <p>On: <?=$row["reply_date"]; ?> <?=$row["reply_time"]; ?> By: <?=$row["user_name"]; ?>   </p>
                            </div>
                            <input type="text" name="coursename" value="">
                            <div class="submit__button">
                        <button class="edit--btn" name="update_course">Post</button>
                        
                    </div>
                        </div>

                        
                    <?php  
                    
                    
                }
            }
            }
            ?>
            
            </div>
            <div class="discussions" style="display:block !important">
            <p>Suggestions: </p>
            <?php
    if(isset($_GET['id'])){
        $post_id = $_GET['id'];
                // query statement to get course information and instructor
                $query = "SELECT s.*,u.* FROM DiscussionSuggestion_tbl s inner join Users_tbl u on u.user_id = s.user_id where post_id='$post_id'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        
                ?>
                        
                        <div>
                            <div class='courseName'>
							
                            </div>
                            <div class="discussionText">
                            <p class="plainText"><?=$row["sugguestion_text"]; ?></p> 
                                <p>On: <?=$row["suggestion_date"]; ?> <?=$row["suggestion_time"]; ?> By: <?=$row["user_name"]; ?>   </p>
                            </div>
                            
                        </div>
                        <input type="text" name="coursename" value="">
                        <div class="submit__button">
                        <button class="edit--btn" name="update_course">Submit</button>
                        
                    </div>
                        
                    <?php  
                    
                    
                }
            }
            }
            ?>
            
            </div>
    </div>
    <!-- last two divs are for the sidebar and content -->
    </div>
</div>
</body>
</html>