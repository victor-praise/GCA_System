<?php session_start(); 
require_once "../connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">\
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <title>Document</title>
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>

            <?php
                $query = "SELECT c.*, p.*, u.* FROM course c, instructor p, users u WHERE c.id = p.courseid and p.userid = u.id";
                $query_run = mysqli_query($con, $query);
                $test = "";
            ?>

<?php

                        if(mysqli_num_rows($query_run) > 0)        
                        {
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                // $test = $row['id'];
                                echo $row['courseid'];
                                echo $row['coursename'];
                                echo $row['username'];
                            } 
                        }
                        else {
                            echo "No Record Found";
                        }
                        ?>
     <!-- last two divs are for the sidebar and content -->
     </div>
</div>
</body>
</html>