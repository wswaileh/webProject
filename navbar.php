<<<<<<< HEAD
<?php
session_name("name");
if(!isset($_SESSION))
{
    session_start();
} ?>
<nav class="nav">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            <a href="main.php" style="color:#FDFDFD;text-decoration: none">LafLef-لفلف</a>
        </div>
    </div>
    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
<!--        --><?php
//        if ($_SESSION['userType'] === 1) //"GUEST"  LINKS NEED TO BE UPDATED
//            echo '<a href="main.php">About Us</a>
//                  <a href="main.php">Register</a>
//                  <a href="main.php">Login</a>
//            ';
//        else if ($_SESSION['userType'] === 2) //"USER"      LINKS NEED TO BE UPDATED
//            echo '<a href="main.php">Main</a>
//                  <a href="main.php">Logout</a>
//            ';
//        else //ADMIN        LINKS NEED TO BE UPDATED
//            echo '<a href="main.php">Main</a>
//                  <a href="main.php">Add Picnic</a>
//                  <a href="main.php">Logout</a>
//            ';
//
//        ?>
=======
<nav class="topnav" id="myTopnav">
    <a href="#home" id="companyTitle">LafLef</a>
    <div class="links">
        <a href="main.php">Main</a>
        <?php
            if ($_SESSION['userType'] == 1) //GUEST         LINKS MUST BE UPDATED LATER
                echo '
                    <a href="main.php">About Us</a>
                    <a href="main.php">Register</a>
                    <a href="main.php">Login</a>
                ';
            else if ($_SESSION['userType'] == 2) //USER         LINKS MUST BE UPDATED LATER
                echo '
                    <a href="main.php">Logout</a>
                ';
            else
                echo '
                    <a href="main.php">Add Picnic</a>
                    <a href="main.php">Logout</a>
                ';
        ?>
>>>>>>> 8b8b095d021c4033ca962bdbc4536478594ecfa6
    </div>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i>▼</i>
    </a>
</nav>

<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>