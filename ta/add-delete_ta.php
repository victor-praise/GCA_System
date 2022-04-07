<!-- add student to course -->

<?php
session_start(); 
    require_once "../connection.php";

    if(isset($_POST['add__ta'])){
        $course_id = trim($_POST["course_id"]);
        $course_error="";
             
            // Checks if fields are empty
            if(empty(trim($_POST["ta"]))){
                $course_error = "Ta name cannot be empty.";
            } 
            else{
                // Prepare a select statement
                $sql = "SELECT course_id FROM Ta_tbl s WHERE s.course_id = ? AND s.user_id = ?";
                // ensures course does not exists before creating
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                    // Link - https://www.php.net/manual/en/mysqli-stmt.bind-param.php
                    mysqli_stmt_bind_param($stmt, "ss", $param_courseid,$param_userid);
                    
                    // Set parameters
                    $param_courseid = $course_id;
                    $param_userid = trim($_POST["ta"]);
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        /* store result */
                        mysqli_stmt_store_result($stmt);
                        
                        if(mysqli_stmt_num_rows($stmt) == 1){
                            $_SESSION["error"] = "add error";
                            $course_error = "This TA is already in the course.";
                            header("location: ../ta/ta.php?id=".$course_id);
                        } else{
                          $course_student = trim($_POST["ta"]);  
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
       
              
            }
            if(empty($course_error)){
          
                $sql_student = "INSERT INTO Ta_tbl (user_id,course_id) VALUES (?,?)";
          
                //insert into ta table
                if($stmt = mysqli_prepare($con, $sql_student)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ss",$param_userid,$param_courseid);
                    
                    // Set parameters
                    $param_courseid = $course_id;
                    $param_userid = trim($_POST["ta"]);
                 
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                      $course_error = "";
                      unset($_SESSION['error']);
                      header("location: ../ta/ta.php?id=".$course_id);
                         
                    } else{
                        $_SESSION["error"] = "Unable to delete.";
                        header("location: ../ta/ta.php?id=".$course_id);
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
                
            }
    
       }
       if(isset($_POST['ta_delete'])){
        $ta_id = trim($_POST["ta_delete"]);
        $taCourse_id = trim($_POST["course_taid"]);
        $query = "DELETE FROM Ta_tbl WHERE user_id='$ta_id' AND course_id='$taCourse_id'";
        $query_run = mysqli_query($con,$query);
        if($query_run){
            unset($_SESSION['error']); 
                header("location: ../ta/ta.php?id=".$taCourse_id);
                exit(0);
           
        }
        else{
            $_SESSION["error"] = "delete error";
            $delete_err = "Unable to delete";
            header("location: ../ta/ta.php?id=".$taCourse_id);
            exit(0);
        }
       }

?>