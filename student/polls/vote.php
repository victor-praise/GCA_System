<?php
session_start(); 
require_once "../../connection.php";
        // adds group leader
        if(isset($_POST['add__groupleader'])){
            $student_id = trim($_POST["student"]);
            $group_id = trim($_POST["groupid"]);
            $query = "UPDATE Group_tbl 
            SET 
            leader_user_id = '$student_id'
            WHERE
            group_id = $group_id;";
            $query_run = mysqli_query($con,$query);
            if($query_run){
                unset($_SESSION['error']);
                $_SESSION["success"] = "updated";
                header("location: ../instructor/add_groupmember.php?id=".$group_id);
                exit(0);
            }
            else{
                unset($_SESSION['success']);
                $_SESSION["error"]='add error';
                header("location: ../instructor/add_groupmember.php?id=".$group_id);
                exit(0);
            }
        }
        if(isset($_POST['poll_vote'])){
            $poll_id = trim($_POST["poll_vote"]);
            $polloption_id = trim($_POST["polloptionid"]);
            $user_id = $_SESSION["id"];
           
            $query = "UPDATE Group_tbl 
            SET 
            leader_user_id = '$student_id'
            WHERE
            group_id = $group_id;";
            $query_run = mysqli_query($con,$query);
            if($query_run){
                unset($_SESSION['error']);
                $_SESSION["success"] = "updated";
                header("location: ../instructor/add_groupmember.php?id=".$group_id);
                exit(0);
            }
            else{
                unset($_SESSION['success']);
                $_SESSION["error"]='add error';
                header("location: ../instructor/add_groupmember.php?id=".$group_id);
                exit(0);
            }
        }

       
     

?>