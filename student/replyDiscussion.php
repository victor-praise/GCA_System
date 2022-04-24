<!-- 40195161, rim EL OSTA 40083858 -->
<!-- php for editing course -->
<?php
session_start(); 
    require_once "../connection.php";

    if(isset($_POST['reply'])){
        $replyText = trim($_POST["replyText"]);

        $sql = "INSERT INTO DiscussionReply_tbl (reply_id, post_id, reply_text, user_id, reply_date, reply_time) VALUES (?, ?, ?, ?, current_date(),current_time())";
        $userId=$_SESSION["id"];

        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_reply_id,$param_post_id, $param_reply_text, $param_user_id);
            
            // Set parameters
            $param_reply_id=mt_rand(1000000,9999999);
            $param_post_id=$_GET['id'];
            $param_reply_text=$replyText;
            $param_user_id=$userId;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: discussionDetails.php?id=1");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        if(!empty($_FILES["replyFile"]["name"])){
                // Insert image file name into database
                $file = $_FILES['replyFile']['name'];
                $file_loc = $_FILES['replyFile']['tmp_name'];
                $file_type = $_FILES['replyFile']['type'];
                $folder="../entityupload/";
                $deadline = 
                 /* make file name in lower case */
                $new_file_name = strtolower($file);
                /* make file name in lower case */
                
                // adds cga before uploading file
                $appendix = str_replace(' ','-',$new_file_name);
         $final_file= 'CGA--';
         $final_file .= $_GET['id'];
         $final_file .= '_';
         $final_file .= $appendix; 
    
                // checks if file already exists and replaces file
                if(file_exists("../entityupload/$final_file")){
                    unlink("../entityupload/$final_file");
                }
                if(move_uploaded_file($file_loc,$folder.$final_file) ){
                    $sql = "INSERT INTO File_tbl (file_id, user_id, GME_id, file_name, group_id, file_permission,file_date) VALUES (?, ?, ?, ?, ?, ?,current_date())";
                    
                    if($stmt = mysqli_prepare($con, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ssssss", $param_file_id,$param_user_id, $param_GME_id, $param_file_name, $param_file_groupid, $param_file_permission);
                        
                        // Set parameters
                        $param_file_id= mt_rand(1000000,9999999);
                        $param_user_id=$userId;
                        $param_GME_id=$_GET['GMEId'];
                        $param_file_name=$final_file;
                        $param_file_groupid=$_GET['Grp'];
                        $param_file_permission=trim($_POST["filePermission"]);;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Redirect to login page
                            // header("location: discussionDetails.php?id=1");
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                    //   if($query_run){
                    //     
                    //     exit(0);
                        
                    // }  
                }
    }
    }
    $postId=$_GET['id'];
    $GMEId=$_GET['GMEId'];
    $GroupId=$_GET['Grp'];
    header("location: discussionDetails.php?id=$postId&GMEId=$GMEId&Grp=$GroupId");
?>
