<nav class="topnav" id="myTopnav">
    <a href="main.php" id="companyTitle">LafLef</a>
    <div class="links">
        <a href="main.php">Main</a>
        <a href="picnics.php">Picnics</a>
        <?php
            if (!isset($_SESSION['userType']) ||  $_SESSION['userType'] == 1) //GUEST         LINKS MUST BE UPDATED LATER
                echo '
                    
                    <a href="main.php">About Us</a>
                    <a href="register.php">Register</a>
                    <a href="login.php">Login</a>
                ';
            else if ($_SESSION['userType'] == 2) //USER         LINKS MUST BE UPDATED LATER
                echo '
                    <a href="logout.php">Logout</a>
                ';
            else
                echo '
                    <a href="main.php">Add Picnic</a>
                    <a href="logout.php">Logout</a>
                ';
        ?>
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
