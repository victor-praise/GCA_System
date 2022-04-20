<?php session_start(); 
        require_once "../connection.php";
        
             $course_id =  $_SESSION["courseid"];
             $gme_id = mt_rand(1000000,9999999);
             $gme_error = "";
             $gme_success = "";
             $gme_file = "";
            $gme_name = "";
            // unset($_SESSION['success']);
        
        
        // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){


        // Checks if fields are empty
              if(empty(trim($_POST["gmename"]))){
                $gme_error = "Entity name cannot be empty.";
            } 
              elseif(empty(trim($_POST["gmedeadline"]))){
                $gme_error = "Pick a deadline.";
            } 
            else{
                $file = $_FILES['gmefile']['name'];
                $file_loc = $_FILES['gmefile']['tmp_name'];
                $file_type = $_FILES['gmefile']['type'];
                $folder="../entityupload/";
                $deadline = date("Y-m-d", strtotime($_POST["gmedeadline"]));
                 /* make file name in lower case */
                $new_file_name = strtolower($file);
                /* make file name in lower case */
                
                $final_file=str_replace(' ','-',$new_file_name);

                // Prepare a select statement
                $sql = "SELECT GME_id FROM GroupMarked_tbl g WHERE g.course_id = ? AND g.entity_name = ?";
                // ensures course does not exists before creating
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                   
                    mysqli_stmt_bind_param($stmt, "ss", $param_courseid,$param_gmename);
                    
                    // Set parameters
                    $param_courseid = $course_id;
                    $param_gmename = trim($_POST["gmename"]);
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        /* store result */
                        mysqli_stmt_store_result($stmt);
                        
                        if(mysqli_stmt_num_rows($stmt) == 1){
                            $gme_error = "This Entity is already created.";
                          
                        } else{
                          $gme_name = trim($_POST["gmename"]);  
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
       
              
            }
            if(empty($gme_error) && move_uploaded_file($file_loc,$folder.$final_file) ){
              
                $sql_entity = "INSERT INTO GroupMarked_tbl (GME_id,course_id,file_name,entity_name,file_type,deadline,start_date) VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP)";
          
                //insert into marked entity table
                if($stmt = mysqli_prepare($con, $sql_entity)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssss",$param_gmeid,$param_courseid,$param_filename,$param_gmename,$param_gmetype,$param_deadline);
                    
                    // Set parameters
                    $param_gmeid = $gme_id; 
                    $param_courseid = $course_id;
                    $param_filename = $final_file;
                    $param_gmename = trim($_POST["gmename"]);
                    $param_gmetype = $file_type;
                    $param_deadline = $deadline;
                 
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                      $gme_success = "Marked entity created";
                      $gme_error = "";
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
    <title>Marked entities</title>
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
         <button class="create--btn" id="btn"><i class="fa-solid fa-plus"></i> Add marked entity</button>
     </div>
    <div class="admin--welcome">
         <h2>
         Marked entites
         </h2>
         <div class="header--text">
         Here you can add,delete, edit already existing entities as well as view submissions made by groups.
    </div>   

     </div>
     <?php 
     
        if(!empty($gme_error)){
            echo '<div class="alert alert-danger">' . $gme_error . '</div>';
        }  
        elseif(!empty($gme_success)){
            echo '<div class="success">' . $gme_success . '</div>';
        }  
            
        ?>
         <div class="information--student"> 
     <?php
                // query statement to get marked entities in a course
                $query = "SELECT * from GroupMarked_tbl g where g.course_id = '$course_id';
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="student" >
                           
                        <div class="name entity--name"> 
                        <label class="entity-info">Entity name</label>
                            <?=$row["entity_name"]; ?> 
                        </div>
                    
                         <div class="email entity--filename">
                         <label class="entity-info">File name</label>
                         <?=$row["file_name"]; ?>
                        </div> 
                         <div class="email deadline">
                         <label class="entity-info">Dealine</label>
                         <?=$row["deadline"]; ?>
                        </div> 
                         <div class="email submissions">
                         <a href="entity_submissions.php?id=<?=$row["GME_id"]; ?>">View submissions</a>
                        </div> 
                        <div class="delete">
                        <a href="edit_markedEntity.php?id=<?=$row["GME_id"]; ?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                          <form action="updategroup_groupmember.php" method="post"> 
                             
                          <button class="delete--group-btn" name="entity_delete" value="<?=$row["GME_id"];?>" >
                            <i class='fa-solid fa-trash-can'></i>
                            </button>
                          </form>  
                       
                      
                      </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There are no entites added, please click button above to add entites";
                }
            ?>
        </div>
        
        <div id="myModal" class="modal" >
           <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data" class="courseForm">     
        <div class="form-group">
            <label>Enter Entity name</label>
            <input type="text" name="gmename" class="form-control" value="<?php echo $gme_name; ?>" required>    
        </div> 
        <div class="form-group">
            <label>Enter Deadline</label>
            <input type="date" name="gmedeadline" class="form-control" value="<?php echo $gme_dealine; ?>" required>    
        </div> 
        <div class="form-group">
            <label>upload file</label>
            <input type="file" name="gmefile" class="form-control" value="<?php echo $gme_file; ?>" required>    
        </div> 
            <div class="btn__container">
            <button class="submit--btn">Add Entity</button>
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