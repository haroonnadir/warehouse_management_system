<?php require_once 'main.php' ?>
<?php
  if(isset($_POST['save'])){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];
      $insert = $db->query("INSERT INTO products (name, brand, description) VALUES ('$name', '$brand', '$description')");
      if($insert){
        echo "<script>alert('Prodcuct Suceessfully Added.');</script>";
        echo "<script>window.location.href ='manage-product.php'</script>";
      }else{
        echo "<script>alert('Something Went Wrong.');</script>";
        echo "<script>window.location.href ='manage-product.php'</script>";
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
                <input type="text" name="name" class="form-control" id="product-name" value="">
                <label for="product-name">product Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="brand" class="form-control" id="product-brand" value="">
                <label for="product-brand">product Brand</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="description" class="form-control" id="product-description" value="">
                <label for="product-description">product description</label>
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