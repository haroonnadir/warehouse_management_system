<?php require_once 'main.php' ?>
<?php
  if(isset($_POST['save'])){
    $product_id = $_POST['product_id'];
    $warehouse_id = $_POST['warehouse_id'];
    $quantity = $_POST['quantity'];
      $insert = $db->query("INSERT INTO products_in_warehouses (product_id, warehouse_id, quantity)
       VALUES ('$product_id', '$warehouse_id', '$quantity')");
      if($insert){
        echo "<script>alert('products in warehouses Suceessfully Added.');</script>";
        echo "<script>window.location.href ='manage-productwhcity.php'</script>";
      }else{
        echo "<script>alert('Something Went Wrong.');</script>";
        echo "<script>window.location.href ='manage-productwhcity.php'</script>";
      }
    
}

?>
<div class="wrapper d-flex align-items-stretch">
    <?php require_once 'nav.php'; ?>
    <!-- Page Content  -->
    <div id="content" class="p-4">
        <?php require_once 'left-side.php' ?>
        <!-- start: BASIC EXAMPLE -->
        <div class="section-title">
            <h2>ADMIN || Product IN CITY</h2>
        </div>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <select name="product_id" class="form-select" id="product_id" required>
                    <option value="">Select Product</option>
                    <?php
                                    // Fetch products from Products table
                        $product_query = $db->query("SELECT * FROM Products");
                        while($product_row = $product_query->fetch_assoc()) {
                                        echo '<option value="'.$product_row['id'].'">'.$product_row['name'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="product_id">Select Product</label>
            </div>
            <div class="form-floating mb-3">
                <select name="warehouse_id" class="form-select" id="warehouse_id" required>
                    <option value="">Select Warehouse</option>
                    <?php
                                    // Fetch warehouses from Warehouses table
                                    $warehouse_query = $db->query("SELECT * FROM Warehouses");
                                    while($warehouse_row = $warehouse_query->fetch_assoc()) {
                                        echo '<option value="'.$warehouse_row['id'].'">'.$warehouse_row['location'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="warehouse_id">Select Warehouse</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity"
                    required>
                <label for="quantity">Quantity</label>
            </div>
            <div class="mb-0">
                <input type="submit" value="SAVE" name="save" class="btn btn-warning">
            </div>
        </form>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>