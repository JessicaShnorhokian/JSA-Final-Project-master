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
function getQuantity($conn, $userid, $productID)
{

    $sql="SELECT * FROM inventory where U_id = $userid and P_id = $productID";
    $result = mysqli_query($conn, $sql);
    
    print_r($result);
   
    while ($row = mysqli_fetch_assoc($result))
    { 
       return $row;
    }
   

    

    
}




function createProduct($conn, $name, $quantity, $costperitem, $sellingprice, $filename,$userid)
{

    $sql = "INSERT INTO inventory(P_name, P_quantity, P_costperitem, P_sellingprice, P_filename,U_id) VALUES (?, ?, ?, ?, ?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed2");
        exit();
    }
    

    mysqli_stmt_bind_param($stmt, "siddsi", $name, $quantity, $costperitem, $sellingprice, $filename,$userid);
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

function deleteOrder($conn, $oid, $u_id)
{

    $row = oidExists($conn, $oid, $u_id);

    $sql = "DELETE FROM orderclass WHERE O_id=? and U_id=?";
    $stmt = $conn->stmt_init();
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./order.php?error=stmtfailed2");
        
    }
    $stmt->bind_param('ii', $oid, $u_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./order.php?error=none");
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
    mysqli_stmt_bind_param($stmt, "ii", $p_id,$u_id);
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


function oidExists($conn, $oid, $uid)
{
    $sql = "SELECT * FROM orderclass WHERE O_id = ? and U_id = ? ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $oid, $uid);
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
    //creating user
    $sql = "INSERT INTO user(U_name, U_surname, U_number, U_address, U_email,U_username, U_password, U_storename) VALUES (?, ?, ?, ?, ?,? ,? ,? );";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ./index.php?error=stmtfailed2");
        exit();
    }
    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssssss", $name, $surname, $number, $address, $email, $username, $hashedpwd, $storename);
    if (!mysqli_stmt_execute($stmt)) {
        print_r(mysqli_stmt_error($stmt));
    } else {
        mysqli_stmt_close($stmt);
        $useridresult = mysqli_query($conn, "SELECT U_id FROM user ORDER BY U_id DESC LIMIT 1");
        $obj = mysqli_fetch_object($useridresult);
        $U_id = $obj->U_id;
        $U_id = $U_id+1;
        $emptyvar = "@emptyvar";
        $emptynum = -1;
    //inserting into inventory
    $inventorysql = "INSERT INTO inventory(P_name, p_quantity, p_costperitem, p_sellingprice,p_filename,U_id) VALUES (?, ?, ?, ?, ?,?);";
    $inventorystmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($inventorystmt, $inventorysql)){
        header("location: ./index.php?error=stmtfailed3");
        exit();
    }
    mysqli_stmt_bind_param($inventorystmt, "sssssi", $emptyvar, $emptyvar, $emptyvar,$emptyvar, $emptyvar,$U_id);
    if (!mysqli_stmt_execute($inventorystmt)) {
        print_r(mysqli_stmt_error($inventorystmt));
    } else {
        mysqli_stmt_close($inventorystmt);
    
         //inserting into sold items
    $SoldItemsSql = "INSERT INTO sold_items(P_id, P_quantity, U_id) VALUES (-1, -1,{$U_id});";
    if (!mysqli_query($conn, $SoldItemsSql)) {
        header("location: ./index.php?error=stmtfailed5");
      exit();
    } else {
        echo "<script>console.log(New record created successfully)</script>";
        //inserting into order class
        $OrderClassSql = "INSERT INTO orderclass(P_id, P_quantity, P_sellingprice, U_id) VALUES (-1, -1, -1,{$U_id});";
    if (!mysqli_query($conn, $OrderClassSql)) {
        header("location: ./index.php?error=stmtfailed6");
      exit();
    } else {
        echo "<script>console.log(New record created successfully)</script>";
  
        //inserting into customer order
    $CustomerOrderSql = "INSERT INTO customer_order(O_id, C_id, O_totalprice, O_dateoforder, U_id) VALUES (-1, -1, -1, -1 , {$U_id});";
    if (!mysqli_query($conn, $CustomerOrderSql)) {
        header("location: ./index.php?error=stmtfailed7");
      exit();
    } else {
        echo "<script>console.log(New record created successfully)</script>";
  
        //inserting into customer
    $CustomerSql = "INSERT INTO customer(C_name, C_surname, C_email, C_number, C_address, U_id) VALUES (-1, -1, -1, -1, -1, {$U_id});";
    if (!mysqli_query($conn, $CustomerSql)) {
        header("location: ./index.php?error=stmtfailed8");
      exit();
    } else {
        echo "<script>console.log(New record created successfully)</script>";
    }
    }
}

}
}
mysqli_close($conn);
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
        $filename=$row["p_filename"];  
    }
    debug_to_console($filename);

    $sql="UPDATE inventory SET P_name=? , p_quantity=?, p_costperitem=?, p_sellingprice=?, p_filename=? where U_id=? and P_id=?";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ./homepage.php?error=smtngfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'siddsii', $name, $quantity,$costperitem,$sellingprice,$filename,$u_id,$p_id);
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

