<?php
    session_name("name");
    session_start();
    if ($_SESSION['userType'] != 3)
        header("Location: main.php");
    require 'layout.php';
?>
<link rel="stylesheet" type="text/css" href="css/viewMessages.css">
<h1>Contact Us Messages</h1>

<?php
    require 'model.php';
    printMessages();
?>

<?php
    require 'footer.php';
?>