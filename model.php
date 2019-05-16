<?php

$server = "localhost";
$username = "c28MustafaB3irat";
$password = "mus%^&4545";
$dbname = "c28LaflefBzu";
$conn = "mysql:host=$server;dbname=$dbname";

$pdo = null;
try {
    $pdo = new PDO($conn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}


function getmanagers()
{
    global $pdo;

    return $pdo->query("select * from manager");
}

function getCustomerIdByEmail($email)
{

    global $pdo;

    return $pdo->query("select * from customers where email = '" . $email . "';");
}

function getcustomers()
{
    global $pdo;

    return $pdo->query("select * from customers");
}

function getpicnicsDetails($pid)
{
    global $pdo;

    return $pdo->query("select title,food, DATE_FORMAT(departuretime, '%r') as departuretime ,DATE_FORMAT(returntime, '%r') as returntime,DATE_FORMAT(arrivaltime, '%r') as arrivaltime , departurelocation , activities , images , escorts , escorttel from picnic where pid = " . $pid);
}

function getPinicsForTable($start_limit, $records, $userType)
{
    global $pdo;

    if ($userType != 3) {

        return $pdo->query("select a.pid , a.place,a.date,a.description,a.cost from picnic as a where a.pid not in (select b.pid from book as b having (select sum(pnum) from book as c where a.pid =c.pid) = a.capacity) and a.date > CURRENT_DATE limit " . $start_limit . ", " . $records . ";");

    } else {
        return $pdo->query("select a.pid , a.place,a.date,a.description,a.cost from picnic as a limit " . $start_limit . ", " . $records . ";");
    }
}


function getPinicsForTableWithFilter($place, $date, $start_limit, $records, $userType)
{
    global $pdo;
    $inp = ["place" => $place, "date" => $date];

    $query = "";
    if ($userType != 3) {
        $query = "select a.pid , a.place,a.date,a.description,a.cost from picnic as a where a.pid not in (select b.pid from book as b having (select sum(pnum) from book as c where a.pid =c.pid) = a.capacity) and a.date > CURRENT_DATE and ";
    } else {
        $query = "select a.pid , a.place,a.date,a.description,a.cost from picnic as a where a.pid where ";
    }
    foreach ($inp as $i => $value) {
        if (isset($value) && !empty($value)) {

            if ($i == "place") {
                $query .= $i . " like '" . $value . "%'";
            } else {
                $query .= $i . " = '" . $value . "'";
            }
        }
    }

    return $res = $pdo->query($query . " limit " . $start_limit . ", " . $records . ";");
}


function getRowNum($userType)
{
    global $pdo;

    if ($userType != 3) {

        return $pdo->query("select count(*) from picnic as a  where a.pid not in (select b.pid from book as b having   (select sum(pnum) from book as c where a.pid =c.pid) = a.capacity) and a.date > CURRENT_DATE");
    } else {
        return $pdo->query("select count(*) from picnic");
    }
}


function getRowNumFiltered($place, $date, $userType)
{

    global $pdo;
    $query = "select count(*) from picnic as a";
    $inp = ["place" => $place, "date" => $date];
    $res = 0;
    foreach ($inp as $i => $value) {
        if (isset($value) && !empty($value) && $userType != 3)
            $res = $pdo->query($query . " where a.pid not in (select b.pid from book as b having   (select sum(pnum) from book as c where a.pid =c.pid) = a.capacity) and a.date > CURRENT_DATE and " . $i . " = '" . $value . "';");
        else if (isset($value) && !empty($value) && $userType == 3)
            $res = $pdo->query($query . " where  " . $i . " = '" . $value . "';");

    }


    return $res;
}


function getPicnicById($pid)
{

    global $pdo;

    return $pdo->query("select pid , place , date , description , cost , departuretime , departurelocation , arrivaltime , returntime from picnic where pid = " . $pid . ";");
}


function getPicnics()
{

    global $pdo;

    return $pdo->query("select pid,images,title from picnic");
}

function getPicnicsNum()
{

    global $pdo;

    return $pdo->query("select COUNT(*) from picnic");
}


function getbookings()
{
    global $pdo;

    return $pdo->query("select * from book");
}


function getSchedual()
{
    global $pdo;

    return $pdo->query("select * from scheduledby");
}


//Customers : login and register

function checkCustomer($email, $password)
{
    global $pdo;
    $res = $pdo->query("select count(*) from customers where email = '" . $email . "' and password = '" . $password . "'");

    return $res->fetchColumn();
}

function checkManger($email, $password)
{
    global $pdo;
    $res = $pdo->query("select count(*) from manager where email = '" . $email . "' and password = '" . $password . "'");

    return $res->fetchColumn();
}

function checkEmail($email)
{
    global $pdo;
    $res = $pdo->query("select count(*) from manager where email = '" . $email . "'");

    $count1 = $res->fetchColumn();

    $res = $pdo->query("select count(*) from customers where email = '" . $email . "'");

    $count2 = $res->fetchColumn();

    return ($count2 > $count1) ? $count2 : $count1;
}

function addUser($name, $email, $username, $phone, $password, $address, $dob, $id)
{
    global $pdo;
    $sql = "INSERT INTO customers (cid , name, email,username, phone ,password,address,DOB)
VALUES (" . $id . ",'" . $name . "','" . $email . "','" . $username . "','" . $phone . "','" . $password . "','" . $address . "','" . $dob . "')";

    if ($pdo->exec($sql) === false) {
        return 0;
    } else return 1;
}


function checkId($id)
{
    global $pdo;
    $res = $pdo->query("select count(*) from customers where cid = '" . $id . "'");

    $count1 = $res->fetchColumn();
    return $count1;
}

function checkUsername($username)
{
    global $pdo;
    $res = $pdo->query("select count(*) from customers where username = '" . $username . "'");

    $count1 = $res->fetchColumn();

    return $count1;
}

function firstEntry()
{
    global $pdo;
    $res = $pdo->query("select count(*) from customers");

    $count1 = $res->fetchColumn();

    return ($count1 == 0);
}

function findIdForCustomer()
{

    global $pdo;
    $res = $pdo->query("SELECT MAX(cid) FROM customers");

    $id = $res->fetchColumn();

    return $id;

}

function addCredit($name, $num, $date, $bank)
{

    global $pdo;
    $sql = "INSERT INTO credit (name, num,expiredate, bank)
VALUES ('" . $name . "'," . $num . ",'" . $date . "','" . $bank . "')";

    if ($pdo->exec($sql) === false) {
        return 0;
    } else return 1;

}


function getCreditById($id)
{
    global $pdo;

    return $pdo->query("select  * from credit where rid = " . $id);
}


function getCreditByNum($num)
{

    global $pdo;

    $sql = "select rid from credit where num = " . $num . ";";

    return $pdo->query($sql);
}

function getCreditId()
{

    global $pdo;

    $sql = "select max(rid) from credit";

    return $pdo->query($sql);
}

function book($pid, $cid, $date, $rid, $additions, $invoice, $pnum)
{
    global $pdo;
    $sql = "INSERT INTO book (pid, cid,date , rid , additions , invoice , pnum)
VALUES (" . $pid . "," . $cid . ",'" . $date . "'," . $rid . ", '" . $additions . "' , " . $invoice . " , " . $pnum . ")";

    if ($pdo->exec($sql) === false) {
        return 0;
    } else return 1;

}


function trackPicnicsCapacity($pid)
{
    global $pdo;

    return $pdo->query("select sum(pnum) total_bookers from book where pid = " . $pid);
}

function getPicnicsCapacity($pid)
{
    global $pdo;
    return $pdo->query("select capacity from picnic where pid = " . $pid);
}

function getBooksId()
{
    global $pdo;

    return $pdo->query("select max(bid) from book");
}

function getRidByBid($bid)
{

    global $pdo;

    return $pdo->query("select rid from book where bid =" . $bid);

}

function getCustomerBooks($cid)
{
    global $pdo;

    return $pdo->query("select pid from book where cid = " . $cid);
}

function addPicnic($title, $place, $price, $capacity, $description, $food, $departurelocation, $departuretime, $arrivaltime, $returntime, $date, $activities, $excorts, $escorttel)
{

    global $pdo;
    $sql = "INSERT INTO picnic (food, cost,capacity, description,returntime,arrivaltime,departuretime,date,departurelocation,place,activities , title,escorts,escorttel)
VALUES ('" . $food . "'," . $price . ",'" . $capacity . "','" . $description . "','" . $returntime . "','" . $arrivaltime . "','" . $departuretime . "','" . $date . "','" . $departurelocation . "','" . $place . "','" . $activities . "','" . $title . "','" . $excorts . "'," . $escorttel . ")";

    if ($pdo->exec($sql) === false) {
        return 0;
    } else return 1;

}

function getIdForLastPicnic()
{

    global $pdo;
    $res = $pdo->query("SELECT MAX(pid) FROM picnic");
    $id = $res->fetchColumn();

    return $id;

}

function addImagesToPicnic($id, $imgs)
{
    global $pdo;

    $sql = " UPDATE picnic set images = '" . $imgs . "' where pid = " . $id;


    if ($pdo->exec($sql) === false) {
        return 0;
    } else return 1;


}

/*              CONTACT US FUNCTIONS                 */
function insertMessage($name, $email, $message)
{
    global $pdo;
    $sql = "INSERT INTO messages (name,email,message) VALUES ('$name','$email','$message')";

    if ($pdo->exec($sql) === false)
        return 0;

    return 1;
}

function printMessages()
{
    global $pdo;
    $sql = "SELECT * FROM messages";
    $result = $pdo->query($sql);
    if ($result->rowCount() == 0)
        echo '<p>No Messages!</p>';
    else {
        echo "<div id='container' style='overflow-x:auto;'>
<h1>Contact Us Messages</h1>            
<table>
                <th><span class='fas fa-signature'></span> Name</th><th><span class='fas fa-envelope'></span> Email</th><th><span class='fas fa-edit'></span> Message</th>";
        while ($row = $result->fetch()) {
            echo "
            <tr>
                <td>" . $row['name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['message'] . "</td>
            </tr>
            ";
        }
        echo "</table></div></div>";


    }

}

function getPurchase($cid)
{
    global $pdo;

    return $pdo->query("select DISTINCT a.pid,a.title ,b.invoice from picnic as a ,book as b where  a.pid = b.pid and b.cid =" . $cid . " and a.pid in(SELECT c.pid from book as c where c.cid = " . $cid . ")");
}

function insertNews($mid, $text)
{
    global $pdo;

    $query = "insert into news (mid , news) values (" . $mid . " , '" . $text . "')";

    if ($pdo->exec($query)) {
        return 1;
    } else
        return 0;
}

function getNews()
{
    global $pdo;
    return $pdo->query("select * from news");
}

function getOwnerOfNew($id)
{
    global $pdo;

    return $pdo->query("select m.username from manager as m where m.mid in (SELECT n.mid from news as n where n.nid =" . $id . ")");
}

function getManagerIdByemail($email)
{
    global $pdo;
    return $pdo->query("select mid from manager where email ='" . $email . "'");
}

function checkIfBooked($pid, $cid)
{
    global $pdo;

    return $pdo->query("select COUNT(*) from customers as c WHERE c.cid=" . $cid . " and c.cid in(select b.cid from book as b where b.pid =" . $pid . ")");
}