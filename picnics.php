<?php

include 'layout.php';
include 'model.php';


?>

<div class="container">

    <form action="picnics.php" method="get" id="picnic-search">
        <table class="picnic-table" id="table">
            <thead>

            <tr>
                <td colspan="3"><input class="filter-input" id="filter-place" type="text" name="place"
                                       placeholder="Search for certain place..." onkeyup="myFunction()"
                                       pattern="[A-Za-z]*">

                </td>

                <td colspan="1"><input class="filter-input" id="filter-date" type="date" name="date"
                                       placeholder="Search for certain date..."></td>

                <td colspan="1"><input class="filter-input " id="filter-place" type="number" name="NumOfPages"
                                       placeholder="# of records per page To display"></td>
                <td colspan="1"><input class="button" id="filter-submit" type="submit" value="Filter" name="filter"
                    ></td>
            </tr>
            <script type="text/javascript">

                function myFunction() {

                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("filter-place");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("table");
                    tr = table.getElementsByTagName("tr");

                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[1];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                if (i != 0)
                                    tr[i].style.display = "none";
                            }
                        }
                    }
                }

            </script>
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

            $pids = array();
            if (isset($_SESSION['email'])) {
                $cidResult = getCustomerIdByEmail($_SESSION['email']);
                $cid = 0;

                if ($i = $cidResult->fetch()) {
                    $cid = $i['cid'];
                }

                $subRes = getCustomerBooks($cid);


                while ($i = $subRes->fetch()) {
                    $pids[] = $i['pid'];
                }

            }

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

                    if ($capacity != $bookers || $_SESSION['userType'] == 3) {
                        if ($i == "description") {

                            $desc = explode(',', $row[$i]);
                            $row[$i] = $desc[0];

                        }
                        if ($i == "pid") {
                            echo "<td class='pid' style='padding-left: 80px;font-size: 1.4pc'><button  type='button' class='picnic-pid' id='link-" . $row[$i] . "'  onclick=' display(" . $row[$i] . ");'>" . $row[$i] . "</button></td>";

                            ?>

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

                                            <strong>Departure Time: </strong><strong>Arrival Time</strong><strong>Return
                                                Time</strong>
                                            <i><?= $Details['departuretime'] ?></i>
                                            <i><?= $Details['arrivaltime'] ?></i> <i><?= $Details['returntime'] ?></i>

                                        </div>

                                        <div class="details-desc">
                                            <ul>
                                                <dl>
                                                    <li><strong><?= $Details['title'] ?></strong></li>

                                                    <li>
                                                        <dt><strong>Food</strong></dt>
                                                        <dd><?= $Details['food'] ?></dd>
                                                    </li>

                                                    <li>
                                                        <dt><strong>Activities</strong></dt>
                                                        <dd><?= $Details['activities'] ?></dd>
                                                    </li>
                                                </dl>
                                            </ul>

                                            <p><strong>Description: </strong><br><?= $row['description'] ?></p>
                                        </div>
                                        <strong style="padding: 30px">Photos Related: </strong><br>
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
                                            <strong>Links Related To the picnic's Place:</strong><br>
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
                } else if ($_SESSION['userType'] == 3) {


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

    <script src="javascript/main.js"></script>
</div>

<?php require 'footer.php' ?>


