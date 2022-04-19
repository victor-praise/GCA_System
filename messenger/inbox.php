<?php  
session_start();
require_once "../../connection.php";

$user_id = $_SESSION['id'];
$user_name = $_SESSION['username'];

if (!isset ($_GET['page']) ) {  
      $page = 1;  
  } else {  
      $page = $_GET['page'];  
  }  

$results_per_page = 3;  
$page_first_result = (($page-1) * $results_per_page);  


$all_msg_sent = mysqli_query($con, "SELECT P1.msg_id, P1.to_user, U1.user_name, P1.from_user, P1.msg_text, P1.msg_date, P1.msg_time  FROM PrivateMessage_tbl AS P1 JOIN Users_tbl AS U1 ON P1.from_user = U1.user_id WHERE P1.to_user = '$user_id' ORDER BY P1.msg_date, msg_time DESC ")or die(mysqli_error($con));
$number_of_result = mysqli_num_rows($all_msg_sent); 
$number_of_page = ceil ($number_of_result / $results_per_page);  

if(mysqli_num_rows($all_msg_sent) > 0)        
{

    
    $msg_shown = mysqli_query($con, "SELECT P1.msg_id, P1.to_user, U1.user_name, P1.from_user, P1.msg_text, P1.msg_date, P1.msg_time  FROM PrivateMessage_tbl AS P1 JOIN Users_tbl AS U1 ON P1.from_user = U1.user_id WHERE P1.to_user = '$user_id' ORDER BY P1.msg_date, msg_time DESC LIMIT ".$page_first_result.','.$results_per_page)or die(mysqli_error($con));

    
    while($row = mysqli_fetch_array($msg_shown))
    {

?>

<!DOCTYPE html>
  <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inbox</title>
        <link rel="stylesheet" href="../messenger/inbox.scss">
    </head>
    <body>
        <header>Inbox</header>
        <table border=1>
        <tr><td>
        <span>Time Sent: </span>
        <?php echo $row['msg_date']. " " .$row['msg_time'] ; ?>
        </td></tr>
        <tr><td>
        <span>To: </span>
        <?php echo $user_name. " (" .$row['to_user'].")"; ?>
        </td></tr>
        <tr><td>
        <span>From: </span>
        <?php echo $row['user_name']. " (" .$row['from_user']. ")" ; ?>
        </td></tr>
        <tr><td>
        <span>Message: </span></br>
        <?php echo $row['msg_text']?>
        </td></tr>

        </br>
<?php  
      } 
                    
}
else {
      echo "No Message";
}
?>  


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
      <table border="0">
            <tr><td colspan=2></td></tr>
            <tr><td></td><td>
            <input type="hidden" name="id" maxlength="5" value = "<?php echo $row["msg_id"]; ?>">
            </td></tr>

            </td></tr>

      </table>
</form>
</table>
</body>
</html>


<?php
  echo "</table>";
  echo "</br>";
  for($page = 1; $page<= $number_of_page; $page++) {  
    echo '<a href = "inbox.php?page=' . $page . '">' . $page . ' </a>'; 
  }
?>