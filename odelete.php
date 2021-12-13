<?php

if(isset($_POST["yes"])){

$oid = $_POST["O_id"];


session_start();
$u_id = $_SESSION["U_id"];

include_once 'db.php';
include_once 'api.php';

deleteOrder($conn, $oid, $u_id);

}else if(isset($_POST["no"])){

    header("location: ./order.php");

}
