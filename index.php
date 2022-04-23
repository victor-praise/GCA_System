<!-- 40206992 -->
<?php
// Initialize the session
//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["role"] == 'student'){
        header("location: ../student/course-select.php");
    }
    elseif($_SESSION["role"]  == 'admin'){
        header("location: ../admin/index.php");
    }
    elseif($_SESSION["role"]  == 'instructor'){
        header("location: ../instructor/instructor.php");
    }
    elseif($_SESSION["role"]  == 'ta'){
        header("location: ../ta/course_select.php");
    }
    exit;
}
 
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, user_name,user_fullname,user_email,user_password,user_role FROM Users_tbl WHERE user_name = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id,$user_name, $user_fullname, $user_email,$hashed_password,$user_role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $user_id;
                            $_SESSION["username"] = $user_fullname;                            
                            $_SESSION["useremail"] = $user_email; 
                            $_SESSION["role"] = $user_role;                           
                                //Redirect user to welcome page
                                if($_SESSION["role"] == 'student'){
                                    header("location: ../student/course-select.php");
                                }
                                elseif($_SESSION["role"] == 'admin'){
                                    header("location: ../admin/index.php");
                                }
                                elseif($_SESSION["role"] == 'instructor'){
                                    header("location: ../instructor/instructor.php");
                                }
                                elseif($_SESSION["role"] == 'ta'){
                                    header("location: ../ta/course_select.php");
                                }                                                   
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
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
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
  
    <link rel="stylesheet" href="style.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
</head>
<body>
    <div class="wrapper">
        <h2>CGA PORTAL</h2>
        <h3>Login</h3>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="loginForm">
        <!-- htmlspecialchars($_SERVER["PHP_SELF"]) -  super global variable that returns the filename of the currently executing script. It sends the submitted form data to the same page, instead of jumping on a different page.-->
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" required>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="login--btn" value="Login">
            </div>    
        </form>
    </div>
</body>
</html>