<!-- 40195161 -->
<?php session_start(); 
   require_once "../connection.php";
   // Processing form data when form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){
   $course_id = $_POST["course_delete"];
   $delete_err = "";
   // echo "$course_id";
   $query = "DELETE FROM CourseSection_tbl WHERE course_id='$course_id'";
   $query_run = mysqli_query($con,$query);
   if($query_run){
       header("location: ../admin/courses.php");
       exit(0);
   }
   else{
       $delete_err = "Unable to delete";
       exit(0);
   }
   
   }
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
            if(isset($_SESSION["message"])){
                if($_SESSION["message"] == 'updated'){
                    // script for toastr
                    echo "<script type='text/javascript'>
                    toastr.options = {
                        'closeButton': false,
                        'debug': false,
                        'newestOnTop': false,
                        'progressBar': false,
                        'positionClass': 'toast-bottom-right',
                        'preventDuplicates': false,
                        'onclick': null,
                        'showDuration': '2000',
                        'hideDuration': '2000',
                        'timeOut': '2000',
                        'extendedTimeOut': '2000',
                        'showEasing': 'swing',
                        'hideEasing': 'linear',
                        'showMethod': 'fadeIn',
                        'hideMethod': 'fadeOut'
                      }
                    toastr.success('Course Updated')
                    
                    </script>";
                }
            }
            ?>
         <?php
            if(isset($_GET['id'])){
                $post_id = $_GET['id'];
                        // query statement to get course information and instructor
                        $query = "SELECT p.*,(Select group_name from Group_tbl where group_id=p.group_id) as GroupName,(Select entity_name from GroupMarked_tbl where GME_id=p.GME_id) as entity_name,u.* FROM DiscussionPagesPost_tbl p inner join Users_tbl u on u.user_id = p.user_id where post_id='$post_id'";
                        $query_run = mysqli_query($con, $query);
                        if(mysqli_num_rows($query_run) > 0)        
                        {
                            $row = mysqli_fetch_assoc($query_run);
                                
                        ?>
         <a href="instructor_course.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
         <div class="container">
            <div class="subforum">
               <div class="subforum-title">
                  <?php 
                  if($row["GME_id"]!= null && $row["GME_id"]!= '')
                  {
                  ?>
                  <h1><?=$row["GroupName"]; ?>_<?=$row["entity_name"]; ?></h1>
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
                  <div class="subforum-info  subforum-column">
                     <b><a href="">Last post</a></b> by <?=$row["user_name"]; ?> 
                     <br>on <small><?=$row["post_date"]; ?></small>
                  </div>
               </div>
            </div>
            <?php  
               }
               }
               ?>
            <div class="discussions" style="display:block !important">
               <h4><a href="#">Replies:</a></h4>
               <?php if($_GET["Grp"] != '')
                  {?>
               <div class="back--link" style="float:right;padding-right:5%" > <a href="viewAllFiles.php?id=<?=$_GET['id']?>&GMEId=<?=$_GET['GMEId']?>&Grp=<?=$_GET['Grp']?>">
            View All Files
        </a></div>
        <?php  
                  }
                  ?>
               <br>
               <?php
                  if(isset($_GET['id'])){
                      $post_id = $_GET['id'];
                              // query statement to get course information and instructor
                              $query = "SELECT r.*,u.* FROM DiscussionReply_tbl r inner join Users_tbl u on u.user_id = r.user_id where post_id='$post_id' order by reply_date";
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
               <form action="replyDiscussion.php?id=<?=$_GET['id'];?>&GMEId=<?=$_GET['GMEId'];?>&Grp=<?=$_GET['Grp'];?>" method="post" enctype="multipart/form-data">
                  <textarea type="text" style="width:55%" name="replyText" value=""></textarea>
                  <div class="submit__button" style="float:right; padding-right: 25%">
                     <button class="edit--btn" name="reply">Post</button>
                  </div>
                  <!-- <div class="formGroup form--term">
                  <div class="form--input">
                     <b>Select file to upload:</b>
                     <input style="width: 25%;" type="file" name="replyFile">
                     <label>File Permission</label>
                    <select name="filePermission" value="1">
                        <option>Full</option>
                        <option>Read</option>
                    </select>
                  </div>
               </div> -->
               </form>
            </div>
         <!-- last two divs are for the sidebar and content -->
      </div>
      </div>
   </body>
</html>