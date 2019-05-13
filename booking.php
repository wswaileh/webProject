<?php

include 'layout.php';
include 'model.php';

if ($_SESSION['userType'] != 3 && $_SESSION['userType'] != 2) {
    $_SESSION['page-want-to-go'] = "booking.php";
    header("Location:login.php");
}

?>

<div class="container" id="container">

    <div class="left-sidebar" id="left-sidebar">

        <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
        <a href="#" class="fas fa-thumbtack"> Latest Picnics</a>
        <a href="#" class="fas fa-newspaper"> News</a>
        <?php if ($_SESSION['userType'] == 2) { ?>
            <a href="#" class="fas fa-shopping-cart"> Cart</a>
        <?php } ?>
    </div>


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

                    if ($row[$i] == "description") {
                        $desc = explode(',', $row[$i]);
                        $row[$i] = $desc[0];
                    }

                    if ($i == "pid") {
                        $hidden["pid"] = $row[$i];
                        echo "<td  data-tool-tip='For more Details' class='pid' style='padding-left: 80px;font-size: 1.4pc'><a href='detailed.php?id=" . $row[$i] . "' style='text-decoration:none;'>" . $row[$i] . "</a></td>";
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

                                document.getElementById("error-alert").style.display = "none";
                                document.getElementById('form').submit();
                            } else {

                                return error("Please enter how many people intend to come!");
                            }


                        }
                    }

                    function error(body) {

                        let er = document.getElementById("error-alert");
                        er.style.display = "block";

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


    <script type="text/javascript">
        document.getElementById('close-sidebar').addEventListener('click', function (event) {
            event.preventDefault();
            closeSlidMenu();
        });
    </script>

</div>

<?php require 'footer.php' ?>
