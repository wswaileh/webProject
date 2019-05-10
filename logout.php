<?php
session_name("name");
session_start();
session_destroy();
$_SESSION['userType'] = 1;
 header("Location:main.php"); 
?>