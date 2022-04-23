<!-- 40206992 -->
<!-- uploads submission -->

<?php 
session_start(); 
require_once "../connection.php";
        if(isset($_POST['submit-entity'])){
            $gme_id = trim($_POST["gme_id"]);
            $group_id = $_SESSION["group_id"];
            $alreadySubmitted = trim($_POST["alreadysubmitted"]);
          
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
        
         // adds cga before uploading file
         $appendix = str_replace(' ','-',$new_file_name);
         $final_file= 'CGA_';
         $final_file .= $appendix; 
       
    //   checks if it should update or insert file in table
          if($alreadySubmitted == 1){
            $sql_entity = "UPDATE FinalSubmission_tbl 
            SET
            file_name = '$final_file',
            file_type = '$file_type',
            submission_date = CURRENT_TIMESTAMP 
            WHERE
            GME_id ='$gme_id' 
            AND 
            group_id = '$group_id'
            ;";
             // checks if file already exists and replaces file
            if(file_exists("../entityupload/$final_file")){
                    unlink("../entityupload/$final_file");
                }
                if(move_uploaded_file($file_loc,$folder.$final_file) ){
                     $query_run = mysqli_query($con,$sql_entity);
                      if($query_run){
                        unset($_SESSION['error']);
                        $_SESSION["success"] = "File updated";
                        header("location: ../student/upload-submission.php?gme_id=".$gme_id);
                        exit(0);
                        
                    }  
                    else{
                        unset($_SESSION['success']);
                        $_SESSION["error"]='Update failed, contact admin';
                        exit(0);
                    }
                }
            
         }
         if($alreadySubmitted == 0){
            $sql_entity = "INSERT INTO FinalSubmission_tbl (submission_id,group_id,GME_id,user_id,file_name,file_type,submission_date) VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP)";
            if(move_uploaded_file($file_loc,$folder.$final_file) ){
      
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
         }


        }
?>