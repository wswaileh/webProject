<?php
session_name("name");
session_start();
$_SESSION['userType'] = 1; //GUEST USER
include 'layout.php';
include 'navbar.php';
    ?><nav><a href="customers.php">Customers</a><br>
    <a href="managers.php">Managers</a><br>
    <a href="picnics.php">Picnics</a><br>
    <a href="booking.php">Booking Dashboard</a><br>
</nav>
<?php require 'footer.php'?>
</html>

<?