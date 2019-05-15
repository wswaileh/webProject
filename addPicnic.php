<?php
include 'layout.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['userType']) && $_SESSION['userType'] != 3) {
    header("location:main.php");
}


?>


    <html>
    <head>
        <title>Add picnic</title>
        <script src="ckeditor/ckeditor.js"></script>

        <link rel="stylesheet" href="css/addpicnic.css" type="text/css">


    </head>
    <body>

    <div id="container">
        <div class="form">
            <h2 id="h"> Add Picnic</h2>
            <form action="#" method="POST" enctype="multipart/form-data">

                <label>Title : </label><input type="text" name="title"
                                              placeholder="Picnic Ttile" required=""
                                              value="<?php isset($_SESSION['title']) ? print $_SESSION['title'] : ''; ?>"/>

                <label>Place :</label><input type="text" name="place" placeholder="Picnic Place" required=""
                                             value="<?php isset($_SESSION['place']) ? print $_SESSION['place'] : ''; ?>"/>

                <label>Price: </label><input type="number" name="price"
                                             placeholder="Cost Per Person" step="any" min="0" max="1000" required=""
                                             value="<?php isset($_SESSION['price']) ? print $_SESSION['price'] : ''; ?>"/>


                <label>capacity : </label><input type="number" name="capacity"
                                                 placeholder="Picnic Capacity" step="1" min="20" max="50" required=""
                                                 value="<?php isset($_SESSION['capacity']) ? print $_SESSION['capacity'] : ''; ?>"/>


                <label>Food : </label><textarea name="food"
                                                placeholder="Picnic Food" required="" rows="3"
                                                cols="64"><?php isset($_SESSION['food']) ? print $_SESSION['food'] : ''; ?></textarea>

                <label>Departual place : </label><input type="text" name="departurelocation"
                                                        placeholder="Picnic Departual place" required=""
                                                        value="<?php isset($_SESSION['departurelocation']) ? print $_SESSION['departurelocation'] : ''; ?>"/>

                <label>Departual time : </label><input type="time" name="departuretime"
                                                       placeholder="Picnic Departual time" required=""
                                                       value="<?php isset($_SESSION['departuretime']) ? print $_SESSION['departuretime'] : ''; ?>"/>

                <label>arrival time : </label><input type="time" name="arrivaltime"
                                                     placeholder="Picnic arrival time" required=""
                                                     value="<?php isset($_SESSION['arrivaltime']) ? print $_SESSION['arrivaltime'] : ''; ?>"/>

                <label>return time : </label><input type="time" name="returntime"
                                                    placeholder="Picnic return time" required=""
                                                    value="<?php isset($_SESSION['returntime']) ? print $_SESSION['returntime'] : ''; ?>"/>

                <sup style="color: red;display: none;padding-left: 20px" id="time">Departure-Time must be before
                    Arrival-Time and before
                    Return-Time </sup>

                <label>Date : </label><input type="date" name="date"
                                             placeholder="Picnic  Date" required=""
                                             value="<?php isset($_SESSION['date']) ? print $_SESSION['date'] : ''; ?>"/>
                <sup style="color: red;display: none;padding-left: 20px" id="date">Date must be valid... e.g select Date
                    that comes after
                    today! </sup>

                <label>image1 : </label><input type="file" name="image1"
                                               value="<?php isset($_SESSION['image1']) ? print $_SESSION['image1'] : ''; ?>"
                                               accept="image/jpeg"/>
                <label>image2 : </label><input type="file" name="image2"
                                               value="<?php isset($_SESSION['image1']) ? print $_SESSION['image1'] : ''; ?>"
                                               accept="image/jpeg"/>
                <label>image3 : </label><input type="file" name="image3"
                                               value="<?php isset($_SESSION['image3']) ? print $_SESSION['image3'] : ''; ?>"
                                               accept="image/jpeg"/>

                <label>Escorts : </label><input type="text" name="escorts"
                                              placeholder="Picnics's Escort" required=""
                                              value="<?php isset($_SESSION['escorts']) ? print $_SESSION['escorts'] : ''; ?>"pattern="[a-z]*"/>

                <label>Escort Tel. :</label><input type="tel" name="escorttel" placeholder="Escort Tel." required=""
                                             value="<?php isset($_SESSION['tel']) ? print $_SESSION['tel'] : ''; ?>" pattern="[0-9]{10}"/>


                <label>Activities : </label><textarea name="activities"
                                                      placeholder="Picnic Activities" required="" rows="3"
                                                      cols="64"
                                                      class="card__img"><?php isset($_SESSION['activities']) ? print $_SESSION['activities'] : ''; ?></textarea>


                <textarea name="description" class="description" placeholder="Picnic Description"
                          required=""><?php isset($_SESSION['description']) ? print $_SESSION['description'] : ''; ?></textarea>

                <label class="description-label" id="description-label"
                       onclick="document.getElementById('description-label').style.visibility='hidden';">Picnic
                    Description</label>
                <input type="Submit" name="Submit" value="Submit" id="submit"/>
            </form>
        </div>


        <div class="left-sidebar" id="left-sidebar">

            <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
            <a href="picnics.php" class="fas fa-thumbtack"> Latest Picnics</a>
            <a href="news.php" class="fas fa-newspaper"> News</a>
            <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 2) { ?>
                <a href="#" class="fas fa-shopping-cart" id="openCart"> Cart <span id="openCart-span" class="fas fa-sort-down" style="float: right"></span></a>
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

            document.getElementById('openCart').addEventListener('click' ,function (event) {
                event.preventDefault();

                openAndCloseCart();

            })
        </script>
    <script>
        CKEDITOR.replace('description', {
            extraPlugins: 'placeholder',
            height: 220
        });

        document.getElementById('close-sidebar').addEventListener('click', function (event) {
            event.preventDefault();
            closeSlidMenu();
        });
    </script>

    </body>
    </html>


<?php


include 'model.php';


if (!empty($_POST)) {


    if (strtotime($_POST['date']) < strtotime("today")) {

        echo "<script>alert('Date must be valid... e.g select Date that comes after today!')</script>";

        if (strtotime($_POST['departuretime']) > strtotime($_POST['returntime']) || strtotime($_POST['departuretime']) > strtotime($_POST['arrivaltime']) || strtotime($_POST['arrivaltime']) > strtotime($_POST['returntime'])) {
            echo "<script>alert('Departure-Time must be before Arrival-Time and before Return-Time')</script>";
        }

        foreach ($_POST as $key => $value) {
            $_SESSION[$key] = $value;
        }


    } else if (strtotime($_POST['departuretime']) > strtotime($_POST['returntime']) || strtotime($_POST['departuretime']) > strtotime($_POST['arrivaltime']) || strtotime($_POST['arrivaltime']) > strtotime($_POST['returntime'])) {


        echo "<script>alert('Departure-Time must be before Arrival-Time and before Return-Time')</script>";

        foreach ($_POST as $key => $value) {
            $_SESSION[$key] = $value;
        }


    } else {


        $add = addPicnic($_POST['title'], $_POST['place'], $_POST['price'], $_POST['capacity'], $_POST['description'], $_POST['food'], $_POST['departurelocation'], $_POST['departuretime'], $_POST['arrivaltime'], $_POST['returntime'], $_POST['date'], $_POST['activities'],$_POST['escorts'],$_POST['escorttel']);

        if ($add == 1) {

            foreach ($_POST as $key => $value) {
                unset($_SESSION[$key]);
            }

############################################################upload images

            $id = getIdForLastPicnic();

            $img = [$id . "_1", $id . "_2", $id . "_3"];
            $imgStr = implode(';', $img);

            $target_file = 'img/picnics/' . $id . "_1" . "." . pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["image1"]["tmp_name"], $target_file);


            $target_file = 'img/picnics/' . $id . "_2" . "." . pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["image2"]["tmp_name"], $target_file);


            $target_file = 'img/picnics/' . $id . "_3" . "." . pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["image3"]["tmp_name"], $target_file);


            addImagesToPicnic($id, $imgStr);

####################################################################

            echo "<script type='text/javascript'>alert('Picnic Added Successfully!');window.location.replace('picnics.php');</script>";

        }

    }

}
?>