<?php

if(isset($_POST["submit"])){
    
    $P_id = $_POST["P_id"];
    $P_quantity = $_POST["P_quantity"];
    $C_id= $_POST["customer"];
    $O_dateoforder= $_POST["date"];

    
session_start();
$U_id = $_SESSION['U_id'];


    require_once 'db.php';
    require_once 'api.php';

    

    $quant= getQuantity($conn,$U_id,$P_id);    
    $selling_price = getSellingPrice($conn,$U_id,$P_id);
    $totalPrice = $P_quantity * $selling_price;
  


    if($quant<$P_quantity)
    {
            
            echo"<script>window.alert('Quantity not enough, decrease quantity')</script>";
            header("location: order.php?ordercanceled");
            
        
    }else{
        
        $newQuantity = $quant-$P_quantity;
        updateQuantity($conn,$P_id,$U_id,$newQuantity);
        
    
        if(productExists($conn,$P_id,$U_id)==true)
        {
            $soldquant = getSoldQuantity($conn,$U_id,$P_id);
            $newsoldquant= $soldquant + $P_quantity;
            updatesolditem($conn,$P_id,$U_id,$newsoldquant);
           // createOrder($conn,$C_id,$totalPrice,$O_dateoforder,$P_id,$P_quantity,$U_id);
            

        }
        else
        {
            addSoldItem($conn,$P_id,$P_quantity,$U_id);      

   

        }
        print_r($O_dateoforder);
        exit();
            createOrder($conn,$C_id,$totalPrice,$O_dateoforder,$P_id,$P_quantity,$U_id);

        header("location: order.php?ordercanceled");

            

    }
}else if (isset($_POST["cancel"])){ 
    header("location: order.php?ordercanceled");
    exit(); 
}
?>