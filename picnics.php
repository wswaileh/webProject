<?php

include 'layout.php';
include 'model.php';


?>

<div class="container">

    <form action="picnics.php" method="get">
        <table class="picnic-table">
            <thead>

            <tr>
                <td colspan="3"><input class="filter-input" id="filter-place" type="text" name="place"
                                       placeholder="Search for certain place..."></td>
                <td colspan="1"><input class="filter-input" id="filter-date" type="date" name="date"
                                       placeholder="Search for certain date..."></td>

                <td colspan="1"><input class="filter-input " id="filter-place" type="text" name="NumOfPages"
                                       placeholder="# of records per page To display"></td>
                <td colspan="1"><input class="button" id="filter-submit" type="submit" value="Filter" name="filter"
                    ></td>
            </tr>
            <tr>
                <th>Picnic Reference ID</th>
                <th>Place</th>
                <th>Date</th>
                <th>Description</th>
                <th>Cost per one</th>

                <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 3) { ?>
                    <th>Capacity</th>

                <?php } else { ?>
                    <th></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>

            <?php
            $res = null;


            $rowsNum = 0;


            $page = 0;
            if (!isset($_GET['page'])) {
                $page = 1;
                $_GET['page'] = 1;
            } else {
                $page = $_GET['page'];
            }


            if (isset($_GET['NumOfPages']))
                $_SESSION['NumOfPages'] = $_GET['NumOfPages'];


            if (isset($_SESSION['NumOfPages']) && !empty($_SESSION['NumOfPages']))
                $RecordsPerPage = $_SESSION['NumOfPages'];
            else
                $RecordsPerPage = 10;


            if (isset($_GET['page']))
                $start_limit = ($_GET['page'] - 1) * $RecordsPerPage;


            //Filtration Side
            if (!isset($_GET['filter']) || (isset($_GET['filter']) && isset($_GET['NumOfPages']) && empty($_GET['place']) && empty($_GET['date']))) {
                $res = getPinicsForTable($start_limit, $RecordsPerPage);
                if ($row = getRowNum()->fetch())
                    $rowsNum = $row[0];
            } else {

                $res = getPinicsForTableWithFilter($_GET['place'], $_GET['date'], $start_limit, $RecordsPerPage);

                $row = getRowNumFiltered($_GET['place'], $_GET['date']);
                if (!is_numeric($row))
                    if ($row = $row->fetch())
                        $rowsNum = $row[0];
                    else
                        $rowsNum = 0;


            }

            $cidResult = getCustomerIdByEmail($_SESSION['email']);
            $cid = 0;

            if ($i = $cidResult->fetch()) {
                $cid = $i['cid'];
            }

            $subRes = getCustomerBooks($cid);
            $pids = array();

            while ($i = $subRes->fetch()) {
                $pids[] = $i['pid'];
            }
            $k = 0;

            $pages = ceil($rowsNum / $RecordsPerPage);


            $keys = ["pid", "place", "date", "description", "cost"];

            if ($res != null)
                $row = $res->fetch();
            if (!isset($row) || empty($row))
            echo "<tr><td colspan='6'>No Matches Found!</td></tr>";
            else
            while ($row) {

            if (!in_array($row['pid'], $pids)){

            ?>

            <tr><?php
                $desc = array();
                foreach ($keys as $i) {

                    $bookers = 0;
                    $capacity = 0;


                    $result = getPicnicsCapacity($row['pid']);

                    if ($Row = $result->fetch()) {
                        $capacity = $Row['capacity'];
                    }

                    $result = trackPicnicsCapacity($row['pid']);

                    if ($Row = $result->fetch()) {
                        $bookers = $Row['0'];
                    }

                    if (!is_numeric($bookers)) {
                        $bookers = 0;
                    }

                    if ($capacity != $bookers) {
                        if ($row[$i] == "description") {
                            $desc = explode(',', $row[$i]);
                            $row[$i] = $desc[0];
                        }
                        if ($i == "pid") {
                            echo "<td class='pid' style='padding-left: 80px;font-size: 1.4pc'><a href='detailed.php?id=" . $row[$i] . "' style='text-decoration:none;'>" . $row[$i] . "</a></td>";
                        } else if ($i == "cost") {
                            ?>
                            <td style="padding-left: 80px"><?= $row[$i] ?> &#8362;</td><?php
                        } else { ?>
                            <td><?= $row[$i] ?></td><?php
                        }
                    }


                }


                if (isset($_SESSION['userType']) && $_SESSION['userType'] != 3) {

                    $seat = "";

                    ($capacity - $bookers) == 1 ? $seat = "Seat" : $seat = "Seats";

                    if (($capacity - $bookers) <= (ceil(.1 * $capacity)) && $bookers != $capacity) {
                        echo "<td><a href='booking.php?id=" . $row['pid'] . "' class='button' style='text-decoration:none;padding-top:5px'>Book Now</a> |<span style='color: red'>" . ($capacity - $bookers) . " " . $seat . " Left </span></td></tr>";
                    } else if ($capacity != $bookers)
                        echo "<td><a href='booking.php?id=" . $row['pid'] . "' class='button' style='text-decoration:none;padding-top:5px'>Book Now</a></td></tr>";
                } else {


                    if ($bookers != $capacity)
                        echo "<td style='padding-left: 20px'>" . $bookers . "/" . $capacity . "</td>";

                    else
                        echo "<td style='padding-left: 20px;color: red'>" . $bookers . "/" . $capacity . " FULL</td>";

                }

                }

                $row = $res->fetch();
                } ?>


            </tbody>


        </table>
    </form>
    <div class="pagination">
        <a href="#">&laquo;</a>
        <?php

        for ($page = 1; $page <= $pages; $page++) {
            if ($page == $_GET['page'])
                echo "<a href='picnics.php?page=" . $page . "'class='active'>" . $page . "</a>";

            else
                echo "<a href='picnics.php?page=" . $page . "'>" . $page . "</a>";

        }
        ?>

        <a href="#">&raquo;</a>

    </div>
</div>

</body>
</html>



