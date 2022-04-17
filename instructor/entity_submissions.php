<?php session_start(); 
        require_once "../connection.php";
        
            $course_id =  $_SESSION["courseid"];
            $group_id = mt_rand(1000000,9999999);
            $group_error = "";
            $group_success = "";
            $group_name = "";
            unset($_SESSION['success']);
        
        
        // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){


        // Checks if fields are empty
              if(empty(trim($_POST["groupname"]))){
                $group_error = "Group name cannot be empty.";
            } 
            else{
                // Prepare a select statement
                $sql = "SELECT group_id FROM Group_tbl g WHERE g.group_id = ? OR g.group_name = ?";
                // ensures course does not exists before creating
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                   
                    mysqli_stmt_bind_param($stmt, "ss", $param_groupid,$param_groupname);
                    
                    // Set parameters
                    $param_groupid = $group_id;
                    $param_groupname = trim($_POST["groupname"]);
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        /* store result */
                        mysqli_stmt_store_result($stmt);
                        
                        if(mysqli_stmt_num_rows($stmt) == 1){
                            $group_error = "This Group is already in the course.";
                          
                        } else{
                          $group_name = trim($_POST["groupname"]);  
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
       
              
            }
            if(empty($group_error)){
                $sql_group = "INSERT INTO Group_tbl (group_id,course_id,group_name) VALUES (?,?,?)";
          
                //insert into student table
                if($stmt = mysqli_prepare($con, $sql_group)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "sss",$param_groupid,$param_courseid,$param_groupname);
                    
                    // Set parameters
                    $param_groupid = $group_id; 
                    $param_courseid = $course_id;
                    $param_groupname = trim($_POST["groupname"]);
                 
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                      $group_success = "Group created";
                      $group_error = "";
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
                
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

    <div class="create--course">
         <button class="create--btn" id="btn"><i class="fa-solid fa-plus"></i> Create Group</button>
     </div>
    <div class="admin--welcome">
         <h2>
         Groups
         </h2>
         <div class="header--text">
         Here you can create,delete and edit already existing groups adding or removing students from group
    </div>   

     </div>
     <?php 
     
        if(!empty($group_error)){
            echo '<div class="alert alert-danger">' . $group_error . '</div>';
        }  
        elseif(!empty($group_success)){
            echo '<div class="success">' . $group_success . '</div>';
        }  
            
        ?>
         <div class="information--student"> 
     <?php
                // query statement to get course information based on instructor
                $query = "SELECT * from Group_tbl g where g.course_id = '$course_id';
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                       
                         $single_groupid = $row['group_id'];
                         
                        
                ?>
                        <div class="student" >
                        <div class="name"> <?=$row["group_name"]; ?> </div>
                        <!-- number of group members -->
                     <?php 
                             $query_groupmember = "SELECT * FROM GroupMember_tbl WHERE group_id = '$single_groupid'";
                             $query_rungroup = mysqli_query($con, $query_groupmember);
                        ?>
                         <div class="email">
                        <?=mysqli_num_rows($query_rungroup); ?> student(s)
                        </div> 
                        <div class="delete">
                        <a href="add_groupmember.php?id=<?=$row['group_id']?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                          <form action="updategroup_groupmember.php" method="post"> 
                          <button class="delete--group-btn" value="<?=$row["group_id"];?>" name="group_delete">
                          
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                          </form>  
                       
                      
                      </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There have been no submissions for this Entity";
                }
            ?>
        </div>
        
        <div id="myModal" class="modal" >
           <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"   class="courseForm">     
        <div class="form-group">
            <label>Enter Group name</label>
            <input type="text" name="groupname" class="form-control" value="<?php echo $group_name; ?>" required>    
        </div> 
            <div class="btn__container">
            <button class="submit--btn">Add group</button>
            </div>
           
    </form>
   </div>
            </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>

</body>
</html>