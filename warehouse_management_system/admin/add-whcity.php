<?php require_once 'main.php' ?>
<?php
  if(isset($_POST['save'])){
    $name = $_POST['name'];
    $location = $_POST['location'];
    $city = $_POST['city'];
      $insert = $db->query("INSERT INTO warehouses (name, location, city) VALUES ('$name', '$location', '$city')");
      if($insert){
        echo "<script>alert('WH City Suceessfully Added.');</script>";
        echo "<script>window.location.href ='manage-whcity.php'</script>";
      }else{
        echo "<script>alert('Something Went Wrong.');</script>";
        echo "<script>window.location.href ='manage-whcity.php'</script>";
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
            <h2>ADMIN || WH CITY</h2>
        </div>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="product-name" value="">
                <label for="product-name">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="location" class="form-control" id="product-location" value="">
                <label for="product-location">location</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="city" class="form-control" id="product-city" value="">
                <label for="product-city">city</label>
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