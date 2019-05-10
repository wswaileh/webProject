<?php
include 'model.php';
function checkRegister($email)
{
    if (checkEmail($email) > 0)
        return 1;
    return 0;

}

function checkEAccount($username, $password, $cpassword)
{


    $passlen = strlen($password);
    $userlen = strlen($username);
    if ($userlen < 6 || $userlen > 13)
        return 1;

    if ($password != $cpassword)
        return 2;

    if ($passlen < 8 || $passlen > 12)
        return 3;


    if (!ctype_upper(substr($password, 0, 1)))
        return 4;

    if (!is_numeric(substr($password, -1)))
        return 5;

    if (checkUsername($username) > 0)
        return 6;

    return 0;

}

function finalCheck($email, $username)
{
    $userlen = strlen($username);
    if (checkEmail($email) > 0)
        return 1;

    if ($userlen < 6 || $userlen > 13)
        return 2;

    if (checkUsername($username) > 0)
        return 3;


    return 0;
}


