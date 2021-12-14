<?php
include_once 'header.php';
session_start();

$username = $_SESSION['username'];
$U_id = $_SESSION['U_id'];
echo ("<script>console.log('PHP: " . $username . "');</script>");
?>
<link rel="stylesheet" href="./css/customer.css">
<link rel="stylesheet" href="./css/bootstrap.css">


<main class='main-container'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?php

     require_once 'db.php';
     echo ("<script>console.log('PHP: " . $username . "');</script>");
 
     $sql = "SELECT  `C_id`,`C_name`, `C_surname`, `C_email`, `C_number`, `C_address`, `U_id` FROM `customer` where U_id= ?";
 
     $stmt = mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt, $sql)) {
         echo "<script>console.log('error bro')</script>";
     }

     mysqli_stmt_bind_param($stmt, "s", $U_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultData) > 0) {
        while ($row = $resultData->fetch_assoc()) {
            if($row["C_name"]==-1){
                $result = 0;
                continue;
            }else{
                $result = 1;
            // echoing a product item to display
            echo "
        <div class='product-item'> 
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
    } 
    if($result == 0){
        echo "0 results";
        }
    $data[] = "";
    ?>
     </div>
</main>


<!-- Add button DOM element-->

<a href="#" class="float">
    <span class="glyphicon glyphicon-plus my-float"></span>
</a>

<!-- Adding Form -->

<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 50%;" id="newmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="color:#000000">
                    Add New Customer
                </h4>
            </div>
            <div class="modal-body">
                <form action="./cadd.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" style="width:100%" placeholder="Enter customer name!" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="surname" style="width:100%" placeholder="Enter customer surname!" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" style="width:100%" placeholder="Enter customer email!" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="number" style="width:100%" placeholder="Enter customer number!" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="address" style="width:100%" placeholder="Enter customer address!" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-default">Add</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="cancel" class="btn btn-default" formnovalidate>Cancel</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Button Function, to show the add product form -->

<script>
    $(function() {
        $(".float").click(function() {
            $("#newmodal").modal('show');
        });
    });
</script>

<!-- Updating customer form -->

<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 50%;" id="update-container" class="modal fade" role="dialog">
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
                        <input type="text" class="form-control" name="number" style="width:100%" placeholder="Enter customer number!">
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

<!-- Edit button function, to show the update form -->
<script>
    $(function() {
        $(".edit-button").click(function() {
            $("#update-container").modal('show');
        });
    });
</script>

<!-- Delete form  -->
<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 20%;" class="fade" role="dialog" id="delete-container">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="color:#000000">
                    Delete Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <form action="./cdelete.php" method="post" enctype="multipart/form-data">
                <input type='text' name='C_id' id='pid' class='username' value="">
                    <div class="form-group" id="delete-buttons">
                        <button type="submit" name="yes" id="delete-yes" class="btn btn-default">Yes</button>
                        <button type="cancel" name="no" id="delete-no" class="btn btn-default">No</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- delete container showing function -->

<script>
    $(function() {
        $(".delete-button").click(function() {
            $("#delete-container").modal('show');
        });
    });
</script>
<!-- Update and Delete Form Showing functions -->
<script>
    function showId() {
        console.log(document.getElementById('username').value);
    }
    // Showing the delete form and storing the product id(pid) into form to pass into php
    function showDeleteForm(pid) {
        document.getElementById('pid').value = pid;
    }
    // Showing the update form and storing the product id (pid) into form to pass into php
    function displayUpdateForm(pid) {
        document.getElementById('update-container').style.display = "block"
        document.getElementById('pid1').value = pid

    }
</script>

</body>

</html>
