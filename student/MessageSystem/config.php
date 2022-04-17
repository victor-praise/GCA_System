<?php
/******************************************************
------------------Required Configuration---------------
Please edit the following variables so the forum can
work correctly.
******************************************************/

//We log to the DataBase


$conn = mysqli_connect("itc5531.encs.concordia.ca","itc55314","BF8nR3","itc55314");

if(!$conn){
	die("Connection error: " . mysqli_connect_error());	
}


//Username of the Administrator
$admin='admin';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

//Forum Home Page
$url_home = 'index.php';

//Design Name
$design = 'default';


/******************************************************
----------------------Initialization-------------------
******************************************************/
include('init.php');
?>