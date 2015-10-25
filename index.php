<?php require('template/header.php'); ?>

<div class="container"><!--container-->
		<!--<h3>Search Facebook Profiles Pictures For Similar Pictures.</h3>-->
		<!--<p>Please upload a picture, Allowed extensions are (jpg, jpeg, pjpeg, png, x-png) and maximum size is 5 Mb...</p>-->

	<div class="search">
	<center>
	<img src="images/main_logo.png" alt="FBpp big logo" class="img-responsive">

	<form action="search.php" method="POST" class="form-inline reset-margin" enctype="multipart/form-data">
		<div class="form-group">
		<input type="file" name="image" class="form-control">
		<button type="submit" name="submit" class="btn btn-primary form-control"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	</div>
	</form>
	<?php

	//Require config.php file to connect with mysql server and the db.
	require('config.php');
	
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
</center>
</div>
	<br />
	</div><!--container-->

	<?php require('template/footer.php'); ?>