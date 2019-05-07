<?php
include 'layout.php';
include 'model.php';
if ($_SESSION['userType'] == 1 ){
    $_SESSION['pageCameFrom'] = "booking.php?".$_SERVER["QUERY_STRING"] ;
    header("Location: Login.php");
}

?>

<div class="container">


    <form method="post" action="confirmation.php" id="form" onsubmit="return f();">
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

            if (isset($_GET['id'])) {
                $res = getPicnicById($_GET['id']);
            }

            $keys = ["pid", "place", "date", "description", "cost", "departuretime", "departurelocation", "arrivaltime", "returntime"];

            $hidden = ["pid", "cost"];
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
                        echo "<td style='padding-left: 80px;font-size: 1.4pc'><a href='detailed.php?id=" . $row[$i] . "' style='text-decoration:none;'>" . $row[$i] . "</a></td>";
                    } else if ($i == "cost") {
                        $hidden["cost"] = $row[$i];
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

                <td colspan="1"><label style="font-size: 16px">Additions~Birthday cake:</label></td>


                <td colspan="1" style="padding-left: 20px">
                    <div class="tooltip"><input type="checkbox" name="Birthday_cake" value="Birthday Cake"
                                                placeholder=" " id="Birthday_cake">
                        <span class="tooltiptext">Check the box if you want to add birthday cake to your order!</span>
                    </div>
                </td>


                <td colspan="1">
                    <div class="tooltip"><input type="number" class="filter-input" min="1" max="50"
                                                name="cakeNum" id="cakeNum" placeholder=" " disabled>
                        <label for="cakeNum" class="placeholder-label">#people</label>
                        <span class="tooltiptext">For how many people do you want the cake? Maximum 50</span>
                    </div>
                </td>


                <td colspan="1">

                </td>


                <td colspan="3">
                    <div><input type="number" min="1" max="2"
                                class="filter-input"
                                name="numOfSeats" id="NumberOfPeople" placeholder=" ">
                        <label for="NumberOfPeople" class="placeholder-label">Please Enter Number of People intend to
                            come</label>

                    </div>
                </td>

                <td colspan="2"><input style="width: 200px" type="submit" name="confirm" value="Confirm The Booking"
                                       class="button"><input
                            type="hidden" value="<?= $hidden["pid"] ?>"
                            name="pid"><input type="hidden"
                                              value="<?= $hidden["cost"] ?>"
                                              name="cost"></td>

                <script type="text/javascript">

                    var cake = document.getElementById("Birthday_cake").checked;

                    if (cake == true) {
                        document.getElementById("cakeNum").removeAttribute('disabled');
                    }

                    function error(body) {

                        let er = document.getElementById("error-alert");

                        // er.style.margin = "30px auto";
                        // er.style.width = "550px";
                        // er.style.height = "100px";
                        // er.style.background = "#ececec";
                        // er.style.border = "2px solid #8f2203";
                        // er.style.borderRadius = "0px 5px 0px 5px";
                        er.style.display = "block";

                        er.innerHTML = "  <div class=\"alert-heading\">\n" +
                            "                <span></span><h2>Error!</h2>\n" +
                            "          </div>\n" +
                            "          <div class=\"inner-msg\">\n" +
                            "                <p>" + body + "</p>\n" +
                            "          </div>"

                        return false;

                    }


                    function f() {

                        let people = document.getElementById("NumberOfPeople").value;

                        let cakeNum = document.getElementById("cakeNum").value;


                        if (cake == true && (cakeNum == null || cakeNum == 0)) {

                            return error("Please assign value for how many people do you want the cake.");

                        }

                        if (people) {

                            let left = (screen.width - 800) / 2;
                            let top = (screen.height - 600) / 4;
                            document.getElementById('form').target = "confirmation.php";
                            let myWindow = window.open("confirmation.php", "confirmation.php", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + 800 + ', height=' + 600 + ', top=' + top + ', left=' + left);
                            document.getElementById("error-alert").style.display = "none";

                            document.getElementById('form').submit();
                        } else {

                            return error("Please enter how many people intend to come!");
                        }
                    }
                </script>

            </tr>

            </tbody>


        </table>

    </form>


    <div id="error-alert">

    </div>
</div>

</body>
</html>
