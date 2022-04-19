<?php
session_start(); 
require_once "../connection.php";
//   responsible for poll voting
        if(isset($_POST['poll_vote'])){
            $poll_id = trim($_POST["poll_vote"]);
            $polloption_id = trim($_POST["polloptionid"]);
            $user_id = $_SESSION["id"];
            $query = "UPDATE PollAnswers_tbl 
            SET
            votes = votes + 1
             WHERE id = '$polloption_id'";
            //  ensures a student doesent vote twice
            $query_hastvoted = "SELECT * from StudentVote_tbl WHERE poll_id = '$poll_id' AND user_id = '$user_id' ";
            $query_run = mysqli_query($con, $query_hastvoted);      
            if(mysqli_num_rows($query_run) > 0)        
            {
                $_SESSION["error"]='You are not allowed to vote twice';
                header("location: ../student/poll_info.php?id=".$poll_id);
                exit(0);
            }
            else{
                $query_run = mysqli_query($con,$query);
                if($query_run){
                    $query_vote = "INSERT INTO StudentVote_tbl (poll_id,user_id) VALUES ('$poll_id','$user_id')";
                    $query_run = mysqli_query($con,$query_vote);
                    if($query_run){
                        unset($_SESSION['error']);
                        $_SESSION["success"] = "updated";
                        header("location: ../student/poll_info.php?id=".$poll_id);
                        exit(0);
                    }
                    else{
                        unset($_SESSION['success']);
                        $_SESSION["error"]='add error';
                        header("location: ../student/poll_info.php?id=".$poll_id);
                        exit(0);
                    }
                    
                    exit(0);
                }
                else{
                    unset($_SESSION['success']);
                    $_SESSION["error"]='add error';
                    header("location: ../student/poll_info.php?id=".$poll_id);
                    exit(0);
                }
            }
         
        }

       
     

?>