<?php session_start(); 
        require_once "../connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit course</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>


    <div class="course__edit">
        <div class="edit__header">
            Edit Course
        </div>
        <!-- get particular course data from database using id -->
        <?php 
        // ensures data exists
            if(isset($_GET['id'])){
                $user_id = $_GET['id'];
            }
            // queries database
            $query = "SELECT u.*,r.*,c.* from Users_tbl u, role_tbl r,coursesection_tbl c where c.course_id = '$user_id' AND c.course_id = r.course_id AND u.user_id = r.user_id;
            ";
             $query_run = mysqli_query($con, $query);

             if(mysqli_num_rows($query_run) > 0){
                 foreach($query_run as $user){
                    ?>
                       
                    
                <form class="edit__form">
                    <div class="formGroup">
                        <label for="">Course Name</label>
                        <input type="text" name="coursename" value="<?=$user['course_name'];?>">
                    </div>
                    <div class="formGroup form--term">
                        <div class="form--input">
                        <label for="">Course Subject</label>
                        <input type="text" placeholder="Enter instructor name" name="instrname" value="<?=$user['course_subject'];?>">
                        </div>
                        <div class="form--input">
                        <label for="">Course Number</label>
                        <input type="text" placeholder="Enter instructor name" name="instrname" value="<?=$user['course_number'];?>">
                        </div>
                    </div>
                    <div class="formGroup form--term">
                    <div class="form--input">
                    <label>Course Term</label>
                    <select name="courseterm" value="<?=$user['course_term'];?>">
                        <option>FALL</option>
                        <option>WINTER</option>
                        <option>SUMMER</option>
                    </select>
                </div>
                <div class="form--input">
                    <label>Course Year</label>
                    <input type="text" name="courseyear" value="<?=$user['course_year'];?>">
                </div>
                    </div>
                    <div class="formGroup form--term">
                        <div class="form--input">
                        <label for="">Instructor</label>
                        <input type="text" placeholder="Enter instructor name" name="instrname" value="<?=$user['user_name'];?>">
                        </div>
                        <div class="form--input">
                        <label for="">Course Section</label>
                        <input type="text" placeholder="Enter instructor name" name="instrname" value="<?=$user['course_section'];?>">
                        </div>
                        
                    </div>
                    <div class="submit__button">
                        <button class="edit--btn">Edit</button>
                        <button class="cancel--btn">Cancel</button>
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