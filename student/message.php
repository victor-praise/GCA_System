<?php session_start(); 
        require_once "../connection.php";
        $reply_error="";
        if(isset($_GET['id'])){
           $from_user = $_GET['id'];
           $user_id = $_SESSION['id'];
            $userName = "";
           $queryuser = "SELECT * FROM Users_tbl WHERE user_id='$from_user'";
           $query_runuser = mysqli_query($con,$queryuser);
          
            if(mysqli_num_rows($query_runuser) > 0)        
            {
                while($row = mysqli_fetch_assoc($query_runuser))
                {
                    $userName = $row['user_name'];
                 }
           }
           else{
               // header("location: ../instructor/groups.php");
               echo 'user does not exist';
               
               
           }
        }
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
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
    <?php 
          if(isset($_SESSION["outbox"])){
            echo '<a href="../student/outbox.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> back</a>';
        }
        else{
          echo ' <a href="../student/messages.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> back</a>';
        }
       
       ?>
   
    <div class="admin--welcome">
         <h2>
         Your conversation with <?= $userName?>
         </h2>
     </div>

     <div class="conversation--box">
         <div class="chats" id="messages">
         <?php
                // query statement to get user's messages in a course
                $query = "SELECT * FROM PrivateMessage_tbl WHERE (from_user = '$from_user' AND to_user = '$user_id') OR (from_user = '$user_id' AND to_user = '$from_user') ORDER BY msg_date ASC, msg_time ASC;
                ;
                ";
                $query_run = mysqli_query($con, $query);

                // start and end of the limit parameter
                $i=0;
                $j=1;
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        $query_top = "SELECT msg_id, msg_text, from_user, to_user, msg_date, msg_time FROM PrivateMessage_tbl WHERE (from_user = '$from_user' AND to_user = '$user_id') OR (from_user = '$user_id' AND to_user = '$from_user') ORDER BY msg_date ASC, msg_time ASC LIMIT $i,$j;
                        ;
                        ";
                        $query_top_run = mysqli_query($con, $query_top);
                        $result = mysqli_fetch_assoc($query_top_run);
                        $i=$i+1;
                        $j=$j+1;
                        if($result["to_user"] == $user_id)        
                            {
                                ?>
                                        <div class="received--message" >
                                        
                                        <div class="name received--text"> 
                                        <label class="entity-info time--info"><?=$result["msg_date"]; ?> <?=$result["msg_time"]; ?></label>
                                        <?=$result["msg_text"]; ?> 
                                        </div>
                                    </div>
                                    <?php  
                                   

                        } else if($result["from_user"] == $user_id) {
                            ?>
                                <div class="sent--message" >
                                    
                                    <div class="name received--text"> 
                                    <label class="entity-info time--info"><?=$result["msg_date"]; ?> <?=$result["msg_time"]; ?></label>
                                        <?=$result["msg_text"]; ?> 
                                    </div>
                                </div>
                          <?php
                          
                                   

                        } else {
                        echo "";
                        }

                    }
                
                }
                ?>


         </div>
         <div class="chat--field">
             <form action="inbox-functionality.php" method="post">
                 <input type="hidden" name="fromuser" value="<?=$user_id; ?>" class="dont--show">
                 <input type="hidden" name="touser" value="<?=$from_user; ?>" class="dont--show">
                <input type="text" placeholder="Enter reply" name="reply" class="reply--input">
                <button class="create--btn" name="sendmessage">Reply</button>
             </form>
            
         </div>
     </div>
 
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>

<!-- starts chat at the bottom -->
<script>

const messages = document.getElementById('messages');
function getMessages() {
	// Prior to getting your messages.
  shouldScroll = messages.scrollTop + messages.clientHeight === messages.scrollHeight;

  if (!shouldScroll) {
    scrollToBottom();
  }
}

function scrollToBottom() {
  messages.scrollTop = messages.scrollHeight;
}

scrollToBottom();
</script>
</body>
</html>