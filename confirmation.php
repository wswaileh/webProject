<?php
include 'model.php';
?>
<html>
<head>
    <link rel="stylesheet" href="css/confirmationStyle.css" type="text/css">

    <title>Confirm You order!</title>
</head>

<body>
<div class="container">
    <table class="picnic-table">
        <thead>
        <tr>
            <th>Picnic Reference ID</th>
            <th>Place</th>
            <th>Date</th>
            <th>Description</th>
            <th>Cost per one</th>
            <th>Departure Time</th>
            <th>Departure Location</th>
            <th>Arrival Time</th>
            <th>Return Time</th>

        </tr>
        </thead>
        <tbody>

        <?php
        $res = null;

        if (isset($_POST['pid'])) {
            $res = getPicnicById($_POST['pid']);
        }

        $keys = ["pid", "place", "date", "description", "cost", "departuretime", "departurelocation", "arrivaltime", "returntime"];

        if ($row = $res->fetch()) {

        ?>

        <tr><?php
            $desc = array();
            $time = array();
            $cost = 0;
            foreach ($keys as $i) {

                if ($row[$i] == "description") {
                    $desc = explode(',', $row[$i]);
                    $row[$i] = $desc[0];
                }

                if ($i == "pid") {
                    echo "<td style='padding-left: 80px;font-size: 1.4pc'><a href='detailed.php?id=" . $row[$i] . "' style='text-decoration:none;'>" . $row[$i] . "</a></td>";
                } else if ($i == "cost") {
                    $cost = $row[$i];
                    ?>
                    <td style="padding-left: 40px"><?= $row[$i] ?> &#8362;</td><?php
                } else if (strpos($i, "time")) {
                    $time = explode(":", $row[$i]);
                    unset($time[2]);
                    $row[$i] = implode(":", $time);

                    ?>
                    <td style="padding-left: 20px">
                    <time><?= $row[$i] ?></time></td><?php
                } else { ?>
                    <td><?= $row[$i] ?></td><?php
                }


            }
            echo "</tr>";

            } ?>

        <tr>

            <td colspan="2"><strong>Total Cost: </strong></td>
            <td colspan="1" style="padding-left: 10px;font-size: 16px">

            </td>
            <td colspan="1">

            </td>
            <td colspan="5">

            </td>
        </tr>

        </tbody>

    </table>

    <div class="pricing">
        <div class="[ price-option price-option--low ]">
            <div class="price-option__detail">
                <span class="price-option__cost"> <?php
<<<<<<< HEAD
                    if (isset($_POST['cost']) && isset($_POST['Birthday_cake']) && isset($_POST['cakeNum']) && isset($_POST['numOfSeats'])) {
                        echo ($_POST['cost'] * $_POST['numOfSeats']) + ($_POST['cakeNum'] * 20) . "&#8362;";
=======
                    if (isset($cost) && isset($_POST['Birthday_cake']) && isset($_POST['numOfSeats'])) {
                        echo ($cost * $_POST['numOfSeats']) + ($_POST['numOfSeats'] * 20) . "&#8362;";
                    } else if (isset($cost)) {
                        echo ($cost * $_POST['numOfSeats']) . "&#8362;";
>>>>>>> 96da0631515f4528486ce8e67f2334e64e1a0fae
                    }
                    ?></span>
                <span class="price-option__type">Total Cost</span>
            </div>
            <a href="#checkoutModal" class="price-option__purchase">Confirm</a>
        </div>
    </div>
</div>

<div class="modal-window" id="checkoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div>
        <div class="modal-title"><strong>Picnic-Checkout</strong><a href="#"><span class="modal-close">×</span></a>
        </div>

        <div class="modal-body">

            <form action="booking.php" method="post" id="checkout-form">

                <img src="img/icons/visa.svg" id="visa" class="payment-card" onclick="changePrefixVisa()">
                <img src="img/icons/mastercard.svg" id="mastercard" class="payment-card" onclick="changePrefixMaster()">
                <img src="img/icons/american-express.svg" id="american-express" class="payment-card"
                     onclick="changePrefixAmerican()">

                <br/>
                <br>
                <hr>
                <br>
                <span class="modal-content">


                    <label id="prefix">xxx-</label>
                    <input type="text" placeholder="xxx-xxx" id="card-num" name="card-num"
                           pattern="[0-9]{3}-[0-9]{3}|[0-9]{6}">
                    <input id="card-name" name="card-name" type="hidden">
                    <br><br>
                    <label for="expire-date"
                           id="expire-date-label">Expire-Date</label>
                    <input type="date" name="expire-date"
                           id="expire-date">
                    <br><br>

                    <label id="bank-label">Bank</label>
                    <input type="text" placeholder="Bank Issued" name="bank" id="bank">
                    <br><br>

                    <input type="submit" value="Checkout" name="checkout">

                    </span>
            </form>

        </div>

    </div>
</div>
</body>

<script type="text/javascript">

    function changePrefixVisa() {
        document.getElementById("prefix").innerHTML = "4444-";
        document.getElementById("card-name").value = "Visa";

    }

    function changePrefixMaster() {
        document.getElementById("prefix").innerHTML = "5555-";
        document.getElementById("card-name").value = "Master";

    }

    function changePrefixAmerican() {
        document.getElementById("prefix").innerHTML = "6666-";
        document.getElementById("card-name").value = "American";

    }


</script>

</html>
