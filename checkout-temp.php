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


        $isExsistCredit = getCreditByNum($_POST['card-num'])->fetch() == null ? true : false;

        if ($isExsistCredit)
            addCredit($card[0], $_POST['card-num'], $_POST['expire-date'], $_POST['bank']);
    }


    if (isset($_POST['pid']) && isset($_POST['additions']) && isset($_POST['date']) && isset($_POST['invoice']) && isset($_POST['seats'])) {

        $res = getCreditId();

        $rid = 0;


        if ($row = $res->fetch()) {
            $rid = $row[0];

        }

        book($_POST['pid'], $cid, $_POST['date'], $rid, $_POST['additions'], $_POST['invoice'], $_POST['seats']);

        $bid = getBooksId();


        if ($row = $bid->fetch()) {
            $bid = $row[0];
        }


        ?>

        <form method="post" action="checkout-temp.php" id="invoice-form">
            <input type="hidden" name="numOfSeats" value="<?= $_POST['seats'] ?>">
            <input type="hidden" name="pid" value="<?= $_POST['pid'] ?>">
            <input type="hidden" name="costPerOne" value="<?= $_POST['cost'] ?>">
            <input type="hidden" name="additions" value="<?= $_POST['additions'] ?>">
            <input type="hidden" name="total" value="<?= $_POST['invoice'] ?>">
            <input type="hidden" name="bid" value="<?= $bid ?>">
        </form>
        <?php
    }
}


if (!isset($_POST['total'])) {
    echo "<script type='text/javascript'>";
    echo "alert('Booked Successfully, looking forward to see you. LefLef Team" . date('Y') . " ');";
    echo "document.getElementById('invoice-form').submit();";
    echo "</script>";

} else {

    $res = getCustomerIdByEmail($_SESSION['email']);
    $name = "";

    $Rid = getRidByBid($_POST['bid']);

    $rid = 0;

    if ($row = $Rid->fetch()) {
        $rid = $row['rid'];
    }

    $creditname = getCreditById($rid);
    $creditName = "";

    $cardNum = "";
    if ($row = $creditname->fetch()) {
        $creditName = $row['name'];
        $cardNum = substr($row['num'], 0, -6);
    }


    if ($row = $res->fetch()) {
        $name = $row['name'];

    }
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>A simple, clean, and responsive HTML invoice template</title>

        <style>
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 30px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                font-size: 16px;
                line-height: 24px;
                font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }

            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.item td {
                border-bottom: 1px solid #eee;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }
        </style>
    </head>

    <body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="img/icons/logo.jpg"
                                     style="width:100%; max-width:300px; max-height: 150px">
                            </td>

                            <td>
                                Invoice #: <strong><?= $_POST['bid'] ?></strong><br>
                                Created: <?= date("Y-F-d") ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Laflef, inc.<br>
                                Birzzeit main-st<br>
                                Ramallah, Palestine
                            </td>

                            <td>
                                <?= $name ?><br>
                                <?= $_SESSION['email'] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Payment Method
                </td>

                <td>
                    Number #
                </td>
            </tr>

            <tr class="details">
                <td>
                    <?= $creditName ?>
                </td>

                <td>
                    <?= $cardNum ?>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Item
                </td>

                <td>
                    Price
                </td>
            </tr>

            <tr class="item">
                <td>
                    Cost per one
                </td>

                <td>
                    <?= $_POST['costPerOne'] ?> &#8362;
                </td>
            </tr>

            <tr class="item">
                <td>
                    Quantity(num of Seats)
                </td>

                <td>
                    <?= $_POST['numOfSeats'] ?>
                </td>
            </tr>

            <tr class="item last">
                <td>
                    Additions
                </td>

                <td>
                    <?php echo $_POST['additions'];
                    if (strpos($_POST['additions'], "Birthday-Cake") !== false) {
                        echo "<br><small>20 Nis for each</small>";
                    }
                    ?>

                </td>
            </tr>

            <tr class="total">
                <td></td>

                <td>
                    Total: <?= $_POST['total'] ?> &#8362;
                </td>
            </tr>
        </table>
    </div>
    </body>
    </html>


    <?php


}

