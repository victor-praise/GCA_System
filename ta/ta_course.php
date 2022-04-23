<!-- 40206992, 40195161 -->
<?php session_start(); 
        require_once "../connection.php";
        if(isset($_GET['id'])){
            $_SESSION["courseid"] = $_GET['id'];
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
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

    <div class="container">
                <div class="subforum">
                    <div class="subforum-title">
                        <h1>Group Discussions</h1>
                    </div>
                    <?php
                // query statement to get course information and instructor
                $userId=$_SESSION["id"];
                $courseId=$_SESSION["courseid"];
                $query = "SELECT distinct * from DiscussionPagesPost_tbl where gme_id IS NOT NULL and group_id IS NOT NULL and course_id='$courseId' order by post_date desc";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        $tmpUserId=$row["user_id"];
                     $tmpGroupId=$row["group_id"];
                     $tmpGMEId=$row["GME_id"];
                     $query2 = "SELECT * from Users_tbl where user_id= '$tmpUserId'";
                     $query_run2 = mysqli_query($con, $query2);
                     $row2 = mysqli_fetch_assoc($query_run2);
                     $query3 = "SELECT * from Group_tbl where group_id= '$tmpGroupId'";
                     $query_run3 = mysqli_query($con, $query3);
                     $row3 = mysqli_fetch_assoc($query_run3);
                     $query4 = "SELECT * from GroupMarked_tbl where GME_id= '$tmpGMEId'";
                     $query_run4 = mysqli_query($con, $query4);
                     $row4 = mysqli_fetch_assoc($query_run4);
                ?>
                    <div class="subforum-row">
                        <div class="subforum-description  subforum-column">
                        <h4><a href="#"><?=$row3["group_name"]; ?>_<?=$row4["entity_name"]; ?></a></h4>
                            <p><?=$row["post_text"]; ?></p>
                        </div>
                        <!-- <div class="subforum-stats  subforum-column center">
                            <span>24 Posts | 12 Topics</span>
                        </div> -->
                        <div class="subforum-info  subforum-column">
                        <b><a href="">Last post</a></b> by <?=$row2["user_name"]; ?> 
                        <br>on <small><?=$row["post_date"]; ?></small>
                        </div>
                        <div class="subforum-info  subforum-column">
                        <a href="discussionDetails.php?id=<?=$row["post_id"]?>&GMEId=<?=$row["GME_id"]?>&Grp=<?=$row["group_id"]?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            </div>
                    </div>
                    <hr class="subforum-divider">
                    <?php  
                    } 
                    
                }
                else {
                    echo "No Discussions are there to read";
                }
            ?>
                </div>
                            
                <div class="subforum">
                <div class="subforum-title" style="display: flex;align-items: center;">
                        <h1>General Discussions</h1>
                        <div style="padding-left: 55%;margin-top: 1%;"><button class="create--course create--btn add--student" id="btnAddGenDiscussion"><i class="fa-solid fa-plus"></i> General Discussion</button></div>
                    </div>
                    <?php
                // query statement to get course information and instructor
                $userId=$_SESSION["id"];
                $courseId=$_SESSION["courseid"];
                $query = "SELECT p.post_id,p.post_text,p.user_id,(SELECT user_name from Users_tbl where user_id=p.user_id) as user_name,p.post_time,p.post_date from DiscussionPagesPost_tbl p
               where p.course_id='$courseId' and p.group_id IS NULL order by p.post_date desc";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                ?>
                    <div class="subforum-row">
                        <div class="subforum-description  subforum-column">
                            <h4><a href="#">Description Title</a></h4>
                            <p><?=$row["post_text"]; ?></p>
                        </div>
                        <!-- <div class="subforum-stats  subforum-column center">
                            <span>24 Posts | 12 Topics</span>
                        </div> -->
                        <div class="subforum-info  subforum-column">
                        <b><a href="">Last post</a></b> by <?=$row["user_name"]; ?> 
                            <br>on <small><?=$row["post_date"]; ?></small>
                        </div>
                        <div class="subforum-info  subforum-column">
                        <a href="discussionDetails.php?id=<?=$row["post_id"]?>&Grp=">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            </div>
                    </div>
                    <hr class="subforum-divider">
                    <?php  
                    } 
                    
                }
                else {
                    echo "No Discussions are there to read";
                }
            ?>
                </div>
            </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
<div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
         <span class="close">&times;</span>
         <form action="createDiscussion.php?id=<?=$_SESSION["courseid"]?>" method="post"  class="courseForm">
            <div class="form-group">
               <label>Enter discussion text</label>
               <textarea type="text" rows="10" cols="110" class="form-control" name="discussionText" value="" required></textarea>
            </div>
            <div class="form-group form--term">
                <div class="form--input">
                    <label>Select Entity</label>
                    <select name="DDLGMEId" value="<?php echo $course_instructor; ?>" class="select--instructor">
                <!-- gets instructors from user table -->   
                <?php
                // query statement to get course information and instructor
                $query = "SELECT * from GroupMarked_tbl";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    echo "<option class='instructor--names' value=''> None</option>";
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        echo "<option class='instructor--names' value='{$row['GME_id']}'> {$row['entity_name']}</option>";
                    }
                }
                ?>
                </select>
                </div>
            </div>
            <div class="btn__container">
               <button class="submit--btn" name="create_discussion">Create</button>
            </div>
         </form>
      </div>
      <!-- modal script -->
      <script>
         console.log("test");
         // Get the modal
         var modal = document.getElementById("myModal");
         
         // Get the button that opens the modal
         var btn = document.getElementById("btnAddGenDiscussion");
         
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