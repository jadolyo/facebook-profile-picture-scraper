<?php

$hostname = "localhost"; 
$dbname   = "fbpp"; 
$username = "root";
$password = "";

//Connection to the database.
$con = mysqli_connect($hostname, $username, $password, $dbname)
or die("Unable to connect to Mysql.");

?>