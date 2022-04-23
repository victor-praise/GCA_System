<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        
             $user_id =  $_SESSION["id"];
             $course_id =  $_SESSION["courseid"];
             $gme_error = "";
             $gme_success = "";
             $groupName = "";
          
            $queryuser = "SELECT 
            *
            FROM
            Group_tbl
            WHERE
            group_id IN (SELECT 
            group_id
                FROM
                GroupMember_tbl
                WHERE
                    user_id = '$user_id');";
            $query_runuser = mysqli_query($con,$queryuser);
           
             if(mysqli_num_rows($query_runuser) > 0)        
             {
                 while($row = mysqli_fetch_assoc($query_runuser))
                 {
                     $groupName = $row['group_name'];
                  }
            }
            else{
                $gme_error = "You are currently not in any group"; 
            }
          
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Groups</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">   
  <link rel="stylesheet" href="../admin/admin.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <div class="admin--welcome">
         <h2>
         Previous groups
         </h2>
         <div class="header--text">
         You are currently in group <?= $groupName?>, but you can still access the discussions of your previous groups up till when you left.
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
                // query statement to get all groups a student has been in
                $query = "SELECT 
                *
                FROM
                RemovedGroupMember_tbl
                    WHERE
                        user_id = '$user_id' AND course_id='$course_id';
                ";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0){

                    while($row = mysqli_fetch_assoc($query_run)){
                        $particularGroup = $row['group_id'];
                        $queryGroup = "SELECT 
                        *
                        FROM
                        Group_tbl
                        WHERE group_id = '$particularGroup'";
                        $queryGroupRun = mysqli_query($con, $queryGroup);
                        if(mysqli_num_rows($queryGroupRun) > 0)        
                        {
                            while($group = mysqli_fetch_assoc($queryGroupRun))
                            {  
                                if($group["group_name"] != $groupName){
                                    $_SESSION['dateleft'] = $row["dateLeft"];
                                    ?>
                                    <div class="student" >
                                       
                                    <div class="name entity--name"> 
                                    <label class="entity-info">Group name</label>
                                        <?=$group["group_name"]; ?> 
                                    </div>
                                
                                     <div class="email entity--filename">
                                     <label class="entity-info">Date left</label>
                                     <?=$row["dateLeft"]; ?>
                                    </div> 
                                    
                                    <div class="delete">
                                    <a href="previousgroupdiscussion.php?id=<?=$row["group_id"]; ?>">
                                    <i class="fa-solid fa-eye"></i>
                                        </a>                      
                                  </div>
                                  </div>
                                <?php 
                                }
                      
                            } 
                            
                        }
                        else {
                            echo "You have not been removed from any group";
                        }

                    }
                }
                else{
                    echo "You have not been removed from any group"; 
                }                
            ?>
        </div>
        

      <!-- last two divs are for the sidebar and content -->
      </div>
</div>


</body>
</html>