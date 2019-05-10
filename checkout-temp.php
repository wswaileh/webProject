<?php
include 'model.php';
session_name("name");
session_start();
if (isset($_POST['checkout'])) {
    $email = "";
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    }


    $res = getCustomerIdByEmail($email);


    $cid = 0;
    if ($row = $res->fetch()) {
        $cid = $row['cid'];
    }

    if (isset($_POST['card-num']) && isset($_POST['bank']) && isset($_POST['expire-date']) && isset($_POST['card-name'])) {

        $card = explode("/", $_POST['card-name']);
        $_POST['card-num'] = $card[1] . $_POST['card-num'];

        addCredit($card[0], $_POST['card-num'], $_POST['expire-date'], $_POST['bank']);
    }


    if (isset($_POST['pid']) && isset($_POST['additions']) && isset($_POST['date']) && isset($_POST['invoice']) && isset($_POST['seats'])) {

        $res = getCreditId();

        $rid = 0;



        if ($row = $res->fetch()) {
            $rid = $row[0];
            print $rid;
        }

        book($_POST['pid'], $cid, $_POST['date'], $rid, $_POST['additions'], $_POST['invoice'], $_POST['seats']);

        echo "<script type='text/javascript'>";
        echo "alert('Booked Successfully, looking forward to see you. LefLef Team ');";
        echo "window.close()";
        echo "</script>";
    }


}

