<!-- php for editing course -->
<?php
session_start(); 
    require_once "../connection.php";

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

?>
