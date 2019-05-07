<?php
include 'layout.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
 <link rel="stylesheet" href="css/login.css" type="text/css">

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Login</title>
 </head>
 <body>

  <div class="form">
    <form class="form1" action="" method="post">       
      <h2 id="h">login</h2>
      <label>Email : </label>
        <input type="email" name="email" placeholder="Email Address"  required="" />
      <label>Password :</label>
        <input type="password" name="password" placeholder="Password" required="" />
        <?php
        if (isset($_SESSION['message']) and !empty($_SESSION['message']))
            echo "<p class='ErrorMsg'>".$_SESSION['message']."</p>";
        unset($_SESSION['message']);
        ?>
        <button class="button" type="submit">Login</button>
    </form>
  </div>


 </body>
 </html>
 

 <?php
	include 'model.php';
	
if($_SERVER['REQUEST_METHOD'] === "POST") {
    //Manager
    if (checkManger($_POST['email'], $_POST['password']) > 0) {
        $_SESSION['userType'] = 3;
        $_SESSION['email'] = $_POST['email'];
        if (isset( $_SESSION['pageCameFrom']) and !empty( $_SESSION['pageCameFrom']))
            header("Location:". $_SESSION['pageCameFrom']);
        else
            header("Location:main.php");
    } //Customer
    elseif (checkCustomer($_POST['email'], $_POST['password']) > 0) {
        $_SESSION['userType'] = 2;
        $_SESSION['email'] = $_POST['email'];
        if (isset( $_SESSION['pageCameFrom']) and !empty( $_SESSION['pageCameFrom']))
            header("Location:". $_SESSION['pageCameFrom']);
        else
            header("Location:main.php");
    } //Wrong Email / Password
    else{
        $_SESSION['message']="Please Check Email/Password.";
        header("Location:login.php");
    }

}
?>