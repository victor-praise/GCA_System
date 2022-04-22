<!-- 40206992 -->
<?php session_start(); 
        require_once "./connection.php";
        
             if(isset($_GET["id"])){
                 $gmeid = $_GET["id"];
                $course_id =  $_SESSION["courseid"];
             }
           
        
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions</title>
    <link rel="stylesheet" href="./style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <link rel="stylesheet" href="../admin/admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('./includes/header.php'); ?>
    <?php include('./includes/sidebar.php'); ?>
    <?php 
          if($_SESSION["role"] == 'ta'){
            echo '<a href="../ta/ta_markedEntity.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>';
        }
        elseif($_SESSION["role"] == 'instructor'){
          echo '<a href="../instructor/markedentity.php" class="back--link"><i class="fa-solid fa-arrow-left-long"></i> Back</a>';
        }
       
       ?>
         <div class="information--student"> 
     <?php
                // query statement to get course information based on instructor
                $query = "SELECT c.*,r.* FROM FinalSubmission_tbl c JOIN Group_tbl r ON c.group_id = r.group_id AND c.GME_id = '$gmeid';
                ;
                ";
                $query_run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                           
                        
                ?>
                        <div class="student" >
                        <div class="name"> 
                        <label class="entity-info">Group name</label>
                            <?=$row["group_name"]; ?> 
                        </div>
                        <div class="name"> 
                        <label class="entity-info">File name</label>
                            <?=$row["file_name"]; ?> 
                        </div>
                        <div class="name"> 
                        <label class="entity-info">Submitted on</label>
                            <?=$row["submission_date"]; ?> 
                        </div>
                        <div class="download ta__students ">
                           
                                <!-- <input type="hidden" name="groupid" value="<?=$row["group_id"]; ?>">
                                <button name="viewsummary" value="<?=$row["GME_id"]; ?>" class="view--btn">y</button> -->
                                <a href="./summary.php?id=<?=$row["GME_id"]; ?>&groupid=<?=$row["group_id"]; ?>">View summary</a>
                               
                        <!-- <a href="downloadfile.php?file_id=<?=$entity['GME_id'];?>"><i class="fa-solid fa-download"></i> Download file</a
                        > -->
                     </div>
                      </div>
                    <?php  
                    } 
                    
                }
                else {
                    echo "There have been no submissions for this Entity";
                }
            ?>
        </div>
        
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>

</body>
</html>