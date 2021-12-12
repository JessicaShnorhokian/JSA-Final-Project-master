<?php

$serverName = "sql6.freesqldatabase.com";
$dBUserName = "sql6458239";
$dBPassword = "Tl1Xl4vVI5";
$dBName = "sql6458239";



$conn =  mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}




// To connect to your database use these details;

// Host (serverName): sql6.freesqldatabase.com
// Database name: sql6458239
// Database user: sql6458239
// Database password: Tl1Xl4vVI5
// Port number: 3306