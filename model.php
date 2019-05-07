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

function addUser($name, $email, $phone, $password, $address, $dob)
{

    global $pdo;
    $sql = "INSERT INTO customers (name, email, phone ,password,address,DOB)
VALUES ('" . $name . "','" . $email . "','" . $phone . "','" . $password . "','" . $address . "','" . $dob . "')";

    if ($pdo->exec($sql) === false) {
        return 0;
    } else return 1;
}
