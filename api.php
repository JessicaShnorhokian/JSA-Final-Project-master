<?php

$userid = "";
function invalidUid($username)
{
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return false;
}

function pwdMatch($pwd, $pwdRepeat)
{
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return false;
}

//getCost

//getGains
function  saleperitem($conn, $item,$userid)
{
    $sql = " SELECT SUM(P_quantity) FROM sold_items WHERE P_id= $item and U_id= $userid ;";
    $result = mysqli_query($conn,$sql);

    return $result ;
}

function  gains($conn, $userid)
{
    $sql = " SELECT SUM(O_totalprice) FROM customer_order WHERE U_id= $userid ;";
    $result = mysqli_query($conn,$sql);

    return $result ;
}


function getGain($conn, $userid)
{

    $sql="SELECT sum(O_totalprice) as total FROM customer_order where U_id = $userid";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result))
    { 
       return $row['total'];
    }
    
}

function getCustomerNumber($conn, $userid)
{

    $sql="SELECT count(C_id) as total FROM customer where U_id = $userid";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result))
    { 
       return $row['total'];
    }
    
}
function getOrderNumber($conn, $userid)
{

    $sql="SELECT count(O_id) as total FROM customer_order where U_id = $userid";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result))
    { 
       return $row['total'];
    }
    
}
function getCost($conn, $userid)
{

    $sql="SELECT sum(p_costperitem) as total FROM inventory where U_id = $userid";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result))
    { 
       return $row['total'];
    }
    
}




function createProduct($conn, $name, $quantity, $costperitem, $sellingprice, $filename,$userid)
{

    $sql = "INSERT INTO inventory(P_name, P_quantity, P_costperitem, P_sellingprice,P_filename,U_id) VALUES (?, ?, ?, ?, ?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed2");

        exit();
    }
    

    mysqli_stmt_bind_param($stmt, "sssssi", $name, $quantity, $costperitem, $sellingprice, $filename,$userid);
    if (!mysqli_stmt_execute($stmt)) {
        print_r(mysqli_stmt_error($stmt));
    } else {

        mysqli_stmt_close($stmt);
        header("location: ./homepage.php");
    }
}
function createOrder($conn, $P_id, $P_quantity, $P_sellingprice, $userid)
{

    $sql = "INSERT INTO orderclass(P_id, P_quantity, P_sellingprice, U_id) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./order.php?error=stmtfailed2");

        exit();
    }
    

    mysqli_stmt_bind_param($stmt, "iids", $P_id, $P_quantity, $P_sellingprice, $userid);
    if (!mysqli_stmt_execute($stmt)) {
        print_r(mysqli_stmt_error($stmt));
    } else {

        mysqli_stmt_close($stmt);
        header("location: ./order.php?error=none");
    }
}


function createCustomer($conn, $name, $surname, $email, $number, $address, $userid)
{

    $sql = "INSERT INTO customer(C_name, C_surname, C_email, C_number, C_address, U_id) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./customer.php?error=stmtfailed2");

        exit();
    }


    mysqli_stmt_bind_param($stmt, "ssssss", $name, $surname, $email, $number, $address, $userid);
    if (!mysqli_stmt_execute($stmt)) {
        print_r(mysqli_stmt_error($stmt));
    } else {

        mysqli_stmt_close($stmt);
        header("location: ./customer.php?error=none");
    }
}

function deleteCustomer($conn, $cid, $u_id)
{

    $row = cidExists($conn, $cid, $u_id);

    $sql = "DELETE FROM customer WHERE C_id=? and U_id=?";
    $stmt = $conn->stmt_init();
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./customer.php?error=stmtfailed2");
        
    }
    $stmt->bind_param('ii', $cid, $u_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./customer.php?error=none");
}

function deleteProduct($conn, $P_id, $U_id)
{
    $sql = "DELETE FROM inventory WHERE P_id=? and U_id=?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./homepage.php?error=stmtfailed2");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'ii', $P_id, $U_id);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);

    header("location: ./homepage.php?error=none");
    exit();
    
}



