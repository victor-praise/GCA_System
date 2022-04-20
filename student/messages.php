<?php session_start(); 
        require_once "../connection.php";
      $user_id = $_SESSION['id'];
      unset($_SESSION['outbox']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <link rel="stylesheet" href="../student/student.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?> 
     <div class="admin--welcome">
         <h2>
         Inbox
         </h2>
         <div class="header--text message--header">
         Click the message icon to reply to a message. <a href="../student/outbox.php" class="back--link">Go to Outbox</a>
    </div>   

     </div>

     <div class="information--student">
   
   <?php
           // query statement to get message
           $query = "SELECT DISTINCT from_user FROM PrivateMessage_tbl WHERE to_user = '$user_id' ORDER BY msg_id;
           ;
           ";
           $query_run = mysqli_query($con, $query);
           if(mysqli_num_rows($query_run) > 0)        
           {
               while($row = mysqli_fetch_assoc($query_run))
               {
                   
           ?>
            
                  <?php 
                            $fromUser = $row['from_user'];
                            $query_message = "SELECT DISTINCT * FROM PrivateMessage_tbl WHERE from_user = '$fromUser' AND to_user = '$user_id' ORDER BY msg_id DESC LIMIT 1";
                            $query_runmessage = mysqli_query($con, $query_message);
                            
                            if(mysqli_num_rows($query_runmessage) > 0)        
                            {
                                while($submittedrow = mysqli_fetch_assoc($query_runmessage))
                                {  
                                    
                            ?>
                                    <div class="student" >
                                    <?php 
                            // gets message sender
                                $user_idnew = $submittedrow["from_user"];
                                $query_user = "SELECT * from Users_tbl where user_id = '$user_idnew'";

                            $query_runSubmission = mysqli_query($con, $query_user);
                            if(mysqli_num_rows($query_runSubmission) > 0) {
                                while($userrow = mysqli_fetch_assoc($query_runSubmission))
                                {
                                  
                                        echo '
                                        <div class="email user--name">
                                        <label class="entity-info">From</label>
                                        '.$userrow['user_name'].'
                                        </div>            
                                        '; 
                                   
                                }
                            }
                            else{
                                echo '

                                <div class="email not-submitted">
                                <label class="entity-info">Submission</label>
                                not submitted
                                </div>            
                                ';
                            }
                        ?>
                                     <div class="email message-text">
                                        <label class="entity-info">Message</label>
                                        <?=$submittedrow['msg_text'];?>
                                        </div> 
                                        
                                        <div class="email time--message">
                                        <label class="entity-info">On</label>
                                        <?=$submittedrow['msg_date'];?>
                                        </div> 
                                        <a href="message.php?id=<?=$submittedrow["from_user"]?>">
                                            <i class="fa-solid fa-message"></i>
                                         </a>
                                        

                                        </div>
                                               
                                       
                                <?php  
                                } 
                                
                            }
                            else {
                                echo "There are no entites added, please check back later";
                            }
                            ?>

                            <?php 
                        }
                       
                         
               } 
               
           
           else {
               echo "There are no messages in inbox, click outbox above to start a conversation";
           }
       ?>

</div>


      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
</body>
</html>