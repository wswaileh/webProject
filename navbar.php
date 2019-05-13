<nav class="topnav" id="myTopnav">
    <a href="#" id="hamburger" class="fas fa-bars"></a>
    <a href="main.php" id="companyTitle">LafLef</a>

    <div class="links">
        <a href="main.php" class="fas fa-home">Main</a>
        <a href="picnics.php" class="fas fa-smile-beam"> Picnics</a>
        <?php
        if (!isset($_SESSION['userType']) || $_SESSION['userType'] == 1) //GUEST         LINKS MUST BE UPDATED LATER
            echo '
                    <a href="aboutUs.php" class="fas fa-address-card"> About Us</a>
                    <a href="register.php?new" class="fas fa-user-plus"> Register</a>
                    <a href="login.php?new" class="fas fa-sign-in-alt"> Login</a>
                ';
        else if ($_SESSION['userType'] == 2) //USER         LINKS MUST BE UPDATED LATER
            echo '
                    <a href="logout.php" class="fas fa-sign-out-alt"> Logout</a>
                ';
        else
            echo '
                    <a href="viewMessages.php" class="fas fa-envelope" > View Messages</a>
                    <a href="addPicnic.php" class="fas fa-plus"> Add Picnic</a>
                    <a href="logout.php" class="fas fa-sign-out-alt"> Logout</a>
                ';
        ?>
    </div>
    <a href="#" onclick="navCollapse()" class="icon" onclick="myFunction()">
        <i>▼</i>
    </a>
</nav>

<script src="javascript/main.js"></script>

<script>

    document.getElementById("hamburger").addEventListener('click', function (event) {

        event.preventDefault();
        openSlidMenu();

    })

    function navCollapse() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
