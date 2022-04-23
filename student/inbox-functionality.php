<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
      
        if(isset($_POST['sendmessage'])){
            // Checks if fields are empty
                $private_messageid = mt_rand(1000000,9999999);
                $user_id = trim($_POST["fromuser"]);
                $from_user = trim($_POST["touser"]);
                  if(empty(trim($_POST["reply"]))){
                    $reply_error = "Enter announcement.";
                } 
                if(empty($reply_error)){
                    //insert into announcement table
                    $sql_announcement = "INSERT INTO PrivateMessage_tbl (msg_id,msg_text,from_user,to_user,msg_date,msg_time) VALUES (?,?,?,?,current_date(),current_time())";
                    
                    if($stmt = mysqli_prepare($con, $sql_announcement)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ssss",$param_id,$param_text,$param_fromuser,$param_touser);
                        
                        // Set parameters 
                        $param_text = trim($_POST["reply"]);
                        $param_id = $private_messageid;
                        $param_fromuser = $user_id;
                        $param_touser = $from_user;
                       
                     
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            if(isset($_POST['outbox'])){
                              
                                header("location: ../student/outbox.php");
                            }
                            else{
                                header("location: ../student/message.php?id=".$from_user);
                            }
                           
                        //   $a_success = "Announcement created";
                          $reply_error = "";
                        } else{
                           
                            $reply_error = "Oops! Something went wrong. Please try again later";
                            
                        }
            
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                    
                }
            }
?>