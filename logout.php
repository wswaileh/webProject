<?php
session_start();
$_SESSION['userType'] = 1;
 header("Location:main.php"); 
?>