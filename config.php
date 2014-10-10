<?php

$hostname = "localhost"; 
$dbname   = "fbpp"; 
$username = "root";
$password = "";

//Connection to the database.
$con = mysql_connect($hostname, $username, $password)
or die("Unable to connect to Mysql.");

//Select a database to work with.
$selectdb = mysql_select_db($dbname, $con)
or die("Could not select database.");

?>