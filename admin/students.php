<?php session_start(); 
        require_once "../connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="../style.scss">
    <link rel="stylesheet" href="../includes/styles.scss">
    <link rel="stylesheet" href="admin.scss">
    <script src="https://kit.fontawesome.com/57c0ab8bd6.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('../includes/header.php'); ?>
    <?php include('../includes/sidebar.php'); ?>
    <div class="create--course">
         <button class="create--btn add--student" id="btn"><i class="fa-solid fa-plus"></i> Add Student</button>
     </div>
    <h2 class="student__header">Students</h2>
    <div class="information--student">
        <div class="student">
        <div class="name">Victor Praise</div>
        <div class="email">vpraise27@gmail.com</div>
        <div class="delete"><i class='fa-solid fa-trash-can'></i></div>
        </div>
        <div class="student">
        <div class="name">Victor Praise</div>
        <div class="email">vpraise27@gmail.com</div>
        <div class="delete"><i class='fa-solid fa-trash-can'></i></div>
        </div>
        <div class="student">
        <div class="name">Victor Praise</div>
        <div class="email">vpraise27@gmail.com</div>
        <div class="delete"><i class='fa-solid fa-trash-can'></i></div>
        </div>
        <div class="student">
        <div class="name">Victor Praise</div>
        <div class="email">vpraise27@gmail.com</div>
        <div class="delete"><i class='fa-solid fa-trash-can'></i></div>
        </div>
    

    </div>

    <div id="myModal" class="modal" >
   
   <!-- Modal content -->
   <div class="modal-content">
   <span class="close">&times;</span>

   </div>


</div>
 <!-- sidebar and content, last two div end -->
    </div>
</div>


<!-- modal script -->
<script>
    console.log("test");
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("btn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
 
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>