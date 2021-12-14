<?php 
$search = $_POST["search"];

include_once 'db.php';
include_once 'api.php';

$search = mysqli_real-escape_string($conn, $_POST["search-input"]);
$sql = "S";
