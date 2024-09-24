<?php require_once 'main.php' ?>
<?php
  if(isset($_POST['save'])){
    $product_id = $_POST['product_id'];
    $source_warehouse_id = $_POST['source_warehouse_id'];
    $destination_warehouse_id = $_POST['destination_warehouse_id'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $remarks = $_POST['remarks'];
    $date = $_POST['date'];
      $insert = $db->query("INSERT INTO Inventory (product_id, source_warehouse_id, destination_warehouse_id, type, quantity, date, remarks)
                             VALUES ('$product_id', '$source_warehouse_id', '$destination_warehouse_id', '$type', '$quantity', '$date', '$remarks')");
      if($insert){
        echo "<script>alert('Inventry Suceessfully Added.');</script>";
        echo "<script>window.location.href ='manage-inventry.php'</script>";
      }else{
        echo "<script>alert('Something Went Wrong.');</script>";
        echo "<script>window.location.href ='manage-inventry.php'</script>";
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
            <h2>ADMIN || Product</h2>
        </div>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <select name="source_warehouse_id" class="form-select" id="source_warehouse_id" required>
                    <option value="">Select Source Warehouse</option>
                    <?php
                                    // Fetch warehouses from Warehouses table
                                    $warehouse_query = $db->query("SELECT * FROM Warehouses");
                                    while($warehouse_row = $warehouse_query->fetch_assoc()) {
                                        echo '<option value="'.$warehouse_row['id'].'">'.$warehouse_row['location'].'</option>';
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
                                        echo '<option value="'.$warehouse_row['id'].'">'.$warehouse_row['location'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="destination_warehouse_id">Select Destination Warehouse</label>
            </div>
            <div class="form-floating mb-3">
                <select name="type" class="form-select" id="type" required>
                    <option value="">Select Transaction Type</option>
                    <option value="in">In</option>
                    <option value="out">Out</option>
                </select>
                <label for="type">Transaction Type</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity"
                    required>
                <label for="quantity">Quantity</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="remarks" class="form-control" id="remarks" placeholder="Enter Remarks">
                <label for="remarks">Remarks</label>
            </div>
            <div class="form-floating mb-3">
                <input type="datetime-local" name="date" class="form-control" id="date" required>
                <label for="date">Date</label>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// jQuery script to handle dynamic dropdowns
$(document).ready(function() {
    // Fetch products based on selected source warehouse
    $('#source_warehouse_id').change(function() {
        var warehouse_id = $(this).val();
        if (warehouse_id != '') {
            $.ajax({
                url: 'fetch_products.php', // PHP script to fetch products based on warehouse ID
                type: 'post',
                data: {
                    warehouse_id: warehouse_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $('#product_id').empty();
                    $('#product_id').append("<option value=''>Select Product</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $('#product_id').append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            $('#product_id').empty();
            $('#product_id').append("<option value=''>Select Source Warehouse First</option>");
        }
    });
});
</script>
</body>

</html>