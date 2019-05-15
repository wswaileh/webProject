<?php

include 'layout.php';
if (isset($_GET['new'])) {
    session_destroy();
    header('Location: register.php');
}
?>


<link rel="stylesheet" href="css/register.css" type="text/css">

<div id="container">

    <div class="left-sidebar" id="left-sidebar">

        <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
        <a href="picnics.php" class="fas fa-thumbtack"> Latest Picnics</a>
        <a href="news.php" class="fas fa-newspaper"> News</a>
        <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 2) { ?>
            <a href="#" class="fas fa-shopping-cart" id="openCart"> Cart <span id="openCart-span"
                                                                               class="fas fa-sort-down"
                                                                               style="float: right"></span></a>
            <div class="purchase" id="purchase">
                <?php $customer = getCustomerIdByEmail($_SESSION['email']);

                $cid = 0;
                if ($i = $customer->fetch())
                    $cid = $i['cid'];

                $order = getPurchase($cid);

                ?>
                <ul><?php
                    while ($i = $order->fetch()) {
                        echo "<li>" . $i['pid'] . " | " . $i['title'] . "</li>";
                        echo "<small>" . $i['invoice'] . " <strong class='fas fa-shekel-sign'></strong></small>";
                        echo "<hr>";
                    }

                    ?> </ul><?php
                ?>
            </div>
        <?php } ?>
    </div>

    <script type="text/javascript">

        document.getElementById('openCart').addEventListener('click', function (event) {
            event.preventDefault();

            openAndCloseCart();

        })
    </script>
    <script>

        document.getElementById('close-sidebar').addEventListener('click', function (event) {
            event.preventDefault();
            closeSlidMenu();
        });
    </script>
    <div class="form">
        <form class="form1" action="" method="post">
            <h2 id="h"> register Form</h2>
            <label> NAME :</label> <input type="text" name="name" placeholder="Enter your name" required=""
                                          value="<?php echo(isset($_SESSION['name']) ? $_SESSION['name'] : ''); ?>"/><br>

            <label>EMAIL :</label> <input type="email" name="email" placeholder="Enter Email Address" required=""
                                          value="<?php echo(isset($_SESSION['emailr']) ? $_SESSION['emailr'] : ''); ?>"/>
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] == 1) echo "<sup style=" . "color:red;margin-left:180px;" . ";> email already exist </sup>"; ?>
            <br>

            <label>PHONE :</label><input type="text" name="phone" placeholder="Enter your phone" required=""
                                         value="<?php echo(isset($_SESSION['phone']) ? $_SESSION['phone'] : ''); ?>"/><br>


            <label>Address :</label> <input type="text" name="address" placeholder="Enter your address" required=""
                                            value="<?php echo(isset($_SESSION['address']) ? $_SESSION['address'] : ''); ?>"/><br>

            <label>DOB :</label><input type="date" name="dob" placeholder="Enter birth of date" required=""
                                       value="<?php echo(isset($_SESSION['dob']) ? $_SESSION['dob'] : ''); ?>"/><br>
            <button class="button" type="submit">Register
            </button>

        </form>
    </div>
</div>


<?php
include 'registerValidation.php';
if (!empty($_POST)) {

    $_SESSION['emailr'] = $_POST['email'];
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['name'] = $_POST['name'];

    $error = checkRegister($_POST['email']);
    if ($error != 0) {
        unset($_SESSION['added']);
        $_SESSION['error'] = $error;
        header('Location: register.php');
    } else {

        unset($_SESSION['error']);
        header('Location: eAccount.php');

    }

}


require 'footer.php' ?>




