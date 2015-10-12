<?php

//Require config.php file to connect with mysql server and the db.
require_once('config.php');

//Calling PHasher class file.
include_once('phasher/phasher.class.php');
$I = PHasher::Instance();

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 5000000)
	&& in_array($extension, $allowedExts)) {
if ($_FILES["file"]["error"] > 0) {
	echo "Return Code:  " . $_FILES["file"]["error"] . "<br />";
} else {
	//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	//echo "Type: " . $_FILES["file"]["type"] . "<br />";
	//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " KB<br />";
	//echo "Temp. file: " . $_FILES["file"]["tmp_name"] . "<br />";
	if (file_exists("tmp/" . $_FILES["file"]["name"])) {
		echo $_FILES["file"]["name"] . " already exists. ";
	} else {
		move_uploaded_file($_FILES["file"]["tmp_name"],
			"tmp/" . $_FILES["file"]["name"]);

		$uploadedImage = "tmp/" . $_FILES["file"]["name"];
		$hash = $I->FastHashImage($uploadedImage);
		$hex = $I->HashAsString($hash);

		//echo "Stored in: " . "tmp/" . $_FILES["file"]["name"];
	}
}
} else {
	echo "Invalid file";
}

$result = mysqli_query($con, "SELECT `fid`,`hash` FROM `images`");

while($row  = mysqli_fetch_array($result)){
	if($row['hash'] == $hex){
		echo $row['hash'];
		$fid = $row['fid'];
		echo "<a href='https://www.facebook.com/$fid/'><img src='https://graph.facebook.com/$fid/picture?type=large'></a>";
	}
}

?>