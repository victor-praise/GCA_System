<?php    
session_start();
require_once "../../connection.php";


$user_id = $_SESSION['id'];




// $message = $_POST["forward2"];
 if (isset($_POST['submit']))
{
// if the form has been submitted, this inserts it into the Database 
  $to_user = $_POST['to_user'];
  $msg_text = $_POST['msg_text'];
  $group_id = $_POST['to_user'];
  $sql = mysqli_query($con, "SELECT * FROM PrivateMessage_tbl");
  if(mysqli_num_rows($sql) > 0)        
    {
      $new_msg_id = mysqli_query($con, "SELECT (MAX(msg_id)+1) AS NEWMSGID FROM PrivateMessage_tbl")
      or die(mysqli_error($con));
      $result = mysqli_fetch_assoc($new_msg_id);
      $msg_id = $result['NEWMSGID'];
    }
  else {
      $msg_id = "1";
    }

  date_default_timezone_set('America/Toronto');
  $msg_date = date('Y-m-d', time());
  $msg_time = date('H:i:s', time());
  mysqli_query($con, "INSERT INTO PrivateMessage_tbl (msg_id, to_user, msg_text, from_user, msg_date, msg_time) VALUES ('$msg_id', '$to_user', '$msg_text', '$user_id', '$msg_date', '$msg_time')")or die(mysqli_error($con));
  echo "Your messenage is succesfully sent!"; 
}

    // if the form has not been submitted, this will show the form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <link rel="stylesheet" href="../messenger/styles_send.scss">
</head>
<body>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <table border="0">
        <tr><td colspan=2><h3><header>Send PM: </header></h3></td></tr>
        <tr><td></td></tr>

        <tr><td>From User: </td><td><input type="text" name="from_user" maxlength="32" value = "<?php echo $_SESSION['username'] ?>" readonly>
        </td></tr>

        <hr class="divider">

        <tr><td>To User: </td><td>
        <?php

            $query = "SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id'";
            
            
            //$course_id_query = mysqli_query($con, "SELECT C1.course_id FROM Student_tbl AS C1 WHERE C1.user_id = '$user_id'")
            //or die(mysqli_error($con));
            // $gp_result = mysqli_fetch_assoc($group_id_query);
            // $group_id = $gp_result['group_id'];
            
            // echo "<select name = 'course_id'>";
            // while ($crs_result = mysqli_fetch_array($course_id_query)) {
            //   echo "<option value='" . $crs_result['course_id'] ."'>" . $crs_result['course_id'] ."</option>";
            // }
            // echo "</select>";

            
            
            $group_id_query = mysqli_query($con, "SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id'")
            or die(mysqli_error($con));
            // $gp_result = mysqli_fetch_assoc($group_id_query);
            // $group_id = $gp_result['group_id'];
            
            //echo "<select name = 'group_id' id = 'selected_group'>";
            //while ($gp_result = mysqli_fetch_array($group_id_query)) {
            //echo "<option value='" . $gp_result['group_id'] ."'>" . $gp_result['group_id'] ."</option>";
            //echo "var category = $('option').val()";
            //}
            //echo "</select>";
            
            $member_id = mysqli_query($con, "SELECT G2.user_id FROM GroupMember_tbl AS G2 WHERE (G2.user_id <> '$user_id' AND G2.group_id IN (SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id')) ")
            or die(mysqli_error($con));
            
            $member_name = mysqli_query($con, "SELECT Users_tbl.user_name FROM Users_tbl WHERE Users_tbl.user_id IN (SELECT G2.user_id FROM GroupMember_tbl AS G2 WHERE (G2.user_id <> '$user_id' AND G2.group_id IN (SELECT G1.group_id FROM GroupMember_tbl AS G1 WHERE G1.user_id = '$user_id'))) ")
            or die(mysqli_error($con));

            echo "<select name = 'to_user'>";
            while ($row = mysqli_fetch_array($member_name) and $row2=mysqli_fetch_array($member_id)) {
            echo "<option value='" . $row2['user_id'] ."'>" . $row['user_name'] . " (" . $row2['user_id'] . ")</option>";
            }
            echo "</select>";
        ?> 

        <?php // <input type="text" name="to_user" maxlength="32" value = ""> ?>

        <hr class="divider">

        <tr><td>Message: </td><td>
        <TEXTAREA NAME="msg_text" COLS=50 ROWS=10 WRAP=SOFT></TEXTAREA>
        </td></tr>
        <tr><td colspan="2" align="right">
        <input type="submit" name="submit" value="Send Message">
        </td></tr>
        </table>
        </form>
</body>
</html>















