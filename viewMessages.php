<?php
session_name("name");
session_start();
if ($_SESSION['userType'] != 3)
    header("Location: main.php");
require 'layout.php';
include 'model.php';
?>
    <link rel="stylesheet" type="text/css" href="css/viewMessages.css">




    <div class="left-sidebar" id="left-sidebar">

        <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
        <a href="picnics.php" class="fas fa-thumbtack"> Latest Picnics</a>
        <a href="news.php" class="fas fa-newspaper"> News</a>
        <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 2) { ?>
            <a href="#" class="fas fa-shopping-cart" id="openCart"> Cart <span id="openCart-span" class="fas fa-sort-down" style="float: right"></span></a>
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

        var role = <?=$_SESSION['userType']?>;

        if (role ==2) {
            document.getElementById('openCart').addEventListener('click', function (event) {
                event.preventDefault();

                openAndCloseCart();

            });
        }
    </script>
    <script type="text/javascript">
        document.getElementById('close-sidebar').addEventListener('click', function (event) {
            event.preventDefault();
            closeSlidMenu();
        });
    </script>

<?php
printMessages();
?>

<?php
require 'footer.php';
?>