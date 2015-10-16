<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>FBpp - Facebook Profile Picture search engine</title>
	<meta charset="utf-8">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css">
	</head>
<body>

	<div class="container"><!--container-->

		<h3>Search Facebook Profiles Pictures For Similar Pictures.</h3>
		<p>Please upload a picture...</p>

	<?php

	//Require config.php file to connect with mysql server and the db.
	require('config.php');

	include('phasher/phasher.class.php');

	$I = PHasher::Instance();
	
	//Check if the database is empty or if there are hashed pictures then show the number of hashed pictures.
	$check = mysqli_query($con, "SELECT id FROM images ORDER BY id DESC LIMIT 1;");
	if(mysqli_num_rows($check) > 0){

		$max_id = mysqli_fetch_row($check);

		$id = $max_id[0];

		echo 'We scraped '; echo '<span class="bg-info">'.$id.'</span>'; echo ' pictures...';
	}else{
		echo 'The database is empty you need to run scraper.php';
	}
	?>

	<br /><br />
	<form action="index.php?go" method="post" class="form-inline reset-margin" enctype="multipart/form-data">
		<div class="form-group">
		<input type="file" name="file" class="file-input">
		<button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	</div>
	</form>

	<?php

	if(isset($_POST['submit'])){

		$allowedExts = array('jpg', 'jpeg', 'pjpeg', 'png', 'x-png');
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);

		//Check if the extenstion of the uploaded picture is correct and the max size is 5*1024*1024 Megabits.
		if((($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/png")
			|| ($_FILES["file"]["type"] == "image/x-png"))
			&& ($_FILES["file"]["size"] <= 5242880)
			&& in_array($extension, $allowedExts)){

			if($_FILES["file"]["error"] > 0){

				echo "Return Code: " .$_FILES["file"]["error"]."<br />";
			} else {

				move_uploaded_file($_FILES["file"]["tmp_name"], "tmp/".$_FILES["file"]["name"]);

				$uploadedImage = "tmp/".$_FILES["file"]["name"];

				$hash = $I->FastHashImage($uploadedImage);
				$hex = $I->HashAsString($hash);

				$selectQuery = mysqli_query($con, "SELECT `fid`,`hash` FROM `images` WHERE `hash` LIKE '%".$hex."%'");

				$numrows = mysqli_num_rows($selectQuery);

				echo "<p>" .$numrows. " results found for " .$_FILES['file']['name']. "</p>";

				//Create while loop and loop through result set.
				while($row = mysqli_fetch_array($selectQuery)){

					if($row['hash'] == $hex){
						$fid = $row['fid'];
						echo "<a href='https://www.facebook.com/$fid/' target='_blank'><img src='https://graph.facebook.com/$fid/picture?type=large'></a> ";
					}
				}
			}
		} else {
				echo "<p>Please uplad a picture.</p>";
			}
	}

	?>

</div><!--container-->
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
