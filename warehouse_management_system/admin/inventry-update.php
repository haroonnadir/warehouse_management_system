<?php
require_once 'main.php';
$id= $_GET['id'];
//UPDATE DATE 
if (isset($_POST['update-btn'])) {
    $product_id = $_POST['product_id'];
    $source_warehouse_id = $_POST['source_warehouse_id'];
    $destination_warehouse_id = $_POST['destination_warehouse_id'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $remarks = $_POST['remarks'];
    $date = $_POST['date'];

  $query ="UPDATE Inventory SET product_id = '$product_id', source_warehouse_id = '$source_warehouse_id', destination_warehouse_id = '$destination_warehouse_id', type = '$type', quantity = '$quantity', remarks = '$remarks', date = '$date' WHERE id = '$id'";
  $run = mysqli_query($db, $query) or die("ERROR");
  echo "<script>alert('Inventory Update Suceessfully.');</script>";
  echo "<script>window.location.href ='manage-inventry.php'</script>";
}

//DELETE DATA
if (isset($_POST['delete-btn'])) {
    $query = "DELETE FROM Inventory WHERE id='$id'";
    $run = mysqli_query($db, $query);
    echo "<script>alert('Inventory Delete Suceessfully.');</script>";
    echo "<script>window.location.href ='manage-inventry.php'</script>";
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
        $query= "SELECT * FROM Inventory WHERE id='$id'";
        $result=mysqli_query($db,$query);
        if (mysqli_num_rows($result)>0) {
            while ($show= mysqli_fetch_assoc($result)){        
                $product_id = $show['product_id'];
                $source_warehouse_id = $show['source_warehouse_id'];
                $destination_warehouse_id = $show['destination_warehouse_id'];
                $type = $show['type'];
                $quantity = $show['quantity'];
                $remarks = $show['remarks'];
                $date = $show['date'];
            ?>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <select name="source_warehouse_id" class="form-select" id="source_warehouse_id" required>
                    <option value="">Select Source Warehouse</option>
                    <?php
                                    // Fetch warehouses from Warehouses table
                                    $warehouse_query = $db->query("SELECT * FROM Warehouses");
                                    while($warehouse_row = $warehouse_query->fetch_assoc()) {
                                        $selected = ($warehouse_row['id'] == $source_warehouse_id) ? 'selected' : '';
                                        echo '<option value="'.$warehouse_row['id'].'" '.$selected.'>'.$warehouse_row['location'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="source_warehouse_id">Select Source Warehouse</label>
            </div>
            <div class="form-floating mb-3">
                <select name="product_id" class="form-select" id="product_id" required>
                    <option value="">Select Source Warehouse First</option>
                </select>
                <label for="product_id">Select Product</label>
            </div>
            <div class="form-floating mb-3">
                <select name="destination_warehouse_id" class="form-select" id="destination_warehouse_id" required>
                    <option value="">Select Destination Warehouse</option>
                    <?php
                                    // Fetch warehouses from Warehouses table
                                    $warehouse_query = $db->query("SELECT * FROM Warehouses");
                                    while($warehouse_row = $warehouse_query->fetch_assoc()) {
                                        $selected = ($warehouse_row['id'] == $destination_warehouse_id) ? 'selected' : '';
                                        echo '<option value="'.$warehouse_row['id'].'" '.$selected.'>'.$warehouse_row['location'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="destination_warehouse_id">Select Destination Warehouse</label>
            </div>
            <div class="form-floating mb-3">
                <select name="type" class="form-select" id="type" required>
                    <option value="">Select Transaction Type</option>
                    <option value="in" <?php echo ($type == 'in') ? 'selected' : ''; ?>>In</option>
                    <option value="out" <?php echo ($type == 'out') ? 'selected' : ''; ?>>Out</option>
                </select>
                <label for="type">Transaction Type</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="quantity" class="form-control" id="quantity" value="<?php echo $quantity; ?>"
                    required>
                <label for="quantity">Quantity</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="remarks" class="form-control" id="remarks" value="<?php echo $remarks; ?>">
                <label for="remarks">Remarks</label>
            </div>
            <div class="form-floating mb-3">
                <input type="datetime-local" name="date" class="form-control" id="date"
                    value="<?php echo date('Y-m-d\TH:i', strtotime($date)); ?>" required>
                <label for="date">Date</label>
            </div>
            <div class="mb-0">
                <input type="submit" value="Update Inventory Transaction" name="update_inventory"
                    class="btn btn-dark px-5 p-3">
                <a href="admin-inventory.php" class="btn btn-secondary p-3">Cancel</a>
            </div>
        </form>
        <?php }} ?>
    </div>
</div>