<?php
include 'layout.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['new'])){session_destroy() ;
	 header('Location: login.php');
	}

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
      <h2 id="h"> login Form</h2>
      <label>Email : </label><input type="email" name="email" value="<?php echo (isset($_SESSION['email']) ? $_SESSION['email'] : ''); ?>" 
      placeholder="Email Address"  required="" /><?php if(isset($_SESSION['wrong']) && $_SESSION['wrong']==1) echo "<sup style="."color:red;margin-left:125px;".";> email doesn't exist </sup>"; ?><br><br>
      <label>Password :</label><input type="password" name="password" placeholder="Password" required="" /> <?php if((isset($_SESSION['wrong'])) && $_SESSION['wrong'] == 2 ) echo "<sup style="."color:red;margin-left:125px;"."> wrong password </sup>"; ?>


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
			$_SESSION['wrong'] = 1 ;
			$_SESSION['email'] = $_POST['email'];
			header("Location:login.php");
		}

		elseif(checkManger($_POST['email'],$_POST['password']) > 0 ){
 			$_SESSION['userType'] = 3 ;
 			header("Location:main.php"); 
		}
		elseif(checkCustomer($_POST['email'],$_POST['password'])> 0 ){
 			$_SESSION['userType'] = 2 ;
            $_SESSION['email'] = $_POST['email'];
 			header("Location:main.php"); 
		}
		else {
			$_SESSION['wrong'] = 2;
			$_SESSION['email'] = $_POST['email']; 
			header("Location:login.php?"); 
			 }
				
	}

			
		
?>

