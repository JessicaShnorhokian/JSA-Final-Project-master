<?php

if(isset($_POST["submit"])){
    
    $P_id = $_POST["P_id"];
    $P_quantity = $_POST["P_quantity"];

    
session_start();
$U_id = $_SESSION['U_id'];
//echo("<script>console.log('PHP: " . $username . "');</script>");

    require_once 'db.php';
    require_once 'api.php';

    

    $quant= getQuantity($conn,$U_id,$P_id);    


    if($quant<$P_quantity)
    {
            
            echo"<script>window.alert('Quantity not enough, decrease quantity')</script>";
            header("location: order.php?ordercanceled");
            
        
    }else{
        
        $newQuantity = $quant-$P_quantity;
            updateQuantity($conn,$P_id,$U_id,$newQuantity);
            
          //createOrder($conn, $P_id, $P_quantity,1, $U_id);

    }
  

        

    
    
}else if (isset($_POST["cancel"])){ 
    header("location: order.php?ordercanceled");
    exit(); 
}
?>