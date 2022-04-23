<?php session_start(); 
   require_once "../connection.php";
   $dateleft = $_SESSION['dateleft'];

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Discussion Detail</title>
      <link rel="stylesheet" href="../style.scss">
      <link rel="stylesheet" href="../includes/styles.scss">
      <!-- <link rel="stylesheet" href="../admin/admin.scss"> -->
      <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
   </head>
   <body>
      <?php include('../includes/header.php'); ?>
      <?php include('../includes/sidebar.php'); ?>
      <div class="courses__list">
         <?php 
            if(!empty($delete_err)){
                echo '<div class="alert alert-danger">' . $delete_err . '</div>';
            }        
            ?>
     
         <?php
            if(isset($_GET['id'])){
                $post_id = $_GET['id'];
                $group_id = $_GET['group_id'];
                        // query statement to get course information and instructor
                        $query = "SELECT p.*,(Select group_name from Group_tbl where group_id=p.group_id) as GroupName,(Select entity_name from GroupMarked_tbl where GME_id=p.GME_id) as entity_name,u.* FROM DiscussionPagesPost_tbl p inner join Users_tbl u on u.user_id = p.user_id where post_id='$post_id'";
                        $query_run = mysqli_query($con, $query);
                        if(mysqli_num_rows($query_run) > 0)        
                        {
                            $row = mysqli_fetch_assoc($query_run);
                            $_SESSION["discussionGMEID"]=$row["GME_id"];
                            $_SESSION["discussionGrpID"]=$row["group_id"];
                                
                        ?>
         <a href="previousgroupdiscussion.php?id=<?=$group_id ?>" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
         <div class="container">
            <div class="subforum">
               <div class="subforum-title">
                  <?php 
                  if($row["GME_id"]!= null && $row["GME_id"]!= '')
                  {
                  ?>
                  <h1><?=$row["entity_name"]; ?></h1>
                  <?php  
                  }
               ?>
               <?php 
                  if($row["GME_id"]=null)
                  {
                  ?>
                  <h1>Anouncement</h1>
                  <?php  
                  }
               ?>
               </div>
               <div class="subforum-row">
                  <div class="subforum-description  subforum-column">
                     <h4><a href="#">Description</a></h4>
                     <p><?=$row["post_text"]; ?></p>
                  </div>
                  <!-- <div class="subforum-stats  subforum-column center">
                     <span>24 Posts | 12 Topics</span>
                     </div> -->
                 
               </div>
            </div>
            <?php  
               }
               }
               ?>
            <div class="discussions" style="display:block !important">
               <h4><a href="#">Replies:</a></h4>
               <div class="back--link" style="float:right;padding-right:5%" > </div>
               <br>
               <?php
                  if(isset($_GET['id'])){
                      $post_id = $_GET['id'];
                              // query statement to get course information and instructor
                              $query = "SELECT r.*,u.* FROM DiscussionReply_tbl r inner join Users_tbl u on u.user_id = r.user_id where post_id='$post_id' AND reply_date <= '$dateleft'";
                              $query_run = mysqli_query($con, $query);
                              if(mysqli_num_rows($query_run) > 0)        
                              {
                                  while($row = mysqli_fetch_assoc($query_run))
                                  {
                                      
                              ?>
               <div>
                  <div class='courseName'>
                  </div>
                  <div class="discussionText">
                     <p class="plainText"><?=$row["reply_text"]; ?></p>
                     <p>On: <?=$row["reply_date"]; ?> By: <?=$row["user_name"]; ?>   </p>
                  </div>
               </div>
               <?php  
                  }
                  }
                  }
                  ?>
            </div>
         <!-- last two divs are for the sidebar and content -->
      </div>
      </div>
   </body>
</html>