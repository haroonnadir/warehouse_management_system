<?php
require_once 'main.php';
$id= $_GET['id'];
//UPDATE DATE 
if (isset($_POST['update-btn'])) {
    $product_id = $_POST['product_id'];
    $warehouse_id = $_POST['warehouse_id'];
    $quantity = $_POST['quantity'];

  $query ="UPDATE products_in_warehouses SET product_id = '$product_id', warehouse_id = '$warehouse_id', 
  quantity = '$quantity' WHERE id='$id'";
  $run = mysqli_query($db, $query) or die("ERROR");
  echo "<script>alert('Product in WH city Update Suceessfully.');</script>";
  echo "<script>window.location.href ='manage-productwhcity.php'</script>";
}

//DELETE DATA
if (isset($_POST['delete-btn'])) {
    $query = "DELETE FROM products_in_warehouses WHERE id='$id'";
    $run = mysqli_query($db, $query);
    echo "<script>alert('Product in WH city Delete Suceessfully.');</script>";
    echo "<script>window.location.href ='manage-productwhcity.php'</script>";
  }
?>
<div class="wrapper d-flex align-items-stretch">
    <?php require_once 'nav.php' ?>
    <!-- Page Content  -->
    <div id="content" class="p-4">
        <?php require_once 'left-side.php' ?>
        <!-- start: BASIC EXAMPLE -->
        <div class="section-title">
            <h2>ADMIN || UPDATE</h2>
        </div>
        <?php     
        $query= "SELECT * FROM products_in_warehouses WHERE id='$id'";
        $result=mysqli_query($db,$query);
        if (mysqli_num_rows($result)>0) {
            while ($show= mysqli_fetch_assoc($result)){        
                $product_id = $show['product_id'];
                $warehouse_id = $show['warehouse_id'];
                $quantity = $show['quantity'];
            ?>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <select name="product_id" class="form-select" id="product_id" required>
                    <option value="">Select Product</option>
                    <?php
                                    // Fetch products from Products table
                                    $product_query = $db->query("SELECT * FROM Products");
                                    while($product_row = $product_query->fetch_assoc()) {
                                        $selected = ($product_row['id'] == $product_id) ? 'selected' : '';
                                        echo '<option value="'.$product_row['id'].'" '.$selected.'>'.$product_row['name'].'</option>';
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
                                        $selected = ($warehouse_row['id'] == $warehouse_id) ? 'selected' : '';
                                        echo '<option value="'.$warehouse_row['id'].'" '.$selected.'>'.$warehouse_row['location'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="warehouse_id">Select Warehouse</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="quantity" class="form-control" id="quantity" value="<?php echo $quantity; ?>"
                    required>
                <label for="quantity">Quantity</label>
            </div>
            <div class="mb-0">
                <button type="submit" name="update-btn" class="btn btn-warning">UPDATE</button>
                <button type="submit" name="delete-btn" class="btn btn-danger">DELETE</button>
            </div>
        </form>
        <?php }} ?>
    </div>
</div>