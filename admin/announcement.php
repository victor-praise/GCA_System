<?php session_start(); 
        require_once "../connection.php";
    
             $announcement_error = "";
             $announcement_success = "";

                // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Checks if fields are empty
              if(empty(trim($_POST["announcement"]))){
                $announcement_error = "Enter announcement.";
            } 
            if(empty($announcement_error)){
                //insert into announcement table
                $sql_announcement = "INSERT INTO Announcement_tbl (announcement) VALUES (?)";
                
                if($stmt = mysqli_prepare($con, $sql_announcement)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s",$param_announcement);
                    
                    // Set parameters 
                    $param_announcement = trim($_POST["announcement"]);
                   
                 
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                      $announcement_success = "Announcement created";
                      $announcement_error = "";
                    } else{
                        $announcement_success="";
                        $announcement_error = "Oops! Something went wrong. Please try again later";
                        
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
                
            }
        }
        
            // unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
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
         <button class="create--btn" id="btn"><i class="fa-solid fa-plus"></i> Make Announcement</button>
     </div>
    <div class="admin--welcome">
         <h2>
        Announcement
         </h2>
         <div class="header--text">
         Here you can make announcements available to every user on the system
        </div>   

     </div>
     <?php 
     
        if(!empty($announcement_error)){
            echo '<div class="alert alert-danger">' . $announcement_error . '</div>';
        }  
        elseif(!empty($announcement_success)){
            echo '<div class="success">' . $announcement_success . '</div>';
        }  
            
        ?>
         <div class="information--student"> 
     <?php
                // query statement to get marked entities in a course
                $query = "SELECT * from Announcement_tbl ORDER BY id DESC;
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="student announcement-container" >       
                        <div class="name announcement"> 
                        <label class="entity-info">Announcement</label>
                            <?=$row["announcement"]; ?> 
                        </div>
                     
                        <div class="delete">
                          <form action="edit.php" method="post"> 
                             
                          <button class="delete--group-btn" name="announcement_delete" value="<?=$row["id"];?>" >
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                          </form>  
                       
                      
                      </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There are no announcements, please click button above to make an announcement";
                }
            ?>
        </div>
        
        <div id="myModal" class="modal" >
           <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="courseForm">     
        <div class="form-group">
            <label>Enter Announcement</label>
            <textarea name="announcement" id="answers" placeholder="Text here will be avilable for all users" rows="5" required></textarea>   
        </div> 

            <div class="btn__container">
            <button class="submit--btn">Make Announcement</button>
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

// Get the button that opens the modal
var btn = document.getElementById("btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
 
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>