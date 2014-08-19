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

//This line to prevent execution timeout.
set_time_limit(0);
//Pictures number you want to fetch it from Facebook.
$pics_no = 1000;

//This is the loop to fetch the number of profile pictures and save it inside avatar folder.
for($fid=1; $fid<=$pics_no; $fid++){
$img = @file_get_contents('https://graph.facebook.com/'.$fid.'/picture?type=large');
$file = dirname(__file__).'/avatar/'.$fid.'.jpg';
file_put_contents($file, $img);
}

echo 'Done of fetching ' .$pics_no. ' Pictures';

?>