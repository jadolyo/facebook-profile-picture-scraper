<?php

$hostname = "";		// Your host name eg. localhost
$dbname   = "";		// Your database name.
$username = "";		// Your database username.
$password = "";		// Your database password.

//Connection to the database.
$con = mysqli_connect($hostname, $username, $password, $dbname);

//Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>