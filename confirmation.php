<?php
include 'model.php';
?>
<html>
<head>
    <link rel="stylesheet" href="css/mainStylesheet.css" type="text/css">
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

            <td colspan="9"></td>
        </tr>

        </tbody>

    </table>

    <div class="pricing">
        <div class="[ price-option price-option--low ]">
            <div class="price-option__detail">
                <span class="price-option__cost"> <?php
                    if (isset($_POST['cost']) && isset($_POST['Birthday_cake']) && isset($_POST['cakeNum']) && isset($_POST['numOfSeats'])) {
                        echo ($_POST['cost'] * $_POST['numOfSeats']) + ($_POST['cakeNum'] * 20) . "&#8362;";
                    } else if (isset($_POST['cost'])) {
                        echo ($_POST['cost'] * $_POST['numOfSeats']) . "&#8362;";
                    }
                    ?></span>
                <span class="price-option__type">Total Cost</span>
            </div>
            <a href="#" class="price-option__purchase">Confirm</a>
        </div>
    </div>
</div>
</body>


</html>
