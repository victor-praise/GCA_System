<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
             $gme_error = "";
             $gme_success = "";
    
    if($_GET['id']){
        $group_id = $_GET['id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entity Discussions</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">   
  <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <a href="previousgroups.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
    <div class="admin--welcome">
         <h2>
         Group Discussions
         </h2>
         <div class="header--text">
         Select entity you would like to view discussion
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
                // query statement to get discussions based on groupid
                $query = " SELECT u.*,r.* from DiscussionPagesPost_tbl u, GroupMarked_tbl r where u.group_id = '$group_id' AND u.GME_id = r.GME_id;
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
                        <div class="email submissions">
                         <a href="previousdiscussiondetail.php?id=<?=$row["post_id"]; ?>&group_id=<?=$group_id ?>">View Discussions</a>
                        </div> 
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There are no discussion for this group";
                }
            ?>
        </div>

            </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>


</body>
</html>