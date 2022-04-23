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
      <title>View All Files</title>
      <link rel="stylesheet" href="../style.scss">
      <link rel="stylesheet" href="../includes/styles.scss">
      <link rel="stylesheet" href="../admin/admin.scss">
      <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
      <!-- makes toastr work -->
      <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
   </head>
   <body>
      <?php include('../includes/header.php'); ?>
      <?php include('../includes/sidebar.php'); ?>
      <div class="courses__list" style="display:block">
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
            <a href="discussionDetails.php?id=<?=$_GET['id']?>&GMEId=<?=$_GET['GMEId']?>&Grp=<?=$_GET['Grp']?>" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>

            <div class="container">
            <div class="subforum">
               <div class="subforum-title">
                  <h1>Files</h1>
               </div>
         <?php
            if(isset($_GET['id'])){
                $group_id = $_GET['Grp'];
                        // query statement to get course information and instructor
                        $query = "SELECT f.file_id,f.file_name,f.file_permission,f.file_date,g.entity_name, (SELECT user_name from Users_tbl where user_id=f.user_id) as user_name FROM File_tbl f inner join GroupMarked_tbl g on g.GME_id =f.GME_id where f.group_id='$group_id'";
                        //$query = "SELECT * from File_tbl where group_id='4924555'";
                        $query_run = mysqli_query($con, $query);
                        if(mysqli_num_rows($query_run) > 0)        
                        {
                           while($row = mysqli_fetch_assoc($query_run))
                           {
                                
                        ?>
         
               <div class="subforum-row" style="grid-template-columns: 20% 20% 20% 20% 20%;">
                  <div class="subforum-info  subforum-column">
                  <a style="border-bottom: 1px solid;" name="downloadFile" href="groupfileControl.php?file_id=<?=$row['file_id'];?>&action=get"><?=$row["file_name"]; ?></a>
                  </div>
                  <div class="subforum-info  subforum-column">
                     <p><?=$row["file_permission"]; ?></p>
                  </div>
                  <div class="subforum-info  subforum-column">
                     <b><a href="">Uploaded</a></b> by <?=$row["user_name"]; ?> 
                     <br>on <small><?=$row["file_date"]; ?></small>
                  </div>
                  <div class="subforum-info  subforum-column">
                     <p><?=$row["entity_name"]; ?></p>
                  </div>
                  <div class="subforum-info  subforum-column">
                  <?php
                  if($row["file_permission"]=='Full')
                  {
                  ?>
                  <a style="border:none" href="fileUpdate.php?file_id=<?=$row['file_id'];?>&action=upd&id=<?=$_GET['id']?>&GMEId=<?=$_GET['GMEId']?>&Grp=<?=$_GET['Grp']?>">
                  <i class='fa-solid fa-pencil'></i>
                  </button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <a name="deleteFile" href="groupfileControl.php?file_id=<?=$row['file_id'];?>&action=del&id=<?=$_GET['id']?>&GMEId=<?=$_GET['GMEId']?>&Grp=<?=$_GET['Grp']?>">
                            <i class='fa-solid fa-trash-can'></i>
                           </a>
                  <?php  
                  }
               ?>

                  </div>
               </div>
               <hr class="subforum-divider">
            <?php  
               }
            }
               }
               ?>
         <!-- last two divs are for the sidebar and content -->
      </div>
      </div>
      <div id="myModal" class="modal" >
   
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
   
        <form action="groupfileControl.php?action=upd&id=<?=$_GET['id']?>&GMEId=<?=$_GET['GMEId']?>&Grp=<?=$_GET['Grp']?>" method="post"  class="courseForm">
        <div class="form-group">
            <h3>Update File</h3>
            <hr class="subforum-divider">
            <br><br>
            <input type="hidden" id="hdnFileId" name="hdnFileId" value="">
            <div class="formGroup form--term">
                  <div class="form--input">
                     <b>Select file to upload:</b>
                     <input style="width: 88%;" type="file" name="replyFile">
                     <br><br>
                     <label>File Permission</label>
                    <select name="filePermission" value="1">
                        <option>Full</option>
                        <option>Read</option>
                    </select>
                  </div>
            </div>
        </div>
            <div class="btn__container">
            <button class="submit--btn" name="updateFile">Upload</button>
            </div>
            <!-- modal script -->
<script>
    console.log("test");
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
 
  modal.style.display = "block";
  document.getElementById("hdnFileId").value=btn.name;
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