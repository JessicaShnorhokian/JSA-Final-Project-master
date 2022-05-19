<?php

if(isset($_POST["submit"])){

$cid = $_POST["C_id"];
$name = $_POST["name"];
$surname = $_POST["surname"];
$email = $_POST["email"];
$number = $_POST["number"];
$address = $_POST["address"];

session_start();
$u_id = $_SESSION["U_id"];

include_once 'db.php';
include_once 'api.php';

updateCustomer($conn, $cid, $u_id, $name, $surname, $email, $number, $address);

}else if(isset($_POST["cancel"])){

    header("location: ./customer.php");

}
