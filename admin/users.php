<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        
           
            $user_id = mt_rand(4040,8000);
            $user_error = "";
            $user_success = "";
            unset($_SESSION['updateusererror']);
        // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){


        // Checks if fields are empty
              if(empty(trim($_POST["username"]))){
                $user_error = "User name cannot be empty.";
            } 
            else{
                // Prepare a select statement
                $sql = "SELECT user_id FROM Users_tbl u WHERE u.user_name = ?";
                // ensures course does not exists before creating
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                   
                    mysqli_stmt_bind_param($stmt, "s",$param_username);
                    
                    // Set parameters
                    $param_username = trim($_POST["username"]);
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        /* store result */
                        mysqli_stmt_store_result($stmt);
                        
                        if(mysqli_stmt_num_rows($stmt) == 1){
                            $user_error = "This Username is already in the system.";
     
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
       
              
            }
            if(empty($user_error)){
                $password = trim($_POST["password"]);
                $sql_user = "INSERT INTO Users_tbl (user_id,user_name,user_fullname,user_email,user_password,user_role) VALUES (?,?,?,?,?,?)";
          
                //insert into student table
                if($stmt = mysqli_prepare($con, $sql_user)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "sssss",$param_userid,$param_username,$param_userfullname,$param_useremail,$param_password,$param_role);
                    
                    // Set parameters
                    $param_userid = $user_id; 
                    $param_username = trim($_POST["username"]);
                    $param_useremail = trim($_POST["email"]);
                    $param_userfullname = trim($_POST["fullname"]);
                    $param_password = password_hash($password, PASSWORD_DEFAULT);;
                    $param_role = trim($_POST["userrole"]);
                 
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                      $user_success = "User created";
                      $user_error = "";
                    } else{
                        $user_error =  "Oops! Something went wrong. Please try again later.";
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
    <title>Users</title>
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
         <button class="create--btn add--student" id="btn"><i class="fa-solid fa-plus"></i> Add User</button>
         <button class="create--btn add--student" id="filterbtn"><i class="fa-solid fa-filter"></i> Filter Users</button>
     </div>

    <div class="admin--welcome">
         <h2>
         Users
         </h2>
         <div class="header--text">
         As an Admin, you can add, delete and edit users on the system
    </div>   

     </div>
     <!-- error handling -->
     <?php 
        if(!empty($group_error) || !empty($group_success) ){
            unset($_SESSION['success']);
            unset($_SESSION['error']);
        }
        if(!empty($user_error)){ 
            echo '<div class="alert alert-danger">' . $user_error . '</div>';
        }  
        elseif(!empty($user_success)){
            echo '<div class="success">' . $user_success . '</div>';
        }  
        elseif(isset($_SESSION["error"])){
            echo '<div class="alert alert-danger"> Unable to delete </div>';
        }  
        elseif(isset($_SESSION["success"])){
         echo '<div class="success"> User deleted</div>';
        }            
        ?>
         <div class="information--student"> 
     <?php

                // gets users based on param
                if(isset($_SESSION["filter"])){
                    $param = $_SESSION["filter"];
                    if($param == 'all'){
                        unset($_SESSION['filter']);
                        $query = "SELECT * from Users_tbl where user_role != 'admin' ORDER BY user_role;
                        ";
                    }
                    else{
                        $query = "SELECT * from Users_tbl where user_role = '$param' ORDER BY user_name;
                        ";
                    }       
                }
                else{
                    $query = "SELECT * from Users_tbl where user_role != 'admin' ORDER BY user_role;
                    ";
                }
                
               
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {        

                ?>
                            <!-- displays data -->
                        <div class="student" >
                        <div class="name">
                        <label class="entity-info">User name</label>
                             <?=$row["user_name"]; ?> 
                            </div>
                
                         <div class="email">
                         <label class="entity-info">User email</label>
                         <?=$row["user_email"]; ?>
                        </div> 
                         <div class="email role--select">
                         <label class="entity-info">User role</label>
                         <?=$row["user_role"]; ?>
                        </div> 
                        <div class="delete">
                        <a href="edit_user.php?id=<?=$row['user_id']?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                          <form action="edit.php" method="post"> 
                          <button class="delete--group-btn" value="<?=$row["user_id"];?>" name="user_delete">
                          
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                          </form>  
                       
                      
                      </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There are no users on this system, please click button above to create users";
                }
            ?>
        </div>
        
    <div id="myModal" class="modal" >
           <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"   class="courseForm"> 
   <div class="form-group">
            <label>Enter Full name</label>
            <input type="text" name="fullname" 
            onkeypress="return /[a-z ]/i.test(event.key)"
            class="form-control" placeholder="Jennifer Lopez" required >    
        </div>     
        <div class="form-group">
            <label>Enter User name</label>
            <input type="text" name="username" 
            onkeypress="return /[a-z ]/i.test(event.key)"
            class="form-control" placeholder="V_NWATU" required >    
        </div> 
      
        <div class="form-group email--input">
            <label>Enter Email</label>
            <input type="email" name="email" class="form-control" required placeholder="example@gmail.com" class="email--input">
        </div>
        <div class="form-group">
        <label>Select Role</label>
            <select name="userrole" class="student--select role--select" required>
                        <option>instructor</option>
                        <option>ta</option>
                        <option>student</option>
            </select> 
        </div>
        <div class="form-group">
            <label>Enter Default Password</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password" required>
        </div>
            <div class="btn__container">
            <button class="submit--btn">Create user</button>
            </div>
           
    </form>
   </div>
            </div>
            <!-- filter modal -->
    <div id="filterModal" class="modal" >
           <!-- Modal content -->
   <div class="modal-content">
   <span class="leaderclose">&times;</span>
   <form action="edit.php" method="post"   class="courseForm">     
        <div class="form-group">
            <label>Filter option</label>
            <select name="filteroption" class="student--select role--select" required>
                        <option>all</option>
                        <option>instructor</option>
                        <option>ta</option>
                        <option>student</option>
            </select>   
        </div> 
            <div class="btn__container">
            <button class="submit--btn" name="filterusers">Filter</button>
            </div>
           
    </form>
   </div>
            </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>

<!-- modal script -->
<script>
   
// Get the modal
var modal = document.getElementById("myModal");
var filterModal = document.getElementById("filterModal");

// Get the button that opens the modal
var btn = document.getElementById("btn");
var filterBtn = document.getElementById("filterbtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var filterspan = document.getElementsByClassName("leaderclose")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
 
  modal.style.display = "block";
}
filterbtn.onclick = function() {
 
  filterModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
filterspan.onclick = function() {
  filterModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  else if (event.target == filterModal) {
    filterModal.style.display = "none";
  }
}
</script>
</body>
</html>