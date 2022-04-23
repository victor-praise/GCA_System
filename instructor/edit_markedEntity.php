<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        if(isset($_GET['id'])){   
            $entity_id = $_GET['id'];
            $course_id =  $_SESSION["courseid"];
            $_SESSION["message"] = "no action";
        }
   
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entity</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

 
    <div class="course__edit">
 
        <div class="edit__header">
            Edit Entity
        </div>
        <!-- get particular course data from database using id -->
        <?php 
        // ensures data exists
            
         
           
            // queries database to get particular marked entity
            $query = "SELECT * from GroupMarked_tbl g where g.GME_id = '$entity_id' AND g.course_id='$course_id';
            ";
             $query_run = mysqli_query($con, $query);

             if(mysqli_num_rows($query_run) > 0){
                 foreach($query_run as $entity){
                    ?>
                       
                    
                <form action="updategroup_groupmember.php" method="post"  enctype="multipart/form-data" class="edit__form">
                    <input type="hidden" name="entity_id" value="<?=$entity['GME_id'];?>">
                    <div class="formGroup">
                        <label for="">Entity Name</label>
                        <input type="text" name="entityname" value="<?=$entity['entity_name'];?>">
                    </div>
                    <div class="formGroup form--term">
                        <div class="form--input">
                        <label for="">File uploaded</label>
                       
                        <input type="text" placeholder="Enter instructor name" name="coursesubject" value="<?=$entity['file_name'];?>" disabled>
                      
                       
                 </input>
                        <label for="">Upload new file</label>
                        <input type="file" name="newfile">
                        </div>
                        <div class="form--input">
                        <label for="">Deadline</label>
                        <input type="date" name="entitydeadline" value="<?=$entity['deadline'];?>">
                        </div>
                    </div>                      
                   
                      <div class="ta__students">
                        <a href="../downloadfile.php?file_id=<?=$entity['GME_id'];?>"><i class="fa-solid fa-download"></i> Download file</a>
                        
                    </div> 
                     <div class="submit__button">
                        <button class="edit--btn" name="update_entity">Edit</button>
                        <a href="markedentity.php" class="cancel--link">
                            Cancel
                        </a>
                        
                    </div>
                </form>
        <?php
                 }
                
             }      
             else{
                    ?>
                        <h4>No Record found</h4>
                    <?php
             }
            
        ?>
    </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
</body>
</html>