<?php

include 'layout.php';
include 'model.php';

?>
    <nav><a href="main.php">Main</a></nav>

    <form method="post" action="booking.php">
        <input type="submit" name="submit" value="Display">
    </form>

<?php


if (isset($_POST['submit'])) {
    $res = getbookings();
    $val = array();
    ?>
    <table>
        <thead>
        <?php foreach ($row = $res->fetch() as $key => $value) {
            ?>
            <th><?= $key ?></th>

            <?php $val[$key] = $value;
        } ?>
        </thead>

        <tbody>
        <?php

        foreach ($val as $i) {
            ?>
            <td><?= $val[$i] ?></td><?php
        }

        ?>
        </tbody>
    </table>
<?php }

