<?php

if(isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $address = $_POST["address"];

    
session_start();
$U_id = $_SESSION['U_id'];

require_once 'db.php';
    require_once 'api.php';
    
        createCustomer($conn, $name, $surname, $email,$number,$address,$U_id);
        
    }else if (isset($_POST["cancel"])){ 
        header("location: customer.php");
        exit(); 
    }
    ?>
