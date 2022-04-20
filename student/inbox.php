<?php session_start(); 
        require_once "../connection.php";
        if(isset($_GET['id'])){
           $from_user = $_GET['id'];
           $user_id = $_SESSION['id'];
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Checks if fields are empty
                  if(empty(trim($_POST["announcement"]))){
                    $announcement_error = "Enter announcement.";
                } 
                if(empty($announcement_error)){
                    //insert into announcement table
                    $sql_announcement = "INSERT INTO Announcement_tbl (announcement) VALUES (?)";
                    
                    if($stmt = mysqli_prepare($con, $sql_announcement)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s",$param_announcement);
                        
                        // Set parameters 
                        $param_announcement = trim($_POST["announcement"]);
                       
                     
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                          $announcement_success = "Announcement created";
                          $announcement_error = "";
                        } else{
                            $announcement_success="";
                            $announcement_error = "Oops! Something went wrong. Please try again later";
                            
                        }
            
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                    
                }
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

    <div class="admin--welcome">
         <h2>
         Your conversation
         </h2>
     </div>

     <div class="conversation--box">
         <div class="chats">
         <?php
                // query statement to get marked entities in a course
                $query = "SELECT * FROM PrivateMessage_tbl WHERE from_user = '$from_user' AND to_user = '$user_id' ORDER BY msg_id DESC;
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
                else {
                    echo "you have no message(s) from this person";
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
                      echo "you have no message(s) from this person";
                  }
            ?>
         </div>
         <div class="chat--field">
             <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="courseForm">
                <input type="text" placeholder="Enter reply">
                <button class="create--btn">Reply</button>
             </form>
            
         </div>
     </div>
 
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
</body>
</html>