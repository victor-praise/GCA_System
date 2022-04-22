<!-- 40206992 -->
<?php session_start(); 
        require_once "../connection.php";
        if(isset($_GET['id'])){
            $_SESSION["courseid"] = $_GET['id'];
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>course</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="../instructor/instructor.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
 
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

    <div class="container">
                <div class="subforum">
                    <div class="subforum-title">
                        <h1>Group Discussions</h1>
                    </div>
                    <?php
                // query statement to get course information and instructor
                $userId=$_SESSION["id"];
                $courseId=$_SESSION["courseid"];
                $query = "SELECT p.post_id,p.post_text,p.user_id,(SELECT user_name from Users_tbl where user_id=p.user_id) as user_name,p.post_time,p.post_date from DiscussionPagesPost_tbl p inner join Group_tbl g on p.group_id=g.group_id
                where g.course_id='$courseId' order by p.post_date desc";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                ?>
                    <div class="subforum-row">
                        <div class="subforum-description  subforum-column">
                            <h4><a href="#">Description Title</a></h4>
                            <p><?=$row["post_text"]; ?></p>
                        </div>
                        <!-- <div class="subforum-stats  subforum-column center">
                            <span>24 Posts | 12 Topics</span>
                        </div> -->
                        <div class="subforum-info  subforum-column">
                            <b><a href="">Last post</a></b> by <?=$row["user_name"]; ?> 
                            <br>on <small><?=$row["post_date"]; ?></small>
                        </div>
                        <div class="subforum-info  subforum-column">
                        <a href="discussionDetails.php?id=<?=$row["post_id"]?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            </div>
                    </div>
                    <hr class="subforum-divider">
                    <?php  
                    } 
                    
                }
                else {
                    echo "No Discussions are there to read";
                }
            ?>
                </div>
                            
                <div class="subforum">
                    <div class="subforum-title">
                        <h1>General Discussions</h1>
                    </div>
                    <?php
                // query statement to get course information and instructor
                $userId=$_SESSION["id"];
                $courseId=$_SESSION["courseid"];
                $query = "SELECT p.post_id,p.post_text,p.user_id,(SELECT user_name from Users_tbl where user_id=p.user_id) as user_name,p.post_time,p.post_date from DiscussionPagesPost_tbl p inner join GroupMarked_tbl m on p.GME_id=m.GME_id
                where m.course_id='$courseId' and p.group_id is null order by p.post_date desc";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0)        
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                ?>
                    <div class="subforum-row">
                        <div class="subforum-description  subforum-column">
                            <h4><a href="#">Description Title</a></h4>
                            <p><?=$row["post_text"]; ?></p>
                        </div>
                        <!-- <div class="subforum-stats  subforum-column center">
                            <span>24 Posts | 12 Topics</span>
                        </div> -->
                        <div class="subforum-info  subforum-column">
                        <b><a href="">Last post</a></b> by <?=$row["user_name"]; ?> 
                            <br>on <small><?=$row["post_date"]; ?></small>
                        </div>
                        <div class="subforum-info  subforum-column">
                        <a href="discussionDetails.php?id=<?=$row["post_id"]?>">
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            </div>
                    </div>
                    <hr class="subforum-divider">
                    <?php  
                    } 
                    
                }
                else {
                    echo "No Discussions are there to read";
                }
            ?>
                </div>
            </div>
      <!-- last two divs are for the sidebar and content -->
      </div>
</div>
</body>
</html>