<?php

include 'layout.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST)) {
    header("location:register.php");
}


include 'registerValidation.php';
if (!empty($_POST)) {

    $_SESSION['emailr'] = $_POST['email'];
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['username'] = $_POST['username'];


    $error = finalCheck($_SESSION['emailr'], $_SESSION['username']);
    if ($error != 0) {
        unset($_SESSION['added']);
        $_SESSION['errorc'] = $error;
        header('Location: registerConfirm.php');
    } elseif (addUser($_SESSION['name'], $_SESSION['emailr'], $_SESSION['username'], $_SESSION['phone'], md5($_SESSION['password']), $_SESSION['address'], $_SESSION['dob'], $_SESSION['id']) == 1) {
        $_SESSION['userType'] = 2;
        $_SESSION['Customer_Name']=$_SESSION['name'];
        echo("<script LANGUAGE='JavaScript'>
    window.alert('User added succifully');
    window.location.href='main.php';
    </script>");
    } else {
        $_SESSION['added'] = 0;
        unset($_SESSION['errorc']);
        header('Location: registerConfirm.php');
    }


}

?>


<link rel="stylesheet" href="css/register.css" type="text/css">

<!DOCTYPE html>
<html>
<head>
    <title>Register Confirmation</title>
</head>
<body>
<div id="container">
    <div class="form">
        <form class="form1" action="" method="post">
            <h2 id="h"> register Confirmation</h2>
            <label> NAME :</label> <input type="text" name="name" required=""
                                          value="<?php echo(isset($_SESSION['name']) ? $_SESSION['name'] : ''); ?>"/><br>

            <label>EMAIL :</label> <input type="email" name="email" required=""
                                          value="<?php echo(isset($_SESSION['emailr']) ? $_SESSION['emailr'] : ''); ?>"/>
            <?php if (isset($_SESSION['error']) && $_SESSION['errorc'] == 1) echo "<sup style=" . "color:red;margin-left:180px;" . ";> email already exist </sup>"; ?>
            <br>

            <label>Username :</label> <input type="text" name="username" required=""
                                             value="<?php echo(isset($_SESSION['username']) ? $_SESSION['username'] : ''); ?>"/>
            <?php if (isset($_SESSION['errorc'])) {
                if ($_SESSION['errorc'] == 2) echo "
  <sup style=" . "color:red;margin-left:180px;" . ";> invalid username , number of characters<br><span style=" . "margin-left:180px;" . ">should be between 6-13</span></sup> ";
                elseif ($_SESSION['errorc'] == 3) echo "<sup style=" . "color:red;margin-left:180px;" . ";> used username </sup>";
            }
            ?>

            <label>id :</label><input type="text" name="phone"
                                      value="<?php echo(isset($_SESSION['id']) ? $_SESSION['id'] : ''); ?>"
                                      readonly/><br>

            <label>PHONE :</label><input type="text" name="phone" required=""
                                         value="<?php echo(isset($_SESSION['phone']) ? $_SESSION['phone'] : ''); ?>"/><br>


            <label>Address :</label> <input type="text" name="address" required=""
                                            value="<?php echo(isset($_SESSION['address']) ? $_SESSION['address'] : ''); ?>"/><br>

            <label>DOB :</label><input type="date" name="dob" placeholder="Enter birth of date" required=""
                                       value="<?php echo(isset($_SESSION['dob']) ? $_SESSION['dob'] : ''); ?>"/><br>
            <button class="button" type="submit">Confirm
            </button>

            <?php if (isset($_SESSION['added']) && $_SESSION['added'] == 0) echo "<br><br><p style=" . "color:red;margin-left:180px;" . ";> Error 402</p>"; ?>


        </form>
    </div>


</div>


<div class="left-sidebar" id="left-sidebar">

    <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
    <a href="picnics.php" class="fas fa-thumbtack"> Latest Picnics</a>
    <a href="news.php" class="fas fa-newspaper"> News</a>
    <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 2) { ?>
        <a href="#" class="fas fa-shopping-cart" id="openCart"> Cart <span id="openCart-span" class="fas fa-sort-down"
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

</body>
</html>

