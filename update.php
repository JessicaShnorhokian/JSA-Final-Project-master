<?php

if(isset($_POST["submit"])){

$pid = $_POST["P_id"];
$name = $_POST["name"];
$price = $_POST["price"];
$cost = $_POST["cost"];
$quantity = $_POST["quantity"];
//jessica, asi inch glla gr hosdeghe? inchbes grnank enel vr hosdeghe path
if(!$_FILES["uploadfile"]["error"] != 0){
$filename = $_FILES["uploadfile"]["name"];
$tempname = $_FILES["uploadfile"]["tmp_name"]; 
$folder = "resources/images/".$filename;
echo("<script>console.log('file not empty');</script>");

} else {
    $filename = null;
    $tempname = null;
    $folder = null;
    echo("<script>console.log('file empty');</script>");
    
}
session_start();
$u_id = $_SESSION["U_id"];

include_once 'db.php';
include_once 'api.php';

updateProduct($conn, $pid, $u_id, $name, $quantity, $cost, $price,$filename);

}else if(isset($_POST["cancel"])){

    header("location: ./homepage.php");

}
