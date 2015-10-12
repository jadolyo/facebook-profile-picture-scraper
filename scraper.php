<?php
/*	Copyright 2014
 *	Written by Ahmed Jadelrab - jadolyo@gmail.com
 *	
 *	This file is part of FBpp
 *	
 *	FBpp is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *	
 *	FBpp is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *	
 *	You should have received a copy of the GNU General Public License
 *	along with FBpp; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

//Require config.php file to connect with mysql server and the db.
require_once('config.php');

//Calling PHasher class file.
include_once('phasher/phasher.class.php');
$I = PHasher::Instance();

//This line to prevent execution timeout.
set_time_limit(0);

//This is infinte while loop to fetch the number of profile pictures and save it inside avatar folder.
$initial = 2;

while($fid = $initial){
// echo "<br />".$fid;
// $img = @file_get_contents('https://graph.facebook.com/'.$fid.'/picture?type=large');
	// $data = file_get_contents('https://graph.facebook.com/[App-Scoped-ID]/picture?width=378&height=378&access_token=[Access-Token]');
	$img = @file_get_contents('https://graph.facebook.com/'.$fid.'/picture?width=378&height=378');
	$file = dirname(__file__).'/avatar/'.$fid.'.jpg';
	file_put_contents($file, $img);

	//echo '<a href="https://www.facebook.com/profile.php?id='.$fid.'"><img src="avatar/'.$fid.'.jpg" /></a><br />';

	//PHasher class to hash the images to hexdecimal values or binary values.
	$hash = $I->FastHashImage($file);
	$hex = $I->HashAsString($hash);
	//echo "hex: " .$hex. "<br />";
	//echo "bin: ".$I->HashAsString($hash, false). "<br />";
	//echo "visual: ".$I->HashAsTable($hash). "<br />";

	//This is to store facebook id and hashed values for the images in hexa values.
	mysqli_query($con, "INSERT INTO images(fid, hash) VALUES ('$fid', '$hex')");

	$initial++;
}

//Test
// for($fid=1; $fid < 100; $fid++){
// $img = @file_get_contents('https://graph.facebook.com/'.$fid.'/picture?type=large');
// $file = dirname(__file__).'/avatar/'.$fid.'.jpg';
// file_put_contents($file, $img);
// }

//This line to print the number of images that has been fetched.
// $result = $initial-1;
// echo '<br /><br />Done of fetching ' .$result. ' Pictures';

?>