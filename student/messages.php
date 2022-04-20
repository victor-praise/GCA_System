<?php session_start(); 
        require_once "../connection.php";
      $user_id = $_SESSION['id'];
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
    <div class="create--course">
         <button class="create--btn add--student" id="btn"><i class="fa-solid fa-plus"></i> Start conversation</button>
     </div>
   
     <div class="admin--welcome">
         <h2>
         Inbox
         </h2>
         <!-- <div class="header--text">
         Here you can view, and download entites assigned by instructors.
    </div>    -->

     </div>

     <div class="information--student">
   
   <?php
           // query statement to get course information and instructor
           $query = "SELECT DISTINCT from_user FROM PrivateMessage_tbl WHERE to_user = 4024 ORDER BY msg_date;
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
                            

                            $query_message = "SELECT DISTINCT * FROM PrivateMessage_tbl WHERE from_user = '$fromUser' ORDER BY msg_id DESC LIMIT 1";
                            $query_runmessage = mysqli_query($con, $query_message);
                            
                            if(mysqli_num_rows($query_runmessage) > 0)        
                            {
                                while($submittedrow = mysqli_fetch_assoc($query_runmessage))
                                {  
                                    
                            ?>
                                    <div class="student" >
                                    <?php 
                            // gets message sender
                                $user_id = $submittedrow["from_user"];
                                $query_user = "SELECT * from Users_tbl where user_id = '$user_id'";

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
                                        <a href="inbox.php?id=<?=$submittedrow["from_user"]?>">
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
   <form action="add-delete_student.php" method="post"  class="courseForm">     
        <div class="form-group">
                <input type="hidden" name="course_id" value="<?=$course_id;?>">
                <div class="form--input student--select">
                <label>Select Student</label>
                <select name="student" value="<?php echo $course_student; ?>" class="student--select" required>
                <!-- gets instructors from user table -->   
                <?php
                // query statement to get course information and instructor
                $query = "SELECT * from Users_tbl WHERE user_role = 'student'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        echo "<option class='instructor--names' value='{$row['user_id']}'> {$row['user_name']}</option>";
                    }
                }
                ?>
                </select>
                </div>
            
                
            
            </div> 
            <div class="btn__container">
            <button class="submit--btn" name="add__student">Add student</button>
            </div>
           
    </form>
   </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
</body>
</html>