<?php

include 'db.php';
include 'api.php';

if(isset($_POST["yes"])){

    $cid = $_POST["C_id"];

session_start();
$U_id = $_SESSION['U_id'];

deleteCustomer($conn,$cid,$U_id);

}
else if(isset($_POST["no"])){

    header("location: ./customer.php");

}
