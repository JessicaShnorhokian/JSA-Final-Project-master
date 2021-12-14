<?php

if(isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $pwdRepeat = $_POST["passwordconfirm"];
    $tel = $_POST["number"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $email = $_POST["username"];

    $storename = $_POST["storename"];
    

    require_once 'db.php';
    require_once 'api.php';
    
    
        if(pwdMatch($pwd, $pwdRepeat) !== false){
            header("location: index.php?error=incorrectpassword");
            exit();
        }

        if(uidExists($conn, $username) !== false){
            header("location: index.php?error=uidtaken");
            exit();
        }
        createUser($conn, $name, $surname, $tel,$address, $email,$username, $pwd, $storename);
}else{
    header("location: index.php");
    exit(); 
}
?>