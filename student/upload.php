<!-- uploads submission -->

<?php 
session_start(); 
require_once "../connection.php";
        if(isset($_POST['submit-entity'])){
            $gme_id = trim($_POST["gme_id"]);
            $group_id = $_SESSION["group_id"];
         
            // ensures there is a file
         if(empty($_FILES["gmefile"]["name"])){
            unset($_SESSION['success']);
            $_SESSION["error"]='Please upload a file';
            header("location: ../student/upload-submission.php?gme_id=".$gme_id);
         }
        //  gets file
        $file = $_FILES['gmefile']['name'];
        $file_loc = $_FILES['gmefile']['tmp_name'];
        $file_type = $_FILES['gmefile']['type'];
        $folder="../entityupload/";
        $submission_id = mt_rand(1000000,9999999);
      
         /* make file name in lower case */
        $new_file_name = strtolower($file);
        /* make file name in lower case */
        
        $final_file=str_replace(' ','-',$new_file_name);         
    }
    if(move_uploaded_file($file_loc,$folder.$final_file) ){
      
        $sql_entity = "INSERT INTO FinalSubmission_tbl (submission_id,group_id,GME_id,user_id,file_name,file_type,submission_date) VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP)";
  
        //insert into final submission table
        if($stmt = mysqli_prepare($con, $sql_entity)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss",$param_submissionid,$param_groupid,$param_gmeid,$param_userid,$param_filename,$param_gmetype);
            
            // Set parameters
            $param_submissionid = $submission_id;
            $param_gmeid = $gme_id; 
            $param_groupid = $group_id;
            $param_filename = $final_file;
            $param_userid = $_SESSION['id'];
            $param_gmetype = $file_type;
               
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                unset($_SESSION['error']);
                $_SESSION["success"] = "Entity solution submitted";
                header("location: ../student/upload-submission.php?gme_id=".$gme_id);
            
            } else{
                unset($_SESSION['success']);
                $_SESSION["error"]='Unable to submit file, contact admin';
                header("location: ../student/upload-submission.php?gme_id=".$gme_id);
              
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        
    

        }
?>