<?php
include_once 'header.php';
session_start();

$username = $_SESSION['username'];
$U_id = $_SESSION['U_id'];
echo ("<script>console.log('PHP: " . $username . "');</script>");
$counter = 0;

?>
<link rel="stylesheet" href="./css/order.css">
<link rel="stylesheet" href="./css/bootstrap.css">

<main class='main-container'>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?php
    $result=0;
     require_once 'db.php';
     echo ("<script>console.log('PHP: " . $username . "');</script>");
 
     $sql = "SELECT  * FROM `orderclass` where U_id= ?";
 
     $stmt = mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt, $sql)) {
         echo "<script>console.log('error bro')</script>";
     }

     mysqli_stmt_bind_param($stmt, "s", $U_id);
     mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultData) > 0) {
        while ($row = $resultData->fetch_assoc()) {
            if($row["P_id"]==-1){
                $result = 0;
                continue;
            }else{
            // echoing a product item to display
            $result = 1;
            echo "
        <div class='product-item'> 
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
        }
    } 
    
    if($result == 0){
        echo "0 results";
    }
    $data[] = "";
    ?>
     </div>
</main>


<a href="#" class="float">
    <span class="glyphicon glyphicon-plus my-float"></span>
</a>

<!-- Adding Form -->

<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 50%;" id="newmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="color:#000000">
                    Add New Order
                </h4>
            </div>
            <div class="modal-body">
                <form action="./oadd.php" method="post" enctype="multipart/form-data" id = "addOrderForm">
                    <div class="form-group">
<!-- check for p_name does not equal to "empty" -->
                    <?php
                    $pdo = new PDO('mysql:host=sql6.freesqldatabase.com; dbname=sql6458239', 'sql6458239', 'Tl1Xl4vVI5');
                    $sql = "SELECT P_id, p_name FROM inventory Where U_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bind_param("i", $U_id);
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    ?>
                    <select name="P_id" class="form-control">
                        <option value="test" disabled="disabled" selected>please select a product</option>
                        <?php foreach($users as $user): ?>
                            <option value="<?= $user['P_id']; ?>"><?= $user['p_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" min="0" class="form-control" name="P_quantity" style="width:100%" placeholder="Enter product quantity!" required>
                    </div>
                            
                  <div style="float: right;">

                       <button form="addProduct" onclick="">
                            add product
                        </button>

      

                               
                    </div>

                        
                  <br><br>
                    <div class="form-group">
                   <?php
                    $pdo = new PDO('mysql:host=sql6.freesqldatabase.com; dbname=sql6458239', 'sql6458239', 'Tl1Xl4vVI5');
                    $sql = "SELECT C_id, C_name FROM customer";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    ?>

                    <select name="customer" 
                    class="form-control" >
                    <option value="" disabled="disabled" selected>please select a customer</option>

                        <?php foreach($users as $user): ?>
                    <option value="<?= $user['C_id']; ?>"><?= $user['C_name']; ?></option>
                    <?php endforeach; ?>
                    </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-default" form="addOrderForm">Add</button>
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

<!-- Order details container -->
<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 50%;" id="newmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id='order-ID' style="color:#000000"></h4>
            </div>

            <!-- continue with Order Details pop up details -->
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
                <form action="./odelete.php" method="post" enctype="multipart/form-data">
                <input type='text' name='O_id' id='pid' class='username' value="">
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


    $(function() {
        $(".max-button").click(function() {
            $("#order-details").modal('show');
        });
    });
// <!-- Update and Delete Form Showing functions -->

    function showOrderDetails(Oid){
        document.getElementByID('order-ID').innerHTML = Oid;
    }

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
            <?php
                        function addProduct()
                        {
                            
        
                         }
                    
                ?>    
</body>

</html>