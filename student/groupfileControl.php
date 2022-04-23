<!-- 40195161 -->
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
            $updatedUserId=$_GET['uId'];
            $fileid=$_GET['file_id'];
            $permission=$_POST['filePermission'];
            echo $updatedUserId;
             /* make file name in lower case */
            $new_file_name = strtolower($file);
            /* make file name in lower case */
            
            $updatedDate= date("Y/m/d");
            $final_file=str_replace(' ','-',$new_file_name);
            echo $final_file;
            // checks if file already exists and replaces file
            if(file_exists("../entityupload/$final_file")){
                unlink("../entityupload/$final_file");
            }
            if(move_uploaded_file($file_loc,$folder.$final_file) ){
                $sql = "UPDATE File_tbl
                SET
                file_name= '$final_file',
                user_id='$updatedUserId',
                file_permission='$permission',
                file_date='$updatedDate'
                
                WHERE
                file_id = '$fileid';";
                $query_run = mysqli_query($con,$sql);
                if($query_run){
                    $postId=$_GET['id'];
    $GMEId=$_GET['GMEId'];
    $GroupId=$_GET['Grp'];
            header("location: viewAllFiles.php?id=$postId&GMEId=$GMEId&Grp=$GroupId");
                }
            }
}

}
?>