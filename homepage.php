
    
<?php
include_once 'header.php';
session_start();
//$_SESSION["userid"] = $uidExists["U_id"];

$username = $_SESSION['username'];
$U_id = $_SESSION['U_id'];
echo("<script>console.log('PHP: " . $username . "');</script>");


?>
  
<link rel="stylesheet" href="./css/homepage.css">
    <!--CSS-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 
 <!--JS--><main class='main-container'>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?php 
    require_once 'db.php';
    echo("<script>console.log('PHP: " . $username . "');</script>");

    $sql = "SELECT  `P_id`,`P_name`, `p_quantity`, `p_sellingprice` FROM `inventory` where U_id= ?";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "<script>console.log('error bro')</script>";
    }

    mysqli_stmt_bind_param($stmt, "s", $U_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

   // if($row = mysqli_fetch_assoc($resultData)){
       if(mysqli_num_rows($resultData)>0){
        while($row = $resultData->fetch_assoc()) {
        echo"
        <div class='product-item'> 
            <div class='image-box'>  
                <img src='./resources/images/product.jpg' alt='' class='product-image'>
                     <div class='edit'>
                            <div class='edit-im'>
    
                            <a></a>
                                <img src='./resources/images/edit.png' onclick='document.getElementById('edit-product').style.display='block'' alt=''>
                            </div>
                            <div class='edit-delete'>
                                <img src='./resources/images/delete.png' alt=''>
                                <script>console.log('PHP: " . $row['P_id'] . "');</script>
                            </div>        
                     </div>
                                <div class='product-desc'>
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
    $data[]="";
    $result = mysqli_query( $conn, $sql);
    

   //echo("<script>console.log('PHP: " . $result . "');</script>");

    // if (mysqli_num_rows($result) > 0) {
    //     while($row = $result->fetch_assoc()) {
          
    //         echo" 

    // <div class='product-item'> 
    //     <div class='image-box'>  
    //         <img src='./resources/images/product.jpg' alt='' class='product-image'>
    //              <div class='edit'>
    //                     <div class='edit-im'>

    //                     <a></a>
    //                         <img src='./resources/images/edit.png' onclick='document.getElementById('edit-product').style.display='block'' alt=''>
    //                     </div>
    //                     <div class='edit-delete'>
    //                         <img src='./resources/images/delete.png' alt=''>
    //                         <script>console.log('PHP: " . $row['P_id'] . "');</script>
    //                     </div>        
    //              </div>
    //                         <div class='product-desc'>
    //                         <h1 class='p-name'> {$row['P_name']}  </h1>
    //                         <h3 class='desc'>Quantity: {$row['P_quantity']}</h3>
    //                         <h3 class='desc'>Price:{$row['P_sellingprice']}</h3>
    //                     </div>
    //              </div>            
    //      </div> ";    
    //     }
    //   }  
      
    //   else {
    // echo "0 results";
    // }
    
?>    
  
</div>
</main>


<form action="" id="edit-product">
    <input type="text" name="quantity" placeholder="Quantity" class="edit-input">
    <input type="text" name="price" placeholder="price" class="edit-input">
    <button name="submit" value="Submit">Submit</button>
</form>

<a href="#" class="float">
<span class="glyphicon glyphicon-plus my-float"></span>
</a>

<div style="position:fixed; top:50%; left:50%; transform: translate(-50%, -50%);   width: 50%;" id="newmodal" class="modal fade" role="dialog" >
<div class="modal-dialog modal-md">
 
<div class="modal-content">
<div class="modal-header">
 
<h4 class="modal-title" style="color:#000000">
Add New Product
</h4>
</div>
<div class="modal-body">
<form action="./add.php" method="post">
<div class="form-group">
<input type="text" class="form-control" name="name" style="width:100%" placeholder="Enter product name!"  required>
</div>
<div class="form-group">
<input type="text" class="form-control" name="quantity" style="width:100%" placeholder="Enter product Quantity!"  required>
</div>
<div class="form-group">
<input type="text" class="form-control" name="costperitem" style="width:100%" placeholder="Enter cost per item!"  required>
</div>
<div class="form-group">
<input type="text" class="form-control" name="sellingprice" style="width:100%" placeholder="Enter selling price!"  required>
</div>
<div class="form-group">
<button type="submit" name="submit" class="btn btn-default">Add</button>
</div>
</form>
</div>
</div>
</div>
</div>

<script>
$(function() { 
  $(".float").click(function() {  
   $("#newmodal").modal('show');
  });
});
</script>


</body>

</html>