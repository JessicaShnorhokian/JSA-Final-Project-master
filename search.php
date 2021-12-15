<?php

include_once 'header.php';
require_once 'db.php';
include_once 'api.php';
session_start();
$search = $_POST["search"];
$U_id = $_SESSION['U_id'];

?>

<link rel="stylesheet" href="./css/search.css">
<link rel="stylesheet" href="./css/searchboot.css">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
</script>
<div class="inventory">
    <div class="title">
        <h2>Products</h2>
    </div>
<div class="inventory-result">
    <main class='main-container'>
  
        <?php 
        searchInventory($conn, $search, $U_id);
    ?>
</main>
</div>
</div>
<div class="customer">
<div class="title">
        <h2>Customers</h2>
    </div>  
<div class="customer-result">
    <main class='main-container'>
      <script>document.getElementById</script>
        <?php 
        searchCustomer($conn, $search, $U_id);
    ?>
    
</main>
</div>
</div>
<div class="order">
<div class="title">
        <h2>Orders</h2>
    </div>  
<div class="order-result">
    <main class='main-container'>
      
        <?php 
        searchOrder($conn, $search, $U_id);
    ?>
</main>
</div>
</div>







