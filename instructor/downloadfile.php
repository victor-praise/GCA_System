<!-- 40206992, fung sim LEUNG, 40195538 -->
<?php
 require_once "../connection.php";
// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM GroupMarked_tbl WHERE GME_id=$id";
    $result = mysqli_query($con, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = '../entityupload/' . $file['file_name'];

    if (file_exists($filepath)) {
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
?>