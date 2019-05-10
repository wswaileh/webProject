<?php
include 'layout.php';
if(!isset($_SESSION['userType']))
	$_SESSION['userType']=1 ; 
?>
    <nav>
        <a href="customers.php">Customers</a><br>
        <a href="managers.php">Managers</a><br>
        <a href="picnics.php">Picnics</a><br>
        <a href="booking.php">Booking Dashboard</a><br>
    </nav>
</html>
