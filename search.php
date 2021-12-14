<?php

include_once 'header.php';
require_once 'db.php';
include_once 'api.php';
session_start();
$search = $_POST["search"];
$U_id = $_SESSION['U_id'];

?>

<link rel="stylesheet" href="./css/homepage.css">
<div class="inventory-result">
<main class='main-container'>
    <?php 
        searchInventory($conn, $search, $U_id);
    ?>

</main>
</div>