<?php

if(isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    $costperitem = $_POST["costperitem"];
    $sellingprice = $_POST["sellingprice"];

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"]; 

    $folder = "resources/images/".$filename;
    
session_start();
$U_id = $_SESSION['U_id'];
//echo("<script>console.log('PHP: " . $username . "');</script>");

    require_once 'db.php';
    require_once 'api.php';
    
        createProduct($conn, $name, $quantity, $costperitem,$sellingprice,$filename,$U_id);
        
        if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
      }

    
    
}else if (isset($_POST["cancel"])){ 
    header("location: homepage.php");
    exit(); 
}
?>