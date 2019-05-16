<?php
include 'model.php';
session_name("name");
session_start();

if (!isset($_POST['pid']))
    header("location:main.php");
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
            <th>Number of Guests</th>
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

            $time = array();
            $cost = 0;
            $seats = 0;
            $additions = "";
            $invoice = 0;
            $date = date("Y-m-d");
            $pid = 0;
            foreach ($keys as $i) {

                if ($i == "description") {

                    if (isset($_POST['numOfSeats'])) {

                        echo "<td style='padding-left: 40px;font-size: 1.2pc'>" . $_POST['numOfSeats'] . "</td>";
                        continue;
                    }
                }

                if ($i == "pid") {
                    $pid = $row[$i];
                    echo "<td class='pid' style='padding-left: 40px;font-size: 1.4pc'><a href='#' style='text-decoration:none;'>" . $row[$i] . "</a></td>";
                } else if ($i == "cost") {
                    $cost = $row[$i];
                    ?>
                    <td style="padding-left: 25px"><?= $row[$i] ?> &#8362;</td><?php
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

            <td colspan="2"></td>
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

                    if (isset($cost) && isset($_POST['Birthday_cake']) && isset($_POST['numOfSeats'])) {

                        $additions = "Birthday-Cake for " . $_POST['numOfSeats'];
                        $invoice = ($cost * $_POST['numOfSeats']) + ($_POST['numOfSeats'] * 20);
                        echo ($cost * $_POST['numOfSeats']) + ($_POST['numOfSeats'] * 20) . "&#8362;";
                    } else if (isset($cost)) {
                        $additions = "None";
                        $invoice = ($cost * $_POST['numOfSeats']);
                        echo ($cost * $_POST['numOfSeats']) . "&#8362;";

                    }

                    $seats = $_POST['numOfSeats']
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

            <form action="checkout-temp.php" method="post" id="checkout-form">

                <img src="img/icons/visa.svg" id="visa" class="payment-card" onclick="changePrefixVisa()">
                <img src="img/icons/mastercard.svg" id="mastercard" class="payment-card"
                     onclick="changePrefixMaster()">
                <img src="img/icons/american-express.svg" id="american-express" class="payment-card"
                     onclick="changePrefixAmerican()">

                <br/>
                <br>
                <hr>
                <br>
                <span class="modal-content" id="content" style="display: none">


                    <label id="prefix">xxx-</label>
                    <input type="text" placeholder="xxx-xxx" id="card-num" name="card-num"
                           pattern="[0-9]{3}-[0-9]{3}|[0-9]{6}">
                           <br> <sup class="modal-errors" id="card-error">Please Enter 6-digit valid number xxx-xxx or xxxxxx</sup>
                    <input id="card-name" name="card-name" type="hidden">
                    <br><br>
                    <label for="expire-date"
                           id="expire-date-label">Expire-Date</label>
                    <input type="date" name="expire-date"
                           id="expire-date">
                    <br><sup class="modal-errors" id="date-error">Please Enter Expire Date</sup>
                    <br><br>

                    <label id="bank-label">Bank</label>
                    <input type="text" placeholder="Bank Issued" name="bank" id="bank"
                           data-tool-tip="Bank issued with the Card">
                        <input type="hidden" name="invoice" value="<?= $invoice ?>">
                        <input type="hidden" name="additions" value="<?= $additions ?>">
                        <input type="hidden" name="date" value="<?= $date ?>">
                        <input type="hidden" name="seats" value="<?= $seats ?>">
                        <input type="hidden" name="pid" value="<?= $pid ?>">
                    <input type="hidden" name="cost" value="<?= $cost ?>">
                     <br><sup class="modal-errors" id="bank-error">Please Enter Bank issued with card</sup>
                    <br><br>

                    <input type="submit" value="Checkout" name="checkout" onclick="return validate()">

                    </span>
            </form>

        </div>

    </div>
</div>
</body>

<script type="text/javascript">

    function checkEnteredDates(current,expired){
        //seperate the year,month and day for the first date
        var stryear1 = current.substring(6);
        var strmth1  = current.substring(0,2);
        var strday1  = current.substring(5,3);
        var date1    = new Date(stryear1 ,strmth1 ,strday1);

        //seperate the year,month and day for the second date
        var stryear2 = expired.substring(6);
        var strmth2  = expired.substring(0,2);
        var strday2  = expired.substring(5,3);
        var date2    = new Date(stryear2 ,strmth2 ,strday2 );

        var datediffval = (date2 - date1 )/864e5;

        if(datediffval <= 0){
            alert("Expired Card!");
            return false;
        }
        return true;
    }


    function validate() {

        let cardNum = document.getElementById("card-num");
        let expire_date = document.getElementById("expire-date");
        let bank = document.getElementById("bank");

        var today = new Date();
        alert(today);
        var dd = today.getDate();

        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        if(dd<10)
        {
            dd='0'+dd;
        }

        if(mm<10)
        {
            mm='0'+mm;
        }
        today = yyyy+'-'+mm+'-'+dd;
        alert(today);

        checkEnteredDates(today,expire_date)


        let state = true;

        if (!cardNum.value) {
            document.getElementById("card-error").style.display = "inline";
            state = false;
        }
        if (!expire_date.value) {
            document.getElementById("date-error").style.display = "inline";

            state = false;
        }
        if (!bank.value) {
            document.getElementById("bank-error").style.display = "inline";

            state = false;
        }
        

        if (!state) {
            return false;
        }
        return true;
    }

    function changePrefixVisa() {
        document.getElementById("prefix").innerHTML = "4444-";
        document.getElementById("card-name").value = "Visa/4444";
        document.getElementById("content").style.display = "block";


    }

    function changePrefixMaster() {
        document.getElementById("prefix").innerHTML = "5555-";
        document.getElementById("card-name").value = "Master-Card/5555";
        document.getElementById("content").style.display = "block";


    }

    function changePrefixAmerican() {
        document.getElementById("prefix").innerHTML = "6666-";
        document.getElementById("card-name").value = "American-Express/6666";
        document.getElementById("content").style.display = "block";


    }


</script>

</html>
