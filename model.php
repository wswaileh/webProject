<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "laflefbzu";
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

function getpicnics()
{
    global $pdo;

    return $pdo->query("select * from picnic");
}

function getPinicsForTable($start_limit, $records)
{
    global $pdo;

    return $pdo->query("select pid , place,date,description,cost from picnic limit " . $start_limit . ", " . $records . ";");
}


function getPinicsForTableWithFilter($place, $date, $start_limit, $records)
{
    global $pdo;
    $inp = ["place" => $place, "date" => $date];
    $res = "";
    foreach ($inp as $i => $value) {
        if (isset($value) && !empty($value))
            $res = $pdo->query("select pid , place,date,description,cost from picnic where " . $i . " = '" . $value . "' limit " . $start_limit . "," . $records . ";");
    }

    return $res;
}


function getRowNum()
{
    global $pdo;

    return $pdo->query("select count(*) from picnic");
}

function getRowNumFiltered($place, $date)
{

    global $pdo;
    $inp = ["place" => $place, "date" => $date];
    $res = 0;
    foreach ($inp as $i => $value) {
        if (isset($value) && !empty($value))
            $res = $pdo->query("select count(*) from picnic where " . $i . " = '" . $value . "';");
    }

    return $res;
}


function getPicnicById($pid)
{

    global $pdo;

    return $pdo->query("select pid , place , date , description , cost , departuretime , departurelocation , arrivaltime , returntime from picnic where pid = " . $pid . ";");
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