function searchInventory($conn, $searchInput, $U_id){
    $search = mysqli_real_escape_string($conn, $searchInput);
    $sql = "SELECT * FROM inventory WHERE U_id = $U_id AND (P_name LIKE '%$search%' OR p_quantity LIKE '%$search%' OR p_costperitem LIKE '%$search%' OR p_sellingprice LIKE '%$search%' OR p_filename LIKE '%$search%');";
    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);
    $searchresult=1;
    if($queryResult > 0){
        while($row = mysqli_fetch_assoc($result)){
            if($row["P_name"]=="empty"){
                $searchresult = 0;
                continue;
            }else{
                $searchresult = 1;
            echo "
                <div class='product-item'> 
                    <div class='image-box'>  
                         <img src='./resources/images/{$row['p_filename']}' alt='' class='product-image'>
                                 <div class='edit'>
                                      <div class='edit-im'>
                                <img src='./resources/images/edit.png' class='edit-button' onclick='displayUpdateForm({$row['P_id']})' alt=''>
                            </div>
                            <div class='edit-delete'>
                                <img src='./resources/images/delete.png' class='delete-button' alt='' onclick='showDeleteForm({$row['P_id']})'>
                            </div>        
                            </div>
                                <div class='product-desc'  >
                                
                                <h1 class='p-name' > {$row['P_name']}  </h1>
                                <h3 class='desc'>Quantity: {$row['p_quantity']}</h3>
                                <h3 class='desc'>Price:{$row['p_sellingprice']}</h3>


                            </div>
                     </div>            
             </div> ";
            }
        }
    }
    else {
        echo "No Results";
    }
    if($searchresult == 0){
        echo "No Results";
    }

}

function searchCustomer($conn, $searchInput, $U_id){
    $search = mysqli_real_escape_string($conn, $searchInput);
    $sql = "SELECT * FROM customer WHERE U_id = $U_id AND (C_name LIKE '%$search%' OR C_surname LIKE '%$search%' OR C_email LIKE '%$search%' OR C_number LIKE '%$search%' OR C_address LIKE '%$search%');";
    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);
    $searchresult=1;
    if($queryResult > 0){
        while($row = mysqli_fetch_assoc($result)){
            if($row["C_name"]==-1){
                $result = 0;
                continue;
            }else{
                $result = 1;
            echo "<div class='product-item'> 
                <div class='image-box'>  
                   
                        <div class='edit'>
                                    <div class='edit-im'>
                                        <img src='./resources/images/edit.png' class='edit-button' onclick='displayUpdateForm({$row['C_id']})' alt=''>
                                    </div>
                                    <div class='edit-delete'>
                                        <img src='./resources/images/delete.png' class='delete-button' alt='' onclick='showDeleteForm({$row['C_id']})'>
                                    </div>        
                        </div>
                                    <div class='product-desc'  >
                                    <div class='product-title'>
                                    <div class='p-name fname'>
                                       {$row['C_name']} 
                                    </div>
                                    <div class='p-name sname'>
                                       {$row['C_surname']} 
                                    </div>
                                    </div>
                                    <h3 class='desc'> Number: {$row['C_number']}</h3>
                                    <h3 class='desc'> Address: {$row['C_address']}</h3>
                                    <h3 class='desc'> Email: {$row['C_email']}</h3>
    
    
                                    </div>
                         </div>            
                 </div> ";
            }
        }
    } else {
        echo "No Results";
    }

}


function searchOrder($conn, $searchInput, $U_id){
    $search = mysqli_real_escape_string($conn, $searchInput);
    $sql = "SELECT * FROM customer_order WHERE U_id = $U_id AND (O_id LIKE '%$search%' OR C_id LIKE '%$search%' OR C_totalprice LIKE '%$search%' OR O_dateoforder LIKE '%$search%');";
    $result = mysqli_query($conn, $sql);

   debug_to_console($result);
    if(!empty($result)){
    $queryResult = mysqli_num_rows($result);

    if($queryResult > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<div class='product-item'> 
                    <div class='image-box'>  
                        <div class='edit'>
                            <div class='edit-maximize'>
                                <img src='./resources/images/maximize.png' class='max-button' alt='' onclick='showOrderDetails({$row['O_id']})'>
                            </div>
                            <div class='edit-delete'>
                                <img src='./resources/images/delete.png' class='delete-button' alt='' onclick='showDeleteForm({$row['O_id']})'>
                            </div>        
                                </div>
                                    <div class='product-desc'  >
                                        <h1 class='p-name' > {$row['P_id']}  </h1>
                                        <h3 class='desc'>Order : {$row['P_quantity']}</h3>
                            </div>
                     </div>            
             </div> ";
        }
    } else {
        echo "No Results";
    }
    }else {
        echo "No Results";
    }
}
