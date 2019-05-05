<?php

include 'layout.php';
include 'model.php';

?>

<div class="container">


    <form method="post" action="confirmation.php">
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

                    if (strpos($i, "time")) {
                        $time = explode(":", $row[$i]);
                        unset($time[2]);
                        $row[$i] = implode(":", $time);
                    }
                    if ($i == "pid") {
                        $hidden["pid"] = $row[$i];
                        echo "<td style='padding-left: 80px;font-size: 1.4pc'><a href='detailed.php?id=" . $row[$i] . "' style='text-decoration:none;'>" . $row[$i] . "</a></td>";
                    } else if ($i == "cost") {
                        $hidden["cost"] = $row[$i];
                        ?>
                        <td style="padding-left: 40px"><?= $row[$i] ?> &#8362;</td><?php
                    } else { ?>
                        <td><?= $row[$i] ?></td><?php
                    }


                }
                echo "</tr>";

                } ?>

            <tr>

                <td colspan="4"><input type="text" class="filter-input"
                                       name="additions" id="additions"
                                       placeholder="If you want ant additions state it here... e.g Birthday cake"></td>

                <td colspan="3"><input type="number" min="1" max="2"
                                       class="filter-input"
                                       name="numOfSeats"
                                       placeholder="Please Enter Number of People intend to come "
                                       id="NumberOfPeople"></td>
                <td colspan="2"><input style="width: 200px" type="submit" name="confirm" value="Confirm The Booking"
                                       class="button"><input type="hidden" value="<?= $hidden["pid"] ?>"
                                                             name="pid"><input type="hidden"
                                                                               value="<?= $hidden["cost"] ?>"
                                                                               name="cost"></td>

            </tr>

            </tbody>


        </table>

    </form>

</div>

</body>
</html>
