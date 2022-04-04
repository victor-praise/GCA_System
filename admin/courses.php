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
    <title>View Courses</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>

    <!-- makes toastr work -->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
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
                // query statement to get course information and instructor
                $query = "SELECT c.*,r.*,u.* FROM CourseSection_tbl c JOIN Instructor_tbl r ON c.course_id = r.course_id JOIN users_tbl u ON r.user_id = u.user_id;
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
                            
                        
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
                            <button class="delete--btn" value="<?=$row["course_id"]?>" name="course_delete">
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                            
                            </form>
                            
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