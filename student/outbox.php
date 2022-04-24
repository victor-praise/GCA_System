<!-- 40206992, fung sim LEUNG 40195538-->
<?php session_start(); 
        require_once "../connection.php";
      $user_id = $_SESSION['id'];
      $outbox = 1;
      $_SESSION["outbox"] = $outbox;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outbox</title>
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
    <div class="create--course">
         <button class="create--btn add--student" id="btn"><i class="fa-solid fa-plus"></i> Start Conversation</button>
     </div>
   
     <div class="admin--welcome">
         <h2>
         Outbox
         </h2>
         <div class="header--text message--header">
         Click the button above to start a conversation or continue chatting with group members
         <a href="../student/messages.php" class="back--link">Go to Inbox</a>
    </div>   

     </div>

     <div class="information--student">
   
   <?php
           // query statement to get message
           $query = "SELECT DISTINCT to_user FROM PrivateMessage_tbl WHERE from_user = '$user_id' ORDER BY msg_date ASC, msg_time ASC;
           ;
           ";
           $query_run = mysqli_query($con, $query);
           if(mysqli_num_rows($query_run) > 0)        
           {
               while($row = mysqli_fetch_assoc($query_run))
               {
                   
           ?>
            
                  <?php 
                            $fromUser = $row['to_user'];
                            

                            $query_message = "SELECT DISTINCT * FROM PrivateMessage_tbl WHERE to_user = '$fromUser' ORDER BY msg_date DESC, msg_time DESC LIMIT 1";
                            $query_runmessage = mysqli_query($con, $query_message);
                            
                            if(mysqli_num_rows($query_runmessage) > 0)        
                            {
                                while($submittedrow = mysqli_fetch_assoc($query_runmessage))
                                {  
                                    
                            ?>
                                    <div class="student" >
                                    <?php 
                            // gets message receiver
                                $user_idnew = $submittedrow["to_user"];
                                $query_user = "SELECT * from Users_tbl where user_id = '$user_idnew'";

                            $query_runSubmission = mysqli_query($con, $query_user);
                            if(mysqli_num_rows($query_runSubmission) > 0) {
                                while($userrow = mysqli_fetch_assoc($query_runSubmission))
                                {
                                  
                                        echo '
                                        <div class="email user--name">
                                        <label class="entity-info">To</label>
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
                                        <a href="message.php?id=<?=$submittedrow["to_user"]?>">
                                            <i class="fa-solid fa-message"></i>
                                         </a>
                                        

                                        </div>
                                               
                                       
                                <?php  
                                } 
                                
                            }
                            else {
                                echo "There are no entites added, please check back later";
                            }
                        }
                       
                         
                        ?>
                 
                   
                
               
                   <?php  
               } 
               
           
           else {
               echo "No Message, you can click the button above to start a conversation";
           }
       ?>

</div>

<div id="myModal" class="modal" >
   
   <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="inbox-functionality.php" method="post"  class="courseForm">     
        <div class="form-group">
                <div class="form--input student--select">
                <label>Select Groupmember</label>
                <input type="hidden" name="outbox" value="<?=$outbox;?>">
                <input type="hidden" name="fromuser" value="<?=$user_id?>">
                 <select name="touser" class="student--select" required>
                 <!-- gets group members in particular group -->
                <?php
                // query statement to get Group members
                $query = "SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id'";          
                $group_id_query = mysqli_query($con, "SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id'")
                or die(mysqli_error($con));
               
                
                $member_id = mysqli_query($con, "SELECT G2.user_id FROM GroupMember_tbl AS G2 WHERE (G2.user_id <> '$user_id' AND G2.group_id IN (SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id')) ")
                or die(mysqli_error($con));
                
                $member_name = mysqli_query($con, "SELECT Users_tbl.user_fullname FROM Users_tbl WHERE Users_tbl.user_id IN (SELECT G2.user_id FROM GroupMember_tbl AS G2 WHERE (G2.user_id <> '$user_id' AND G2.group_id IN (SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id'))) ")
                or die(mysqli_error($con));

                while ($row = mysqli_fetch_array($member_name) and $row2=mysqli_fetch_array($member_id)) {
                  echo "<option value='" . $row2['user_id'] ."'>" . $row['user_fullname']."</option>";
                }
                
                ?>
                </select> 
                </div>
            
                <div class="form--input student--select">
                    <input type="message" name="reply" placeholder="enter first message">
                </div>
            
            </div> 
            <div class="btn__container">
            <button class="submit--btn" name="sendmessage">Send message</button>
            </div>
           
    </form>
   </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>


<!-- modal script -->
<script>
  
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
 
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>

</html>