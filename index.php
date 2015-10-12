<!DOCTYPE html>
<head>
	<title>FBpp - Facebook Profile Picture search engine</title>
	</head>
<body>
	<?php
	require('config.php');
	
	$check = mysqli_query($con, "SELECT id FROM images ORDER BY id DESC LIMIT 1;");
	if(mysqli_num_rows($check) > 0){

		$max_id = mysqli_fetch_row($check);

		$id = $max_id[0];

		echo "Number of scraped pictures in our database is: ".$id;
	}else{
		echo "The database is empty you need to run scraper.php";
	}
	?>
	<br /><br />
	<form action="result.php" method="post" enctype="multipart/form-data">
	<input type="file" name="file" id="file"><br />
	<input type="submit" name="submit" value="Upload">
	</form>
</body>
</html>
