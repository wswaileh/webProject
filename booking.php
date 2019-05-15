<?php

include 'layout.php';
include 'model.php';

if ($_SESSION['userType'] != 3 && $_SESSION['userType'] != 2) {
    $_SESSION['page-want-to-go'] = "booking.php";
    $_SESSION['picnicNum'] = $_GET['id'];

    header("Location:login.php");
}


if (!isset($_GET['id'])) {
    header("location:main.php");
}


$Customer = getCustomerIdByEmail($_SESSION['email']);
$cid = 0;

if ($row = $Customer->fetch()) {
    $cid = $row['cid'];

}

if ($Check = checkIfBooked($_GET['id'], $cid)->fetch()) {
    if ($Check[0] > 0) {
        echo "<script>alert('You have already booked this Picnic....');window.location.replace('picnics.php');</script>";
    }

}

?>

<div class="container" id="container">


    <form method="post" action="confirmation.php" id="form">
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
            $capacityNum = 0;
            $bookers = 0;

            if (isset($_GET['id'])) {

                $capacity = getPicnicsCapacity($_GET['id']);
                $booker = trackPicnicsCapacity($_GET['id']);
                if ($i = $capacity->fetch()) {
                    $capacityNum = $i['capacity'];

                }

                if ($j = $booker->fetch()) {
                    $bookers = $j['total_bookers'];

                }

                if (!$bookers) {
                    $bookers = 0;
                }


                $res = getPicnicById($_GET['id']);
            }


            if ($bookers == $capacityNum) {
                header("Location:picnics.php");
            }


            $keys = ["pid", "place", "date", "description", "cost", "departuretime", "departurelocation", "arrivaltime", "returntime"];

            $hidden = ["pid"];
            if ($row = $res->fetch()) {

            ?>

            <tr><?php
                $desc = array();
                $time = array();
                foreach ($keys as $i) {

                    if ($i == "description") {
                        $desc = explode(',', $row[$i]);
                        $row[$i] = $desc[0];
                    }

                    if ($i == "pid") {
                        $hidden["pid"] = $row[$i];
                        echo "<td  data-tool-tip='For more Details' class='pid' style='padding-left: 80px;font-size: 1.4pc'><a id='pidA' href='#'" . $row[$i] . "' style='text-decoration:none;'>" . $row[$i] . "</a></td>";

                        ?>

                        <script type="text/javascript">

                            document.getElementById('pidA').addEventListener('click', function (event) {
                                event.preventDefault();
                                display(<?=$row[$i]?>);

                            });

                        </script>

                        <div class="detail-modal" id="modal-<?= $row[$i] ?>">
                            <div class="detail-modal-content">
                                <div class="detail-modal-header"><h3>Picnic #<?= $row[$i] ?>
                                        - <?= $row['place'] ?></h3>
                                    <span class="detail-modal-close" id="close-<?= $row[$i] ?>">&times;</span>
                                </div>
                                <div class="detail-modal-body">
                                    <?php

                                    $details = getpicnicsDetails($row[$i]);
                                    $Details = array();

                                    if ($d = $details->fetch()) {


                                        while ($element = current($d)) {
                                            $AM_PM = [];
                                            if (strpos(key($d), "time")) {
                                                $timeItems = array();
                                                $timeItems = explode(':', $d[key($d)]);
                                                $AM_PM = explode(' ', $timeItems[2]);
                                                $timeItems[2] = $AM_PM[1];
                                                $d[key($d)] = implode(':', $timeItems);

                                            }

                                            $Details[key($d)] = $d[key($d)];

                                            next($d);
                                        }

                                    }


                                    ?>

                                    <div class="time">

                                        <strong class="far fa-clock">Departure Time: </strong><strong
                                                class="far fa-clock">Arrival Time</strong><strong
                                                class="far fa-clock">Return
                                            Time</strong>
                                        <i><?= $Details['departuretime'] ?></i>
                                        <i><?= $Details['arrivaltime'] ?></i>
                                        <i><?= $Details['returntime'] ?></i>

                                    </div>

                                    <div class="details-desc">
                                        <ul>
                                            <dl>
                                                <li><strong><?= $Details['title'] ?></strong></li>

                                                <li>
                                                    <dt><strong class="fas fa-utensils-alt"
                                                                style="font-weight: 900">Food</strong></dt>
                                                    <dd><?= $Details['food'] ?></dd>
                                                </li>

                                                <li>
                                                    <dt><strong class="fas fa-hiking">Activities</strong></dt>
                                                    <dd><?= $Details['activities'] ?></dd>
                                                </li>
                                            </dl>
                                        </ul>

                                        <p>
                                            <strong class="fas fa-info-circle">Description: </strong><br><?= $row['description'] ?>
                                        </p>
                                    </div>
                                    <strong style="padding: 30px" class="fas fa-images">Photos
                                        Related: </strong><br>
                                    <div class="photos-container">


                                        <?php
                                        $images = array();
                                        $images = explode(';', $Details['images']);
                                        if (in_array("default", $images)) {
                                            ?> <img src="img/icons/logo.jpg" width="250px" height="250px">
                                            <img src="img/icons/logo.jpg" width="250px" height="250px">
                                            <img src="img/icons/logo.jpg" width="250px" height="250px">
                                            <?php
                                        } else {
                                            ?>
                                            <div class="card">
                                                <img src="img/picnics/<?= $images[0] ?>.jpg" width="250px"
                                                     height="250px" class="card__img">
                                                <div class="card__text">
                                                    <h3 class="card__title"><sub>Laflef</sub><sup>Team</sup>&copy;
                                                    </h3>
                                                    <p><?= $Details['title'] ?></p>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <img src="img/picnics/<?= $images[1] ?>.jpg" width="250px"
                                                     height="250px" class="card__img">
                                                <div class="card__text">
                                                    <h3 class="card__title"><sub>Laflef</sub><sup>Team</sup>&copy;
                                                    </h3>
                                                    <p><?= $Details['title'] ?></p>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <img src="img/picnics/<?= $images[2] ?>.jpg" width="250px"
                                                     height="250px" class="card__img">
                                                <div class="card__text">
                                                    <h3 class="card__title"><sub>Laflef</sub><sup>Team</sup>&copy;
                                                    </h3>
                                                    <p><?= $Details['title'] ?></p>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="detail-links-related">
                                        <strong class="fas fa-link">Links Related To the picnic's
                                            Place:</strong><br>
                                        <a href="https://en.wikipedia.org/wiki/<?= $row['place'] ?>"
                                           target="_blank" style="text-decoration: none">
                                            <ul>
                                                <li><?= $row['place'] ?></li>
                                            </ul>
                                        </a>
                                    </div>

                                </div>
                                <div class="detail-modal-footer">
                                    <a href="aboutUs.php" style="text-decoration: none; color: white">
                                        <sub>Laflef</sub><sup>Team</sup>&copy;
                                        <img src="img/icons/logo.jpg" width="100px" height="50px">
                                    </a>
                                </div>
                            </div>
                        </div>


                    <?php

                    } else if ($i == "cost") {

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
                <td colspan="1"><label style="font-size: 16px" id="Bcake">Additions~Birthday cake:</label></td>
                <td colspan="1" style="padding-left: 20px">
                    <div class="tooltip"><input type="checkbox" name="Birthday_cake" value="Birthday Cake">
                        <span class="tooltiptext">Check the box if you want to add birthday cake to your order!</span>
                    </div>
                </td>
                <td colspan="1">

                </td>
                <td colspan="1">

                </td>

                <td colspan="3"><input type="number" min="1" max="<?= ($capacityNum - $bookers) ?>"
                                       class="filter-input"
                                       name="numOfSeats"
                                       placeholder="Please Enter Number of People intend to come "
                                       id="NumberOfPeople" data-tool-tip="Number of Guests intend to come">
                    <input type="hidden" id="available" value="<?= ($capacityNum - $bookers) ?>">
                    <sup id="availableLabel" style="display: none;color: red"><?= ($capacityNum - $bookers) ?> Available
                        only!</sup>
                </td>

                <td colspan="2"><input style="width: 200px" type="submit" name="confirm" value="Confirm The Booking"
                                       class="button" onclick=" return f()"><input
                            type="hidden" value="<?= $hidden["pid"] ?>"
                            name="pid"></td>

                <script type="text/javascript">


                    function f() {

                        let people = parseInt(document.getElementById("NumberOfPeople").value, 10);
                        let available = parseInt(document.getElementById("available").value, 10);


                        if (people > available) {

                            document.getElementById("availableLabel").style.display = "inline"

                            return false;
                        } else {

                            document.getElementById("availableLabel").style.display = "none"
                            if (people) {
                                let left = (screen.width - 800) / 2;
                                let top = (screen.height - 600) / 4;
                                document.getElementById('form').target = "confirmation.php";
                                let myWindow = window.open("confirmation.php", "confirmation.php", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + 800 + ', height=' + 600 + ', top=' + top + ', left=' + left);

                                window.location.replace("picnics.php");

                                document.getElementById("error-alert").style.visibility = "hidden";
                                document.getElementById('form').submit();
                            } else {

                                return error("Please enter how many people intend to come!");
                            }


                        }
                    }

                    function error(body) {

                        let er = document.getElementById("error-alert");
                        er.style.visibility = "visible";

                        er.innerHTML = "  <div class=\"alert-heading\">\n" +
                            "                <span></span><h2>Error!</h2>\n" +
                            "          </div>\n" +
                            "          <div class=\"inner-msg\">\n" +
                            "                <p>" + body + "</p>\n" +
                            "          </div>"

                        return false;

                    }

                </script>

            </tr>

            </tbody>


        </table>

    </form>

    <div id="error-alert"></div>

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

        });
    </script>


    <script type="text/javascript">
        document.getElementById('close-sidebar').addEventListener('click', function (event) {
            event.preventDefault();
            closeSlidMenu();
        });
    </script>

</div>

<?php require 'footer.php' ?>
