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
        // deletes entity
        if(isset($_POST['entity_delete'])){
            $gme_id = trim($_POST["entity_delete"]);
            $query = "DELETE FROM GroupMarked_tbl WHERE GME_id='$gme_id'";
            $query_run = mysqli_query($con,$query);
            if($query_run){
                header("location: ../instructor/markedentity.php");
                exit(0);
            }
            else{
                // header("location: ../instructor/groups.php");
                echo 'unable to delete';
                exit(0);
            }

        }

        if(isset($_POST['update_entity'])){
            $gme_id = trim($_POST["entity_id"]);
            $course_id = $_SESSION["courseid"];
            $entity_name = trim($_POST["entityname"]);
            $entity_deadline = date("Y-m-d", strtotime($_POST["entitydeadline"]));
        
            // if no new file has been updated ignore file field
         if(empty($_FILES["newfile"]["name"])){
            $query = "UPDATE GroupMarked_tbl 
            SET 
            entity_name = '$entity_name',
            deadline = '$entity_deadline'
            WHERE
             GME_id = $gme_id AND course_id = $course_id
            ;";
             $query_run = mysqli_query($con,$query);
              if($query_run){
                header("location: ../instructor/edit_markedEntity.php?id=".$gme_id);
                exit(0);
            }
          

         }
        //  if a new file has been uploaded replace file field
         else{
            //  gets file
            $file = $_FILES['newfile']['name'];
            $file_loc = $_FILES['newfile']['tmp_name'];
            $file_type = $_FILES['newfile']['type'];
            $folder="../entityupload/";
            $deadline = 
             /* make file name in lower case */
            $new_file_name = strtolower($file);
            /* make file name in lower case */
            
            $final_file=str_replace(' ','-',$new_file_name);

            // checks if file already exists and replaces file
            if(file_exists("../entityupload/$final_file")){
                unlink("../entityupload/$final_file");
            }
            if(move_uploaded_file($file_loc,$folder.$final_file) ){
                $query = "UPDATE GroupMarked_tbl 
                SET 
                entity_name = '$entity_name',
                deadline = '$entity_deadline',
                file_name = '$final_file',
                file_type = '$file_type'
                WHERE
                GME_id = $gme_id
                AND course_id = $course_id
                ;";
                 $query_run = mysqli_query($con,$query);
                  if($query_run){
                    header("location: ../instructor/edit_markedEntity.php?id=".$gme_id);
                    exit(0);
                    
                }  
            }
             
             echo 'fuck';
         }

        }
    
     

?>