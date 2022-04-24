<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        
             $course_id =  $_SESSION["courseid"];
             $user_id = $_SESSION["id"];
             unset($_SESSION['success']);
             unset($_SESSION['error']);
             $inagroup = false;
             $gme_error = "";
             $gme_success = "";   
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
    <link rel="stylesheet" href="../student/student.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

    <div class="admin--welcome">
         <h2>
         Marked entites
         </h2>
         <div class="header--text">
         Here you can view, and download entites assigned by instructors.
    </div>   

     </div>
     <?php 
     
        if(!empty($gme_error)){
            echo '<div class="alert alert-danger">' . $gme_error . '</div>';
        }  
        elseif(!empty($gme_success)){
            echo '<div class="success">' . $gme_success . '</div>';
        }  
          $query_groupinfo = "SELECT c.*,r.* FROM Group_tbl c JOIN GroupMember_tbl r ON c.group_id = r.group_id AND r.user_id = '$user_id';
          " ;
           $query_run = mysqli_query($con, $query_groupinfo);
           if(mysqli_num_rows($query_run) > 0)        
           {
               while($row = mysqli_fetch_assoc($query_run))
               {    
                   $group_id = $row["group_id"];
                   $_SESSION['group_id'] = $row["group_id"];
                   $inagroup = true;          
           ?>
                    <h2 class="student__header">Group <?=$row["group_name"]; ?></h2> 
               <?php  
               } 
               
           }
           else {
               echo "You have not been added to any group, please contact your instructor";
           }

        ?>
         <div class="information--student"> 
     <?php
            if($inagroup){
                         // query statement to get marked entities in a course
                $query = "SELECT * from GroupMarked_tbl g where g.course_id = '$course_id'
                ORDER BY deadline ASC;";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {  
                        
                ?>
                        <div class="student" >
                           
                        <div class="name"> 
                        <label class="entity-info">Entity name</label>
                            <?=$row["entity_name"]; ?> 
                        </div>
                    
                         <div class="email">
                         <label class="entity-info">File name</label>
                         <?=$row["file_name"]; ?>
                        </div> 
                         <div class="email deadline">
                         <label class="entity-info">Dealine</label>
                         <?=$row["deadline"]; ?>
                        </div> 
                        <?php 
                            // checks if entity has been submitted
                            $gme_id = $row["GME_id"];
                            $query_submitted = "SELECT * from FinalSubmission_tbl where GME_id = '$gme_id' AND group_id = '$group_id'";

                            $query_runSubmission = mysqli_query($con, $query_submitted);
                            if(mysqli_num_rows($query_runSubmission) > 0) {
                                while($submittedrow = mysqli_fetch_assoc($query_runSubmission))
                                {
                                    if($submittedrow['GME_id'] == $row['GME_id']){
                                        echo '

                                        <div class="email submitted">
                                        <label class="entity-info">Submission</label>
                                        submitted
                                        </div>            
                                        ';
                                    } 
                                    else {
                                        // used to make styling consistent
                                        echo "<div class=''>not submitted</div>";
                                    }
                                }
                            }
                            else{
                                echo '

                                <div class="email not-submitted">
                                <label class="entity-info">Submission</label>
                                not submitted
                                </div>            
                                ';
                            }
                        ?>
                       
                        <div class="delete">
                        <!-- submit button only available for group leader -->
                        <?php 
                            $query_groupLeader = "SELECT * FROM Group_tbl g, GroupMember_tbl gm where g.leader_user_id = gm.user_id AND g.group_id = gm.group_id AND g.course_id = '$course_id'";
                            $query_runLeader = mysqli_query($con, $query_groupLeader);
                            if(mysqli_num_rows($query_runLeader) > 0) {
                                while($leaderrow = mysqli_fetch_assoc($query_runLeader))
                                {
                                    if($leaderrow['user_id'] == $user_id){
                                        echo '<a href="upload-submission.php?gme_id='.$row['GME_id'].'"> <i class="fa-solid fa-pencil"></i></a>';
                                    } 
                                    else {
                                        // used to make styling consistent
                                        echo "";
                                    }
                                }
                            }
                        ?>
                        <a href="../downloadfile.php?file_id=<?=$row['GME_id'];?>"><i class="fa-solid fa-download"></i></a> 
                                             
                      </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There are no entites added, please check back later";
                }
            }
           
            ?>
        </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>


</body>
</html>