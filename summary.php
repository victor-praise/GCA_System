<!-- 40206992 -->
<?php session_start(); 
        require_once "./connection.php";
        
          
             $gme_error = "";
             $gme_success = "";
            
            if(isset($_GET['id'])){
                $gme_id = $_GET["id"];
                $group_id = $_GET["groupid"];  
                $submission_id = $_GET["submit"];     
            }
            else{
                $gme_error = "Unable to fetch summary, contact admin";
            }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link rel="stylesheet" href="./style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">   
  <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('./includes/header.php'); ?>
    <?php include('./includes/sidebar.php'); ?>

    <div class="create--course">
    <a href="../student/download-solution.php?file_id=<?=$submission_id?>">
    <button class="create--btn" id="btn"><i class="fa-solid fa-plus"></i> Download file</button>
    </a>
        
     </div>
     
        <a href="./entity_submissions.php?id=<?=$gme_id; ?>" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
       
    <div class="admin--welcome">
         <h2>
         Summary
         </h2>
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
                $query = "SELECT f.*,u.* from FileAuditHistory_tbl f, Users_tbl u where f.GME_id = '$gme_id' AND f.group_id = '$group_id' AND f.user_id = u.user_id;
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="student" >
                           
                        <div class="name entity--name"> 
                        <label class="entity-info">Student</label>
                            <?=$row["user_name"]; ?> 
                        </div>
                    
                         <div class="email entity--name">
                             <?php 
                                if($row['file_action'] == 'insert' && $row['update_file_name'] == null){
                                    $action = 'Insert';
                                } 
                                elseif($row['file_action'] == 'insert' && $row['update_file_name']!=null){
                                    $action = 'Update';
                                }
                                else{
                                    $action = 'Delete';
                                }
                            ?>
                         <label class="entity-info">Action</label>
                         <?=$action ?>
                        </div> 
                         <div class="email entity--filename">
                             <?php 
                                if($action != 'Update'){
                                    echo '<label class="entity-info">File name</label>';
                                }
                                else{
                                    echo '<label class="entity-info">Replaced</label>';
                                }
                             ?>
                         
                         <?=$row["file_name"]; ?>
                        </div> 
                        <?php 
                        if($action == 'Update'){
                            echo '<div class="email entity--filename ">
                            <label class="entity-info">With</label>
                            
                            '.$row['update_file_name'].'
                            </div> ';
                        }
                        
                        ?>
                             
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "Submission has no summary";
                }
            ?>
        </div>
            </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>

</body>
</html>