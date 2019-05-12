<?php
if (!isset($_SESSION)){
    session_name("name");
    session_start();
}

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>LafLef</title>
        <link rel="stylesheet" href="css/mainStylesheet.css" type="text/css">
        <link rel="stylesheet" href="css/navstyle.css" type="text/css">
        <link rel="stylesheet" href="css/footerStyle.css" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
              integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
              crossorigin="anonymous">

    </head>
    <body>
    <div style="position: relative; min-height: 100vh">
        <?php require 'navbar.php' ?>
        <div style="  padding-bottom: 2.5rem;    /* Footer height */">
