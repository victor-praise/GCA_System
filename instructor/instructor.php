<!-- 40206992 -->
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
    <title>Select Course</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    
</head>
<body>
   
    <div class="course__container">
        <div class="course__message">
            Welcome instructor <?= $_SESSION['username'] ?> please select a course from the list below
        </div>
        <?php
                // query statement to get course information based on instructor
                $query = "SELECT * from Instructor_tbl t, CourseSection_tbl c where t.user_id = '$user_id' and t.course_id = c.course_id;
                ";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        
                ?>
                       <div class="mycourses">
                           <a href="instructor_course.php?id=<?=$row["course_id"]?>"><?=$row["course_name"]; ?> </a>
                       
                       </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "You currently have no course assigned to you. Please contact admin";
                }
            ?>
        
    </div>
</body>
</html>