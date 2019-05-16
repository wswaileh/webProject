<?php
include 'layout.php';
include 'model.php';
if (!isset($_SESSION['userType']) && $_SESSION['userType'] != 3) {
    header("location:main.php");
}

if (isset($_POST['news']) && !empty($_POST['news'])) {


    $manager = getManagerIdByemail($_SESSION['email']);

    if ($row = $manager->fetch()) {
        insertNews($row['mid'], $_POST['news']);
        echo "<script>alert('News Spread Successfully!')</script>";
        header("location:news.php");
    }
}

?>
    <link rel="stylesheet" href="css/aboutUs.css" type="text/css">
    <script src="ckeditor/ckeditor.js"></script>


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

        var role = <?=$_SESSION['userType']?>;

        if (role ==2) {
            document.getElementById('openCart').addEventListener('click', function (event) {
                event.preventDefault();

                openAndCloseCart();

            });
        }

    </script>

    <div id="container">

        <div class="container-news" id="container">
            <sub style="color:red;display: none;padding: 10px" id="error">Please Fill in the Text-area!</sub>
            <input type="button"
                   onclick="validate()"
                   class="bt"
                   style="position: absolute;left: 35%;top: 1%;cursor: pointer" value="Spread News">
            <div class="row" id="contact">
                <form method="post" id="news" action="addNews.php">

                    <textarea name="news" id="news-text"></textarea>

                </form>
            </div>
        </div>

    </div>

    <script>

        document.getElementById('close-sidebar').addEventListener('click', function (event) {
            event.preventDefault();
            closeSlidMenu();

        })

        CKEDITOR.replace('news');

        function validate() {
            let value = CKEDITOR.instances.news.getData();
            if (!value) {
                document.getElementById('error').style.display = 'block';
            } else {
                document.getElementById('news-text').value = value;
                document.getElementById('news').submit();

            }

        }
    </script>


<?php


require 'footer.php';