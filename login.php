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
      <label>Email : </label><input type="email" name="email" value="<?php echo (isset($_GET['email']) ? $_GET['email'] : ''); ?>" 
      placeholder="Email Address"  required="" /><?php if(!isset($_GET['password']) && isset($_GET['email']))echo "<sup style="."color:red;margin-left:125px;".";> email doesn't exist </sup>"; ?><br><br>
      <label>Password :</label><input type="password" name="password" placeholder="Password" required="" /> <?php if((isset($_GET['password']))) echo "<sup style="."color:red;margin-left:125px;"."> wrong password </sup>"; ?>

    

<br><br>
      <button class="button" type="submit">Login</button>   
    </form>
  </div>



 </body>
 </html>
 

 <?php
	include 'model.php';
	
if(!empty($_POST)) {

		if(checkEmail($_POST['email']) == 0){
			header("Location:login.php?email=".$_POST['email']);
		}

		elseif(checkManger($_POST['email'],$_POST['password']) > 0 ){
 			$_SESSION['userType'] = 3 ;
 			header("Location:main.php"); 
		}
		elseif(checkCustomer($_POST['email'],$_POST['password'])> 0 ){
 			$_SESSION['userType'] = 2 ;
 			header("Location:main.php"); 
		}
		else header("Location:login.php?password&email=".$_POST['email']); ;
			 
				
	}

			
		
?>

