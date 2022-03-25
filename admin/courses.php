<?php session_start(); 
        require_once "../connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <div class="courses__list">
    <?php
                // query statement to get course information and instructor
                $query = "SELECT c.*,r.*,u.* FROM CourseSection_tbl c JOIN role_tbl r ON c.course_id = r.course_id AND r.user_role = 'instructor' JOIN users_tbl u ON r.user_id = u.user_id;
                ";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        
                ?>
                        <div class="courses">
                        <div class="course--info">
                            <div class='courseName'>
                                <?=$row["course_name"]; ?>    
                            </div>
                            <div class="courseInstructors">
                                <p>Instructor</p>     
                                <?=$row["user_name"]; ?> 
                            </div>
                            
                        </div>
                      
                        <div class="options">
                    
                            <a href="edit_course.php?id=<?=$row["course_id"]?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            
                        
                            
                            <i class='fa-solid fa-trash-can'></i>
                        </div>
                    </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "No Course Added";
                }
            ?>
    
       
    </div>
    <!-- last two divs are for the sidebar and content -->
    </div>
</div>
</body>
</html>