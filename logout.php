<?php
session_name("name");
session_start();
$_SESSION['userType'] = 1;
session_destroy();
header("Location:main.php");
?>