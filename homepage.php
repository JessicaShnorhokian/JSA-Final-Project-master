<?php
include_once 'header.php';
session_start();

$username = $_SESSION['username'];
$U_id = $_SESSION['U_id'];
echo ("<script>console.log('PHP: " . $username . "');</script>");
?>

<link rel="stylesheet" href="./css/homepage.css">
<link rel="stylesheet" href="./css/bootstrap.css">


<main class='main-container'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?php
    require_once 'db.php';
    echo ("<script>console.log('PHP: " . $username . "');</script>");
    $sql = "SELECT  `P_id`,`P_name`, `p_quantity`, `p_sellingprice`, `P_filename`, 'U_id' FROM `inventory` where U_id= ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<script>console.log('error bro')</script>";
        
    }

    mysqli_stmt_bind_param($stmt, "s", $U_id);
    mysqli_stmt_execute($stmt); 

    $resultData = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($resultData) > 0) {
       
        while ($row = $resultData->fetch_assoc()) {

            // echoing a product item to display
            echo "
        <div class='product-item'> 
            <div class='image-box'>  
                <img src='./resources/images/{$row['P_filename']}' alt='' class='product-image'>
                     <div class='edit'>
                            <div class='edit-im'>
    
                            <a></a>
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
    } else {
        $result = 0;
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
                    Add New Product
                </h4>
            </div>
            <div class="modal-body">
                <form action="./add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" style="width:100%" placeholder="Enter product name!" required>
                    </div>
                    <div class="form-group">
                        <input type="number"  min="0" class="form-control" name="quantity" style="width:100%" placeholder="Enter product Quantity!" required>
                    </div>
                    <div class="form-group">
                        <input type="number" step="0.01" min= "0" class="form-control" name="costperitem" style="width:100%" placeholder="Enter cost per item!" required>
                    </div>
                    <div class="form-group">
                        <input type="number" step="0.01" min= "0"  class="form-control" name="sellingprice" style="width:100%" placeholder="Enter selling price!" required>
                    </div>
                    <div class="form-group">
                        <input type="file" name="uploadfile" value="" />
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-default">Add</button>
                    </div>
                    <div class="form-group">
                        <button type="cancel" name="cancel" class="btn btn-default" formnovalidate>Cancel</button>
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

<!-- Updating product form -->

<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 50%;" id="update-container" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="color:#000000">
                    Update Product
                </h4>
            </div>
            <div class="modal-body">
                <form action="./update.php" method="post" enctype="multipart/form-data">
                <input type='text' name='P_id' id='pid1' class='username' value="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" style="width:100%" placeholder="Enter new product name!" >
                    </div>
                    <div class="form-group">
                        <input type="number"  min= "0"  class="form-control" name="quantity" style="width:100%" placeholder="Enter new product Quantity!" >
                    </div>
                    <div class="form-group">
                        <input type="number" step="0.01" min= "0"  class="form-control" name="cost" style="width:100%" placeholder="Enter new cost per item!" >
                    </div>
                    <div class="form-group">
                        <input type="number" step="0.01"  min= "0"  class="form-control" name="price" style="width:100%" placeholder="Enter new selling price!">
                    </div>
                    <div class="form-group">
                        <input type="file" name="uploadfile" value="" />
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
                <form action="./delete.php" method="post" enctype="multipart/form-data">
                <input type='text' name='P_id' id='pid' class='username' value="">
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