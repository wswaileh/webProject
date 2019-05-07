<?php
include 'layout.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css" type="text/css">
</head>
<body>

<div class="form">
    <form class="form1" action="" method="post">
        <h2 id="h"> register Form</h2>
        <label> NAME :</label> <input type="text" name="name" placeholder="Enter your name" required=""
                                      value="<?php echo(isset($_GET['name']) ? $_GET['name'] : ''); ?>"/><br>

        <label>EMAIL :</label> <input type="email" name="email" placeholder="Enter Email Address" required=""
                                      value="<?php echo(isset($_GET['email']) ? $_GET['email'] : ''); ?>"/><?php if (isset($_GET['error']) && $_GET['error'] == 1) echo "<sup style=" . "color:red;margin-left:180px;" . ";> email already exist </sup>"; ?>
        <br>

        <label>PHONE :</label><input type="text" name="phone" placeholder="Enter your phone" required=""
                                     value="<?php echo(isset($_GET['phone']) ? $_GET['phone'] : ''); ?>"/><br>

        <label>PASSWORD :</label> <input type="password" name="password" placeholder="Enter password" required=""/><br>
        <label>CONFIRM PASSWORD :</label> <input type="password" name="cpassword" placeholder="Confirm password"
                                                 required=""/><?php if (isset($_GET['error']) && $_GET['error'] == 2) echo "<sup style=" . "color:red;margin-left:180px;" . ";> passwords not same </sup>"; ?>
        <br>

        <label>Address :</label> <input type="text" name="address" placeholder="Enter your address" required=""
                                        value="<?php echo(isset($_GET['address']) ? $_GET['address'] : ''); ?>"/><br>

        <label>DOB :</label><input type="date" name="dob" placeholder="Enter birth of date" required=""
                                   value="<?php echo(isset($_GET['dob']) ? $_GET['dob'] : ''); ?>"/><br>
        <button class="button" type="submit">Register
        </button><?php if (isset($_GET['added'])) echo "<br><br><p style=" . "color:green;margin-left:180px;" . ";>Registered Successfully!</p>";
        elseif (isset($_GET['wrong'])) echo "<br><br><p style=" . "color:red;margin-left:180px;" . ";>Error 402</p>"; ?>
    </form>
</div>


</body>
</html>


<?php
include 'model.php';
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if ($_POST['password'] != $_POST['cpassword']) {
        header('Location: register.php?error=2&name=' . $_POST['name'] . '&email=' . $_POST['email'] . '&phone=' . $_POST['phone'] . '&address=' . $_POST['address'] . '&dob=' . $_POST['dob']);
    } elseif (checkEmail($_POST['email']) > 0) {
        header('Location: register.php?error=1&name=' . $_POST['name'] . '&email=' . $_POST['email'] . '&phone=' . $_POST['phone'] . '&address=' . $_POST['address'] . '&dob=' . $_POST['dob']);
    } elseif (addUser($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['adress'], $_POST['dob']) == 1)
        header('Location: register.php?added=1');

    else  header('Location: register.php?wrong=1&name=' . $_POST['name'] . '&email=' . $_POST['email'] . '&phone=' . $_POST['phone'] . '&address=' . $_POST['address'] . '&dob=' . $_POST['dob'] . '');


    #echo "<script type= 'text/javascript'>alert('wronge email or password');</script>";
}


?>
