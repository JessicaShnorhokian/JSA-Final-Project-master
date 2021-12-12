<?php

if(isset($_POST["submit"])){
    
    $P_id = $_POST["P_id"];
    $P_quantity = $_POST["P_quantity"];
    $P_sellingprice = $_POST["P_sellingprice"];

    
session_start();
$U_id = $_SESSION['U_id'];
//echo("<script>console.log('PHP: " . $username . "');</script>");

    require_once 'db.php';
    require_once 'api.php';
    
        createOrder($conn, $P_id, $P_quantity, $P_sellingprice, $U_id);
        

    
    
}else if (isset($_POST["cancel"])){ 
    header("location: order.php?ordercanceled");
    exit(); 
}
?>