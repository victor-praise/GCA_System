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
                $course_id = $_GET['id'];
                $_SESSION["message"] = "no action";
         
           
            // queries database
            $query = "SELECT u.*,r.*,c.* from Users_tbl u, Instructor_tbl r,CourseSection_tbl c where c.course_id = '$course_id' AND c.course_id = r.course_id AND u.user_id = r.user_id;
            ";
             $query_run = mysqli_query($con, $query);

             if(mysqli_num_rows($query_run) > 0){
                 foreach($query_run as $user){
                    ?>
                       
                    
                <form action="edit.php" method="POST" class="edit__form">
                    <input type="hidden" name="course_id" value="<?=$user['course_id'];?>">
                    <div class="formGroup">
                        <label for="">Course Name</label>
                        <input type="text" name="coursename" 
                        onkeypress="return /[a-z]/i.test(event.key)"
                        value="<?=$user['course_name'];?>">
                    </div>
                    <div class="formGroup form--term">
                        <div class="form--input">
                        <label for="">Course Subject</label>
                        <input type="text" maxlength="4" 
                        onkeypress="return /[a-z]/i.test(event.key)"
                        placeholder="Enter instructor name" name="coursesubject" value="<?=$user['course_subject'];?>">
                        </div>
                        <div class="form--input">
                        <label for="">Course Number</label>
                        <input type="text" placeholder="Enter instructor name" name="coursenumber" value="<?=$user['course_number'];?>">
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
                        <select name="instructor" value="<?=$user['user_name'];?>" class="select--instructor" required>
                <!-- gets instructors from user table -->   
                    <?php
                // query statement to get course information and instructor
                        $query = "SELECT * from Users_tbl WHERE user_role = 'instructor'";
                        $query_run = mysqli_query($con, $query);
                        if(mysqli_num_rows($query_run) > 0)        
                        {
                            while($row = mysqli_fetch_assoc($query_run))
                        {

                            if($row['user_name'] == $user['user_name']){
                                echo "<option class='instructor--names' selected value='{$row['user_id']}'> {$row['user_name']}</option>";
                            }
                            else{
                                echo "<option class='instructor--names' value='{$row['user_id']}'> {$row['user_name']}</option>";
                            }
                         
                        }
                }
                ?>
                </select>
                        
                    </div>
                        <div class="form--input">
                        <label for="">Course Section</label>
                        <input type="text" placeholder="Enter Course Section" 
                        onkeypress="return /[a-z]/i.test(event.key)"
                        name="coursesection" value="<?=$user['course_section'];?>">
                        </div>
                        
                    </div>
                    <div class="ta__students">
                        <a href="../student/students.php?id=<?=$course_id?>">View Students</a>
                        <a href="../ta/ta.php?id=<?=$course_id?>">View Ta's</a>
                    </div>
                    <div class="submit__button">
                        <button class="edit--btn" name="update_course">Edit</button>
                        <a href="../admin/courses.php" class="cancel--link">
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
            }
        ?>
    </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
</body>
</html>