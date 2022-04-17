<?php session_start(); 
        require_once "../connection.php";
        $add_error = "";
        $add_student = "";
        $add_success="";
      

        if(isset($_GET['id'])){
        $_SESSION["groupid"] = $_GET['id'];
        }
        if(isset($_SESSION["groupid"])){
            $group_id = $_SESSION["groupid"];
        }
    //adds group member 
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){


        // Checks if fields are empty
              if(empty(trim($_POST["student"]))){
                $add_error = "Select a student.";
            } 
            else{
                // Prepare a select statement
                $sql = "SELECT group_id FROM GroupMember_tbl g WHERE g.user_id = ?";
                // ensures course does not exists before creating
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                   
                    mysqli_stmt_bind_param($stmt, "s",$param_userid);
                    
                    // Set parameters
                    // $param_groupid = $group_id;
                    $param_userid = trim($_POST["student"]);
                  
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        /* store result */
                        mysqli_stmt_store_result($stmt);
                        
                        if(mysqli_stmt_num_rows($stmt) == 1){
                            $add_error = "Student cannot be added to multiple groups, please remove student from existing group.";
                          
                        } else{
                          $add_student = trim($_POST["student"]);  
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
       
              
            }
            if(empty($add_error)){
                $sql_group = "INSERT INTO GroupMember_tbl (group_id,user_id,dateJoined) VALUES (?,?,CURRENT_TIMESTAMP)";
          
                //insert into group member table
                if($stmt = mysqli_prepare($con, $sql_group)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ss",$param_groupid,$param_userid);
                    
                    // Set parameters
                    $param_groupid = $group_id; 
                    $param_userid = trim($_POST["student"]);
                   
                 
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                      $add_success = "Group member added";
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
    <title>Add Group</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <div class="create--course">
         <button class="create--btn add--student" id="btn"><i class="fa-solid fa-plus"></i> Add Student</button>
         <button class="create--btn add--student add--groupmember" id="btnLeader"><i class="fa-solid fa-plus"></i> Select Group Leader</button>
     </div>
          <a href="../instructor/groups.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
<!-- error or success message -->
    <?php 
     
     if(!empty($add_error)){
         echo '<div class="alert alert-danger">' . $add_error . '</div>';
     }  
     elseif(!empty($add_success)){
         echo '<div class="success">' . $add_success . '</div>';
     }   
      
     if(isset($_SESSION["error"])){
       if($_SESSION["error"]='add error'){
         echo '<div class="alert alert-danger"> Update failed </div>';
       }
 
 }  
 if(isset($_SESSION["success"])){
    echo '<div class="success">  Group leader updated </div>';
 }  
     ?>
      <?php 
    //   gets group name
        $query = "SELECT * from Group_tbl g where g.group_id = '$group_id'";
        $query_run = mysqli_query($con, $query);
        if(mysqli_num_rows($query_run) > 0)        
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                
        ?>
                   <h2 class="student__header">Group <?=$row["group_name"]; ?></h2> 
                <?php  
            } 
            
        }
        else {
            echo "";
        }
      
      ?>
    
       
    <div class="information--student">
   
        <?php
                // query statement to get course information and instructor
                $query = "SELECT * from GroupMember_tbl g, Users_tbl c where g.group_id = '$group_id' and g.user_id = c.user_id;
                ";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        
                ?>
                
                      <div class="student" >
                        <div class="name"> <?=$row["user_name"]; ?> </div>
                        <div class="email"><?=$row["user_email"]; ?></div>
                        <!-- group leader -->
                        <?php     
                            // get the particular student that is the group leader
                            $query_getleader = "SELECT * FROM Group_tbl g, GroupMember_tbl gm where g.leader_user_id = gm.user_id";
                            $query_runLeader = mysqli_query($con, $query_getleader);
                            if(mysqli_num_rows($query_runLeader) > 0) {
                                while($leaderrow = mysqli_fetch_assoc($query_runLeader))
                                {
                                    if($leaderrow['user_id'] == $row['user_id']){
                                        echo 'Group leader';
                                    } 
                                    else {
                                        // used to make styling consistent
                                        echo "<div class='hide--text'>group leader</div>";
                                    }
                                }
                            }
                        ?>
                        <div class="delete">
                          <form action="" method="post">
                          <input type="hidden" name="course_studentid" value="<?=$course_id;?>">  
                          <button class="delete--student-btn" value="<?=$row["user_id"]?>" name="student_delete">
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                          </form>  
                       
                      
                      </div>
                      </div>
                        <?php  
                    } 
                    
                }
                else {
                    echo "Group has no member";
                }
            ?>

    </div>
<!-- add group member modal -->
<div id="myModal" class="modal" >
   
   <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  class="courseForm">     
        <div class="form-group">
                <div class="form--input student--select">
                <label>Select Student</label>
                <select name="student" value="<?php echo $add_student; ?>" class="student--select" required>
                <!-- gets students from user table -->   
                <?php
                // query statement to get student
                $query = "SELECT * from Users_tbl WHERE user_role = 'student'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        echo "<option class='instructor--names' value='{$row['user_id']}'> {$row['user_name']}</option>";
                    }
                }
                ?>
                </select>
                </div>
            
                
            
            </div> 
            <div class="btn__container">
            <button class="submit--btn" name="add__student">Add student</button>
            </div>
           
    </form>
   </div>


</div>

<!-- add group leader modal -->
<div id="myLeaderModal" class="modal" >
   
   <!-- Modal content -->
   <div class="modal-content">
   <span class="leaderclose">&times;</span>
   <form action="updategroup_groupmember.php" method="post"  class="courseForm">     
        <div class="form-group">
                <div class="form--input student--select">
                <label>Select Group Leader</label>
                <input type="hidden" name="groupid" value="<?=$group_id;?>">
                <select name="student" value="<?php echo $course_student; ?>" class="student--select" required>
                <!-- gets group members in particular group -->   
                <?php
                // query statement to get course information and instructor
                $query = "SELECT * from Users_tbl u,GroupMember_tbl g WHERE u.user_id = g.user_id AND g.group_id='$group_id'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        echo "<option class='instructor--names' value='{$row['user_id']}'> {$row['user_name']}</option>";
                    }
                }
                ?>
                </select>
                </div>
            
                
            
            </div> 
            <div class="btn__container">
            <button class="submit--btn" name="add__groupleader">Make group leader</button>
            </div>
           
    </form>
   </div>


</div>
 <!-- sidebar and content, last two div end -->
    </div>
</div>


<!-- modal script -->
<script>
   
// Get the modal
var modal = document.getElementById("myModal");
var leaderModal = document.getElementById("myLeaderModal");
// Get the button that opens the modal
var btn = document.getElementById("btn");
var btnLeader = document.getElementById("btnLeader");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var leaderSpan = document.getElementsByClassName("leaderclose")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
 
  modal.style.display = "block";
}
btnLeader.onclick = function() {
  leaderModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
 
}
leaderSpan.onclick = function() {

  leaderModal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  else if (event.target == leaderModal){
      leaderModal.style.display = "none"
  }
}
</script>
</body>
</html>