<?php

$serverName = "localhost";
$dBUserName = "root";
$dBPassword = "root";
$dBName = "salessystem";



$conn =  mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}


// freesqldatabase.com account pass: jsawebfinal1810119 account: silentalbert7@gmail.com

// To connect to your database use these details;

// Host (serverName): sql6.freesqldatabase.com
// Database name: sql6456217
// Database user: sql6456217
// Database password: nKhDbuCIMR
// Port number: 3306