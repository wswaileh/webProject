<?php
include 'layout.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	?>

 <link rel="stylesheet" href="css/addpicnic.css" type="text/css">



<html>
<head>
	<title>Add picnic</title>
</head>
<body>


<div class="form">
	 <h2 id="h"> Add Picnic</h2>
    <form action="#"" method="POST" enctype="multipart/form-data"">      

      <label>Title : </label><input type="text" name="title"
      placeholder="Picnic Ttile"  required="" />

      <label>Place :</label><input type="text" name="place" placeholder="Picnic Place" required="" />

      <label>Price: </label><input type="number" name="price"
      placeholder="Cost Per Person"  step="any" min="0" max="1000" required="" />	


       <label>capacity : </label><input type="number" name="capacity"
      placeholder="Picnic Capacity" step="1" min="20" max="50" required="" />


     <label>Description : </label><textarea  name="description"
      placeholder="Picnic Description"  required=""  rows="3" cols="64"></textarea>


        <label>Food : </label><textarea  name="food"
      placeholder="Picnic Food"  required=""  rows="3" cols="64"></textarea>

        <label>Departual place : </label><input type="text" name="departurelocation"
      placeholder="Picnic Departual place"  required="" />

 	<label>Departual time : </label><input type="time" name="departuretime"
      placeholder="Picnic Departual time"  required="" />

      <label>arrival time : </label><input type="time" name="arrivaltime"
      placeholder="Picnic arrival time"  required="" />

      <label>return time : </label><input type="time" name="returntime"
      placeholder="Picnic return time"  required="" />

      <label>Date : </label><input type="date" name="date"
      placeholder="Picnic  Date"  required="" />

        <label>image1 : </label><input type="file" name="image1" />
        <label>image2 : </label><input type="file" name="image2" />
        <label>image3 : </label><input type="file" name="image3" />



 		 <label>Activities : </label><textarea  name="activities"
      placeholder="Picnic Activities"  required=""  rows="3" cols="64"></textarea>




      <input type="Submit" name="Submit" value="Submit"/>  
    </form>
  </div>


</body>
</html>



 <?php
	
include 'model.php';
	
if(!empty($_POST)) {
  $add = addPicnic($_POST['title'],$_POST['place'], $_POST['price'], $_POST['capacity'],$_POST['description'] , $_POST['food'], $_POST['departurelocation'],$_POST['departuretime'] , $_POST['arrivaltime'],$_POST['returntime'],$_POST['date'],$_POST['activities']);
	if($add == 1) {
############################################################upload images
		
		$id = getIdForLastPicnic();
		$target_file = 'picnics/'.$id."_1".".".pathinfo( $_FILES['image1']['name'], PATHINFO_EXTENSION) ;
 move_uploaded_file($_FILES["image1"]["tmp_name"], $target_file);
 
 $target_file = 'picnics/'.$id."_2".".".pathinfo( $_FILES['image2']['name'], PATHINFO_EXTENSION) ;
 move_uploaded_file($_FILES["image2"]["tmp_name"], $target_file);
 
 $target_file = 'picnics/'.$id."_3".".".pathinfo( $_FILES['image3']['name'], PATHINFO_EXTENSION);
 move_uploaded_file($_FILES["image3"]["tmp_name"], $target_file);
       
####################################################################
		echo ("<script LANGUAGE='JavaScript'>
    #window.alert('User added succifully');
    #window.location.href='main.php';
    #</script>");
	}
	else {
		echo ("<script LANGUAGE='JavaScript'>
    window.alert('Error 404');
    window.location.href='addPicnic.php';
    </script>");
	}
	}
		
?>