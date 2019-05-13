<?php
session_name("name");
session_start();
if ($_SESSION['userType'] != 3)
    header("Location: main.php");
require 'layout.php';
?>
    <link rel="stylesheet" type="text/css" href="css/viewMessages.css">


    <div class="left-sidebar" id="left-sidebar">

        <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
        <a href="#" class="fas fa-thumbtack"> Latest Picnics</a>
        <a href="#" class="fas fa-newspaper"> News</a>
        <?php if ($_SESSION['userType'] == 2) { ?>
            <a href="#" class="fas fa-shopping-cart"> Cart</a>
        <?php } ?>
    </div>


    <script type="text/javascript">
        document.getElementById('close-sidebar').addEventListener('click', function (event) {
            event.preventDefault();
            closeSlidMenu();
        });
    </script>

<?php
require 'model.php';
printMessages();
?>

<?php
require 'footer.php';
?>