<?php
include 'layout.php';
include 'model.php';


$amjad = "img/avatar/amjad.jpg";

$waleed = "img/avatar/waleed.jpg";
$mustafa = "img/avatar/mustafa.jpg";

$avatar = "";


?>
    <link rel="stylesheet" type="text/css" href="css/news.css">
    <div id="container">
        <?php

        $news = getNews();
        ?>
        <div class="row"><?php
            while ($row = $news->fetch()) {

            $owner = getOwnerOfNew($row['nid']);

            if ($i = $owner->fetch()) {

            if ($i['username'] == "Mustafa") {
                $avatar = $mustafa;
            } elseif ($i['username'] == "Waleed") {
                $avatar = $waleed;
            } else {
                $avatar = $amjad;
            }

            ?>
            <div class="column">
                <div class="talk-bubble">

                        <div class="avatar"><img src="<?= $avatar ?>"
                                                 style="max-width: 100%;max-height: 100%;"><br>Spread By:
                            <strong><?= $i['username'] ?></strong>
                            <br>
                            <small>Created At: <?= $row['created_at'] ?></small>
                        </div>
                        <p><?= $row['news'] ?></p>
                    </div>

            </div>
        </div>
    <?php
    }
    } ?>
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

        })

    </script>
<?php


require 'footer.php' ?>