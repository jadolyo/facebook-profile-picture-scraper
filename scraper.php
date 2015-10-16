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

//Prevent execution timeout.
set_time_limit(0);

//Solving SSL or https problem.
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

//Check if the database contains hashed pictures or if it's empty, Then start from the latest hashed picture or start from 4.
$check = mysqli_query($con, "SELECT fid FROM images ORDER BY fid DESC LIMIT 1;");
if(mysqli_num_rows($check) > 0){

	$max_fid = mysqli_fetch_row($check);

	$fid = $max_fid[0]+1;
} else {
	$fid = 4;
}

//Infinte while loop to fetch profiles pictures and save them inside avatar folder.
$initial = $fid;

while($fid = $initial){

	$img = file_get_contents('https://graph.facebook.com/'.$fid.'/picture?width=378&height=378', false, stream_context_create($arrContextOptions));
	$file = dirname(__file__).'/avatar/'.$fid.'.jpg';
	file_put_contents($file, $img);

	//PHasher class call to hash the images to hexdecimal values or binary values.
	$hash = $I->FastHashImage($file);
	$hex = $I->HashAsString($hash);

	//Exclude deleted profiles or corrupted pictures.
	if($hex == '0000000000000000'){
		$initial++;
	} else{

	//Store Facebook id and hashed values for the images in hexa values.
		mysqli_query($con, "INSERT INTO images(fid, hash) VALUES ('$fid', '$hex')");

		$initial++;
	}
}

?>