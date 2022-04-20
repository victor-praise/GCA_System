<?php session_start(); 
        require_once "../connection.php";
        $reply_error="";
        if(isset($_GET['id'])){
           $from_user = $_GET['id'];
           $user_id = $_SESSION['id'];
        }
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>course</title>
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
         Your conversation
         </h2>
     </div>

     <div class="conversation--box">
         <div class="chats">
         <?php
                // query statement to get marked entities in a course
                $query = "SELECT * FROM PrivateMessage_tbl WHERE from_user = '$from_user' AND to_user = '$user_id' ORDER BY msg_date ASC, msg_time ASC;
                ;
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="received--message" >
                           
                        <div class="name received--text"> 
                        <label class="entity-info time--info"><?=$row["msg_date"]; ?> <?=$row["msg_time"]; ?></label>
                          <?=$row["msg_text"]; ?> 
                        </div>
                      </div>
                    <?php  
                    } 
                    
                }
              
                // another query
                 
                 $query_sent = "SELECT * FROM PrivateMessage_tbl WHERE from_user = '$user_id' AND to_user = '$from_user' ORDER BY msg_id DESC;
                 ;
                 ";
                  $query_sentrun = mysqli_query($con, $query_sent);
                  if(mysqli_num_rows($query_sentrun) > 0)        
                  {
                      while($row = mysqli_fetch_assoc($query_sentrun))
                      {  
                          
                  ?>
                          <div class="sent--message" >
                             
                          <div class="name received--text"> 
                          <label class="entity-info time--info"><?=$row["msg_date"]; ?> <?=$row["msg_time"]; ?></label>
                              <?=$row["msg_text"]; ?> 
                          </div>
                        </div>
                      <?php  
                      } 
                      
                  }
                  else {
                      echo "";
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
</body>
</html>