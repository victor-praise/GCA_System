<!-- 40195161 -->
<?php
session_start(); 
    require_once "../connection.php";

    if(isset($_POST['create_discussion'])){
        $discussionText = trim($_POST["discussionText"]);
        $courseId = trim($_POST["courseId"]);

        $sql = "INSERT INTO DiscussionPagesPost_tbl (post_id, post_text, GME_id, user_id, group_id, course_id,post_date, post_time) VALUES (?, ?, ?, ?, ?, ?,current_date(),current_time())";
        $userId=$_SESSION["id"];

        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_post_id, $param_post_text, $param_GME_id, $param_user_id, $param_group_id, $param_course_id);
            
            // Set parameters
            $param_post_id=mt_rand(1000000,9999999);;
            $param_post_text=$discussionText;
            $param_GME_id=null;
            $param_user_id=$userId;
            $param_group_id=null;
            $param_course_id=$courseId;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: discussion.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

?>
