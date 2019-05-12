<?php
include 'layout.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "amjad";
?>



<!DOCTYPE html>
<html>

<link rel="stylesheet" href="css/register.css" type="text/css">

<head>
	<title>e-Account</title>
</head>
<body>


<div class="form">
    <form class="form1" action="" method="post">
        <h2 id="h"> E-Account</h2>
 <label>Username :</label> <input type="text" name="username" placeholder="Enter username" required=""  value="<?php echo(isset($_SESSION['username']) ? $_SESSION['username'] : ''); ?>"/>

  <?php if (isset($_SESSION['errore'])){ if( $_SESSION['errore'] == 1) echo "
  <sup style=" . "color:red;margin-left:180px;" . ";> invalid username , number of characters<br><span style="."margin-left:180px;" .">should be between 6-13</span></sup> ";
  elseif( $_SESSION['errore'] == 6)echo "<sup style=" . "color:red;margin-left:180px;" . ";> used username </sup>"; }
  ?>
  <br>

       <label>PASSWORD :</label> <input type="password" name="password" placeholder="Enter password" required=""/><br>
        <label>CONFIRM PASSWORD:</label> <input type="password" name="cpassword" placeholder="Confirm password"
                                                 required=""/><?php if (isset($_SESSION['errore'])){
                                                 	if( $_SESSION['errore'] == 2) echo "<sup style=" . "color:red;margin-left:180px;" . ";> passwords not same </sup>";
                                                 	 elseif ($_SESSION['errore'] == 3) echo "<sup style=" . "color:red;margin-left:180px;" . ";> invalid password , number of characters <span style="."margin-left:180px;" .">must be between 8-12</span>  </sup>";
                                                 	elseif ($_SESSION['errore'] == 4) echo "<sup style=" . "color:red;margin-left:180px;" . ";> invalid password , password should 
                                                 	<span style="."margin-left:180px;" .">start with uppercase character </span></sup>";
                                                 	elseif ($_SESSION['errore'] == 5) echo "<sup style=" . "color:red;margin-left:180px;" . ";> invalid password , password should end 
                                                 	
                                                 	<span style="."margin-left:180px;" .">with digit  </span> </sup>";
                                                 	} ?>
        <br>


        <button class="button" type="submit">Create Account
        </button>

       
    </form>
</div>



</body>
</html>


<?php

include 'registerValidation.php' ;
if (!empty($_POST)) {
		
    	$_SESSION['username'] = $_POST['username'] ;
 
    	$error = checkEAccount( $_POST['username'], $_POST['password'] ,  $_POST['cpassword'] ) ;

    if ($error != 0 ) {
    	 unset($_SESSION['added']);
    	 $_SESSION['errore'] = $error ; 
        header('Location: eAccount.php');
    }

    else {
    	$_SESSION['password'] = $_POST['password'] ;

    	if(firstEntry())
    			$_SESSION['id'] = 1000000000 ;
    			
    	else {
    		$_SESSION['id'] = findIdForCustomer() +1 ;
    	}	
    	 header('Location: registerConfirm.php');
    }

     

}


?>