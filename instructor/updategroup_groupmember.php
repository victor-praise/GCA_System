<?php
session_start(); 
require_once "../connection.php";
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

        // deletes group
        if(isset($_POST['group_delete'])){
            $group_id = trim($_POST["group_delete"]);
            $query = "DELETE FROM Group_tbl WHERE group_id='$group_id'";
            $query_run = mysqli_query($con,$query);
            if($query_run){
                header("location: ../instructor/groups.php");
                exit(0);
            }
            else{
                // header("location: ../instructor/groups.php");
                echo 'unable to delete';
                exit(0);
            }

        }
?>