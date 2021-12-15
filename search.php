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
    <!-- Edit button function, to show the update form -->
<script>
    $(function() {
        $("#customer-edit").click(function() {
            $("#update-containerC").modal('show');
        });
    });
</script>

<script>
    $(function() {
        $("#customer-delete").click(function() {
            $("#delete-containerC").modal('show');
        });
    });
</script>
<!-- Update and Delete Form Showing functions -->
<script>
    function showId() {
        console.log(document.getElementById('username').value);
    }
    // Showing the delete form and storing the product id(pid) into form to pass into php
    function showDeleteFormC(pid) {
        window.alert("pid")
        console.log(pid)
        document.getElementById('pid').value = pid;
    }
    // Showing the update form and storing the product id (pid) into form to pass into php
    function displayUpdateFormC(pid) {
        document.getElementById('update-container').style.display = "block"
        document.getElementById('update-container').style.z-index = "99999"
        document.getElementById('pid1').value = pid

    }
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



<!-- Delete form  -->
<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 20%;" class="fade" role="dialog" id="delete-containerC">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="color:#000000">
                    Delete Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <form action="./cdelete.php" method="get" id="delete-form" >
                    <input type="text" name="C_id" id="pid" form="delete-form" class = "username" value="">
                    <div class="form-group" id="delete-buttons">
                        <button type="submit" name="yes" id="delete-yes" class="btn btn-default">Yes</button>
                        <button type="cancel" name="no" id="delete-no" class="btn btn-default">No</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<!-- Updating customer form -->

<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 50%;" id="update-containerC" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="color:#000000">
                    Update Customer
                </h4>
            </div>
            <div class="modal-body">
                <form action="./cupdate.php" method="post" enctype="multipart/form-data">
                <input type='text' name='C_id' id='pid1' class='username' value="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" style="width:100%" placeholder="Enter customer name!" >
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="surname" style="width:100%" placeholder="Enter customer surname!" >
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" style="width:100%" placeholder="Enter customer email!" >
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="number" style="width:100%" placeholder="Enter customer number!">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="address" style="width:100%" placeholder="Enter customer address!">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-default">Update</button>
                    </div>

                    <div class="form-group">
                        <button type="cancel" name="cancel" class="btn btn-default" >Cancel</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