function uidExists($conn, $username)
{
    $sql = "SELECT * FROM user WHERE U_username = ? ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function pidExists($conn, $p_id,$u_id)
{
    $sql = "SELECT * FROM inventory WHERE P_id = ? and U_id=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $p_id,$u_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}


function cidExists($conn, $cid, $uid)
{
    $sql = "SELECT * FROM customer WHERE C_id = ? and U_id = ? ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $cid, $uid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}




function createUser($conn, $name, $surname, $number, $address, $email, $username, $password, $storename)
{


    $sql = "INSERT INTO user(U_name, U_surname, U_number, U_address, U_email,U_username, U_password, U_storename) VALUES (?, ?, ?, ?, ?,? ,? ,? );";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed2");
        exit();
    }
    print_r($stmt);
    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssssss", $name, $surname, $number, $address, $email, $username, $hashedpwd, $storename);
    if (!mysqli_stmt_execute($stmt)) {
        print_r(mysqli_stmt_error($stmt));
    } else {

        mysqli_stmt_close($stmt);
        header("location: ./login.php");
    }
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function getuserid($conn, $username)
{
    $sql = "SELECT U_id FROM user WHERE U_username=?";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed3");

        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userid = $result->fetch_assoc();
}
function searchInventory($conn, $productName)
{
    $sql = "SELECT * FROM inventory WHERE P_name = ? ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $productName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}


function loginUsr($conn, $username, $pass)
{

    $uidExists = uidExists($conn, $username);
    print_r($uidExists);

    if ($uidExists === false) {
        header("location: ./login.php?error=wronglogin1");
        exit();
    }

    $pwdHashed = $uidExists["U_password"];

    $checkPwd = password_verify($pass, $pwdHashed);

    if ($checkPwd === false) {


        header("location: ./login.php?error=wronglogin2");

        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["U_id"] = $uidExists["U_id"];
        $_SESSION["username"] = $uidExists["U_username"];
        $_SESSION['username'] = $username;
        $userid = $username;
        $_SESSION['userid'] = $userid;
        header("location: ./homepage.php");


        exit();
    }
}
function updateProduct($conn, $p_id,$u_id, $name, $quantity, $costperitem ,$sellingprice,$filename)
{
    $row=pidExists($conn, $p_id,$u_id);
    if(empty($name)){
        $name=$row['P_name'];
    }

    if(empty($quantity)){
        $quantity=$row['p_quantity'];
    }
    if(empty($costperitem)){
        $costperitem=$row["p_costperitem"];
    }
    if(empty($sellingprice)){
        $sellingprice=$row["p_sellingprice"];  
    }

    if(empty($filename)){
        $filename=$row["P_filename"];  
    }
    debug_to_console($filename);

    $sql="UPDATE inventory SET P_name=? , p_quantity=?, p_costperitem=?, p_sellingprice=?, P_filename=? where U_id=? and P_id=?";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ./homepage.php?error=smtngfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'ssiisii', $name, $quantity,$costperitem,$sellingprice,$filename,$u_id,$p_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./homepage.php?error=none");
    exit();

}
function updateCustomer($conn, $cid, $u_id, $name, $surname, $email, $number, $address)
{
    $row=cidExists($conn, $cid, $u_id);
    
    if(empty($name)){
        $name=$row['C_name'];
    }

    if(empty($surname)){
        $surname=$row['C_surname'];
    }
    if(empty($email)){
        $email=$row["C_email"];
    }
    if(empty($number)){
        $number=$row["C_number"];  
    }

    if(empty($address)){
        $address=$row["C_address"];  
    }
   

    $sql="UPDATE customer SET C_name=? , C_surname=?, C_email=?, C_number=?, C_address=? where U_id=? and C_id=?";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ./customer.php?error=smtngfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'sssssii', $name, $surname,$email,$number,$address,$u_id,$cid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./customer.php?error=none");
    exit();

}
