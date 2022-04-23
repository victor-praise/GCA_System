<!-- 40206992 -->
<?php
session_start(); 
    require_once "../connection.php";
// updates course
    if(isset($_POST['update_course'])){
        $course_id = trim($_POST["course_id"]);

        $sql = "UPDATE CourseSection_tbl SET course_name = ?, course_subject = ?, course_number = ?,course_section = ?, course_term = ?, course_year = ? WHERE course_id = '$course_id'" ;

        // sql to update instructor table
        $sql_instructor = "UPDATE Instructor_tbl SET user_id = ? WHERE course_id = '$course_id'";

        //updates course
        if($stmt = mysqli_prepare($con, $sql)){
             // Bind variables to the prepared statement as parameters
             mysqli_stmt_bind_param($stmt, "ssssss", $param_coursename,$param_coursesubject,$param_coursenumber,$param_coursesection,$param_term,$param_year);

             $param_coursename = trim($_POST["coursename"]);
             $param_term = trim($_POST["courseterm"]);
             $param_year = trim($_POST["courseyear"]);
             $param_coursesubject = trim($_POST["coursesubject"]);
             $param_coursenumber = trim($_POST["coursenumber"]);
             $param_coursesection = trim($_POST["coursesection"]);
                    // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                
                    $_SESSION["message"] = "updated";
                    header("location: ../admin/courses.php");
                
               
                    
                       
            } else{
                    echo "Oops! Something went wrong. Please try again later.";
            }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
        }
        if($stmt = mysqli_prepare($con, $sql_instructor)){
             // Bind variables to the prepared statement as parameters
             mysqli_stmt_bind_param($stmt, "s", $param_user_id);

             
             $param_user_id = trim($_POST["instructor"]);
                    // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                   
                    
                       
            } else{
                    echo "Oops! Something went wrong. Please try again later.";
            }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
        }
    }
// deletes announcement
    if(isset($_POST['announcement_delete'])){
            $id = trim($_POST["announcement_delete"]);
            $query = "DELETE FROM Announcement_tbl WHERE id='$id'";
            $query_run = mysqli_query($con,$query);
            if($query_run){
                header("location: ../admin/announcement.php");
                exit(0);
            }
            else{
                header("location: ../admin/announcement.php");
                echo 'unable to delete';
                exit(0);
            }
    }
// deletes users
    if(isset($_POST['user_delete'])){
        $user_id = trim($_POST["user_delete"]);
        $query = "DELETE FROM Users_tbl WHERE user_id='$user_id'";
        $query_run = mysqli_query($con,$query);
        if($query_run){
            unset($_SESSION['error']);
            $_SESSION["success"] = "updated";
            header("location: ../admin/users.php");
            exit(0);
        }
        else{
                unset($_SESSION['success']);
                $_SESSION["error"]='add error';
                header("location: ../admin/users.php");
                exit(0);
        }
}
// filters users
    if(isset($_POST['filterusers'])){
        $filter_option = trim($_POST["filteroption"]);
        $_SESSION['filter'] = $filter_option;
            unset($_SESSION['error']);
            unset($_SESSION['success']);
            header("location: ../admin/users.php");   
}

// updates user
if(isset($_POST['update_user'])){
        $user_id = trim($_POST["user_id"]);
        // Prepare a select statement
        $sql = "SELECT user_id FROM Users_tbl u WHERE u.user_name = ? AND u.user_id != ?";
        $error = "";
        // ensures course does not exists before creating
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
           
            mysqli_stmt_bind_param($stmt, "ss",$param_username,$param_userid);
            
            // Set parameters
            $param_username = trim($_POST["newusername"]);
            $param_userid = $user_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $error = "This Username is already in the system.";
                    $_SESSION["updateusererror"]=$error;
                    header("location: ../admin/edit_user.php?id=".$user_id);

                }
            } else{
                $error = "Oops! Something went wrong. Please try again later.";
                $_SESSION["updateusererror"]=$error;
                header("location: ../admin/edit_user.php?id=".$user_id);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        if(empty($error)){
            $sql = "UPDATE Users_tbl SET
             user_name = ?,
             user_email = ?,
             user_role = ? 
             WHERE user_id = '$user_id'";

            //updates user
            if($stmt = mysqli_prepare($con, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username,$param_useremail,$param_userrole);

                $param_username = trim($_POST["newusername"]);
                $param_useremail = trim($_POST["newemail"]);
                $param_userrole = trim($_POST["newrole"]);
                        // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    unset($_SESSION['updateusererror']);
                    header("location: ../admin/edit_user.php?id=".$user_id);      
                } else{
                    $_SESSION["updateusererror"]='Oops! Something went wrong. Please try again later.';
                    header("location: ../admin/edit_user.php?id=".$user_id);
                }
            
                        // Close statement
                        mysqli_stmt_close($stmt);
            }
        }
    
}

?>
