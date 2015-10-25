<?php

session_start();

class Search{

	function __construct()
	{

	}

	/**
	* Upload posted image from index.php to tmp dir
	* @return string
	*/
	function uploadImage()
	{

		if(isset($_POST['submit'])){

		$allowedExts = array('jpg', 'jpeg', 'pjpeg', 'png', 'x-png');
		$temp = explode(".", $_FILES["image"]["name"]);
		$extension = end($temp);

		//Check if the extenstion of the uploaded picture is correct and the max size is 5*1024*1024 Megabits.
		if((($_FILES["image"]["type"] == "image/jpg")
			|| ($_FILES["image"]["type"] == "image/jpeg")
			|| ($_FILES["image"]["type"] == "image/pjpeg")
			|| ($_FILES["image"]["type"] == "image/png")
			|| ($_FILES["image"]["type"] == "image/x-png"))
			&& ($_FILES["image"]["size"] <= 5242880)
			&& in_array($extension, $allowedExts)){

				if($_FILES["image"]["size"] > 0){

					move_uploaded_file($_FILES["image"]["tmp_name"], dirname(__file__)."/tmp/".$_FILES["image"]["name"]);

					$uploadedImage = dirname(__file__)."/tmp/".$_FILES["image"]["name"];

					$_SESSION['image'] = $uploadedImage;

				}
				//Else after checking the file size.
				else {
					echo "Picture is corrupted the size is 0";
				}
		}

		// This else after checking the picture extenstion and max size.
		else {
				echo "<p>Please Upload A Picture, Max. size is 5 Mb.</p>";
			}
	}

		return $_SESSION['image'];
	}

	function imageHashing()
	{
		require_once('classes/phasher.class.php');
		$I = PHasher::Instance();

		$hash = $I->FastHashImage(Search::uploadImage());
		$hex = $I->HashAsString($hash);

		$query = "SELECT `fid`,`hash` FROM `images` WHERE `hash` LIKE '%".$hex."%'";

		return $query;
	}

	function imageResults()
	{
		require('template/header.php');

		echo '
				<header>
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
			<div class="navbar-header inline-block">
			  <a class="navbar-brand" href="index.php">
				<img alt="FBpp logo" src="images/logo.png">
			  </a>
			</div>
			<form action="search.php" method="POST" class="form-inline reset-margin" enctype="multipart/form-data">
		<div class="form-group">
		<input type="file" name="image" class="form-control">
		<button type="submit" name="submit" class="btn btn-primary form-control"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	</div>
	</form>
		  </div>
		</nav>
		</header>
		';

		echo '<div class="container"><!--container-->';

		require('config.php');
		
		require('classes/paginator.class.php');

		$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 10;
		$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
		$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;

		$starttime = microtime(true);

		$queryResults = mysqli_query($con, Search::imageHashing());
		$checkRows = mysqli_num_rows($queryResults);

		if($checkRows > 0){

		$numRows = mysqli_num_rows($queryResults);

		$endtime = microtime(true);

		echo "<p>About ".$numRows." results (".$duration = $endtime - $starttime." seconds)</p>";

		$Paginator  = new Paginator( $con, Search::imageHashing() );
		$results    = $Paginator->getData( $limit, $page );

		echo '<div class="col-md-10 col-md-offset-1">
		<table class="table table-striped table-condensed table-bordered table-rounded"><tbody>';

		for( $i = 0; $i < count( $results->data ); $i++ ){
				echo '<tr>';
				$fid = $results->data[$i]['fid'];
				echo '<td>';
				echo "<a href='https://www.facebook.com/$fid/' target='_blank'>https://www.facebook.com/$fid/</a>";
				echo "<a href='https://www.facebook.com/$fid/' target='_blank'><img src='https://graph.facebook.com/$fid/picture?type=large' alt='' class='img-responsive'></a>";
				$name = 'https://graph.facebook.com/'.$fid.'?fields=name&access_token=748352698603001|94fc98094ca42f974879c56f3229c5e4';
				$response = file_get_contents($name);
				$user = json_decode($response,true);
				echo $user['name'];
				echo '</td>';
				echo '</tr>';
			}
			if($numRows <= 10){
				echo '</tbody></table>';
				echo "</div>";
				echo "</div>";
				require('template/search_footer.php');
			} else {
				echo '</tbody></table>';
				echo $Paginator->createLinks( $links, 'pagination pagination-sm' );
				echo "</div>";
				echo "</div>";
				require('template/search_footer.php');
			}
	}else{
		echo "<br />We found 0 results for the uploaded image please upload another one or try later when we scrap more pictures.";
		echo "</div>";
		require('template/footer.php');
	}
}
}

Search::imageResults();
?>