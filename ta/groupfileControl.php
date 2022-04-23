<?php
 require_once "../connection.php";
// Downloads files
if($_GET['action']=='get')
{
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM File_tbl WHERE file_id=$id";
    $result = mysqli_query($con, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../entityupload/' . $file['file_name'];
echo $filepath;
echo $id;
    if (file_exists($filepath)) {
        echo $filepath;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['file_name']));
        readfile('uploads/' . $file['file_name']);
        exit;
    }

}
}
if($_GET['action']=='del'){
    if (isset($_GET['file_id'])) {
        $id = $_GET['file_id'];
    
        // fetch file to download from database
        $sql = "SELECT * FROM File_tbl WHERE file_id=$id";
        $result = mysqli_query($con, $sql);
    
        $file = mysqli_fetch_assoc($result);
        $filepath = '../entityupload/' . $file['file_name'];
        if (file_exists($filepath)) {
            $sql = "DELETE FROM File_tbl WHERE file_id=$id";
            mysqli_query($con, $sql);
            unlink($filepath);
            $postId=$_GET['id'];
    $GMEId=$_GET['GMEId'];
    $GroupId=$_GET['Grp'];
            header("location: viewAllFiles.php?id=$postId&GMEId=$GMEId&Grp=$GroupId");
        }
    
    }
    }
    if($_GET['action']=='upd'){
        echo 'outside';
        if(!empty($_FILES["replyFile"]["name"])){
            echo 'inside';
            // Insert image file name into database
            $file = $_FILES['replyFile']['name'];
            $file_loc = $_FILES['replyFile']['tmp_name'];
            $file_type = $_FILES['replyFile']['type'];
            $folder="../entityupload/";
            $fileid=$_POST['hdnFileId'];
            echo $fileid;
             /* make file name in lower case */
            $new_file_name = strtolower($file);
            /* make file name in lower case */
            
            $final_file=str_replace(' ','-',$new_file_name);

            // checks if file already exists and replaces file
            if(file_exists("../entityupload/$final_file")){
                unlink("../entityupload/$final_file");
            }
            if(move_uploaded_file($file_loc,$folder.$final_file) ){
                $sql = "INSERT INTO File_tbl (file_id, user_id, GME_id, file_name, file_date, file_time, group_id, file_permission) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                
                if($stmt = mysqli_prepare($con, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssssss", $param_file_id,$param_user_id, $param_GME_id, $param_file_name, $param_file_date, $param_file_time,$param_file_groupid, $param_file_permission);
                    
                    // Set parameters
                    $param_file_id= mt_rand(1000000,9999999);
                    $param_user_id=$userId;
                    $param_GME_id=$_GET['GMEId'];
                    $param_file_name=$final_file;
                    $param_file_date=date("Y/m/d");;
                    $param_file_time=null;
                    $param_file_groupid=$_GET['Grp'];
                    $param_file_permission=trim($_POST["filePermission"]);;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        // header("location: discussionDetails.php?id=1");
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
                //   if($query_run){
                //     
                //     exit(0);
                    
                // }  
            }
}








    // if(!empty($_FILES["replyFile"]["name"])){
    //     // Insert image file name into database
    //     $file = $_FILES['replyFile']['name'];
    //     $file_loc = $_FILES['replyFile']['tmp_name'];
    //     $file_type = $_FILES['replyFile']['type'];
    //     $id=$_POST['hdnFileId'];
    //     $folder="../entityupload/";
    //     $deadline = 
    //      /* make file name in lower case */
    //     $new_file_name = strtolower($file);
    //     /* make file name in lower case */
        
    //     $final_file=str_replace(' ','-',$new_file_name);

    //     $userId=$_Session["id"];

    //     $sql = "SELECT * FROM File_tbl WHERE file_id=$id";
    //     $result = mysqli_query($con, $sql);
    
    //     $permission= $_POST["filePermission"];
    //     $file = mysqli_fetch_assoc($result);
    //     $filepath = '../entityupload/' . $file['file_name']. $file['group_id']. $file['user_id'];
    
    //     if (file_exists($filepath)) {
    //         unlink($filepath);
    //         exit;
    //     }

    //     // checks if file already exists and replaces file
    //     if(file_exists("../entityupload/$final_file")){
    //         unlink("../entityupload/$final_file");
    //     }
    //     if(move_uploaded_file($file_loc,$folder.$final_file) ){
    //         $query = "UPDATE File_tbl 
    //         SET 
    //         file_name = '$final_file',
    //         user_id = '$userId',
    //         file_permission='$permission'
    //         WHERE
    //         file_id = $id;";

    //         $query_run = mysqli_query($con,$query);
            
    //         //   if($query_run){
    //         //     
    //         //     exit(0);
                
    //         // }  
    //     }
    // }
}
?>