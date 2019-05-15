<?php
include 'layout.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['new'])) {
    session_destroy();
    header('Location: login.php');
}

?>
<link rel="stylesheet" href="css/login.css" type="text/css">

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
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
    <div class="form">
        <form class="form1" action="" method="post">
            <h2 id="h"> login Form</h2>
            <label>Email : </label><input type="email" name="email"
                                          value="<?php echo(isset($_SESSION['email']) ? $_SESSION['email'] : ''); ?>"
                                          placeholder="Email Address"
                                          required=""/><?php if (isset($_SESSION['wrong']) && $_SESSION['wrong'] == 1) echo "<sup style=" . "color:red;margin-left:125px;" . ";> email doesn't exist </sup>"; ?>
            <br><br>
            <label>Password :</label><input type="password" name="password" placeholder="Password"
                                            required=""/> <?php if ((isset($_SESSION['wrong'])) && $_SESSION['wrong'] == 2) echo "<sup style=" . "color:red;margin-left:125px;" . "> wrong password </sup>"; ?>


            <br><br>
            <button class="button" type="submit">Login</button>
        </form>
    </div>
</div>

<script type="text/javascript">


    document.getElementById('close-sidebar').addEventListener('click', function (event) {
        event.preventDefault();
        closeSlidMenu();
    });
</script>

<?php require 'footer.php' ?>


<?php
include 'model.php';

if (!empty($_POST)) {

    if (checkEmail($_POST['email']) == 0) {
        $_SESSION['wrong'] = 1;
        $_SESSION['email'] = $_POST['email'];
        header("Location:login.php");
    } elseif (checkManger($_POST['email'], $_POST['password']) > 0) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['userType'] = 3;
        header("Location:main.php");
    } elseif (checkCustomer($_POST['email'], md5($_POST['password'])) > 0) {
        $_SESSION['userType'] = 2;
        $_SESSION['email'] = $_POST['email'];

        $customer = getCustomerIdByEmail($_SESSION['email']);
        $name = "";
        if ($row = $customer->fetch()) {
            $name = $row['name'];
            $_SESSION['Customer_Name'] = $name;
        }
        if (isset($_SESSION['page-want-to-go'])) {
            header("Location:" . $_SESSION['page-want-to-go'] . "?id=" . $_SESSION['picnicNum']);
        } else {
            header("Location:main.php");
        }
    } else {
        $_SESSION['wrong'] = 2;
        $_SESSION['email'] = $_POST['email'];
        header("Location:login.php?");
    }

}


?>

