<?
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

//Calling PHasher class file.
include_once('phasher/phasher.class.php');
$I = PHasher::Instance();

//This line to prevent execution timeout.
set_time_limit(0);
//Pictures number you want to fetch from Facebook.
$pics_no = 100;

//This is the loop to fetch the number of profile pictures and save it inside avatar folder.
for($fid=2; $fid<=$pics_no; $fid++){
$img = @file_get_contents('https://graph.facebook.com/'.$fid.'/picture?type=large');
$file = dirname(__file__).'/avatar/'.$fid.'.jpg';
file_put_contents($file, $img);

echo '<a href="https://www.facebook.com/profile.php?id='.$fid.'"><img src="avatar/'.$fid.'.jpg" /></a><br />';

//PHasher class to hash the images to hexdecimal values or binary values.
$hash = $I->FastHashImage($file);
echo "hex: ".$I->HashAsString($hash). "<br />";
echo "bin: ".$I->HashAsString($hash, false). "<br />";
echo "visual: ".$I->HashAsTable($hash). "<br />";
}

//This line to print the number of images that have been fetched.
$result=$pics_no-1;
echo '<br /><br />Done of fetching ' .$result. ' Pictures';

?>