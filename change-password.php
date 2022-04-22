<!-- 40206992 -->
<?php session_start(); 
        require_once "./connection.php";
        $user_id = $_SESSION['id'];
        $password_err="";
        $oldpassword_err="";
        $login_err  = "";
        $successfull = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
 
            // Check if username is empty
            if(empty(trim($_POST["newpassword"]))){
                 $password_err = "Please enter new password.";
            } else{
                $password = trim($_POST["newpassword"]);
            }
            
            // Check if password is empty
            if(empty(trim($_POST["oldpassword"]))){
                $oldpassword_err = "Please enter old password.";
            } else{
                $oldpassword = trim($_POST["oldpassword"]);
            }
            
            // Validate credentials
            if(empty($oldpassword_err) && empty($password_err)){
                // Prepare a select statement
                $sql = "SELECT user_id, user_name,user_email,user_password,user_role FROM Users_tbl WHERE user_id = ?";
                
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_id);
                    
                    // Set parameters
                    $param_id = $user_id;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Store result
                        mysqli_stmt_store_result($stmt);
                        
                        // Check if username exists, if yes then verify password
                        if(mysqli_stmt_num_rows($stmt) == 1){                    
                            // Bind result variables
                            mysqli_stmt_bind_result($stmt, $user_id, $user_name, $user_email,$hashed_password,$user_role);
                            if(mysqli_stmt_fetch($stmt)){
                                if(password_verify($oldpassword, $hashed_password)){
                                    // Password is correct, so start a new session
                                    $successfull = "password matches";
                                    $login_err = "";
                                    $changedPassword = password_hash($password, PASSWORD_DEFAULT);
                                    $query = "UPDATE Users_tbl
                                    SET 
                                    user_password = '$changedPassword'
                                    WHERE
                                    user_id = $user_id;";
                                    $query_run = mysqli_query($con,$query);
                                    if($query_run){
                                       $successfull = "Password changed";
                                        // exit(0);
                                    }
                                    else{
                                        $login_err = "Unable to change password";
                                        echo 'unable to change';
                                        // exit(0);
                                    }
                                                                             
                                } else{
                                    // Password is not valid, display a generic error message
                                    $login_err = "Password does not match.";
                                }
                            }
                        } else{
                            // Username doesn't exist, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    } 
                    
                    else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
          
            }
            
            // Close connection
            mysqli_close($con);
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="./style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>

    
</head>
<body>
<?php include('./includes/header.php'); ?>
    <?php include('./includes/sidebar.php'); ?>
<div class="admin--welcome">
         <h2>
         Change Password
         </h2>
         <div class="header--text">
         Here you can change your password.
    </div> 
    <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        } 
        elseif(!empty($successfull)){
            echo '<div class="success">' . $successfull . '</div>';
        }        
        ?>
    <div class="newPassword__container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="loginForm">
    <div class="form-group">
    <label>Old password</label>
                <input type="password" name="oldpassword" class="form-control <?php echo (!empty($oldpassword_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback"><?php echo $oldpassword_err; ?></span>
    </div>

    <div class="form-group">
                <label>New Password</label>
                <input type="password" name="newpassword" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
    <div class="form-group">
                <input type="submit" class="login--btn" value="Change password">
    </div>
</form>
        
    </div>
        <!-- last two divs are for the sidebar and content -->
        </div>
</div>
</body>
</html>