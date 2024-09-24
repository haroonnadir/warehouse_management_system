<?php
require_once 'main.php';
$id= $_GET['id'];
//UPDATE DATE 
if (isset($_POST['update-btn'])) {
  $name     = $_POST['name'];
  $brand    = $_POST['brand'];
  $description = $_POST['description'];

  $query ="UPDATE products SET name = '$name', brand = '$brand', 
  description = '$description' WHERE id='$id'";
  $run = mysqli_query($db, $query) or die("ERROR");
  echo "<script>alert('product Update Suceessfully.');</script>";
  echo "<script>window.location.href ='manage-product.php'</script>";
}

//DELETE DATA
if (isset($_POST['delete-btn'])) {
    $query = "DELETE FROM products WHERE id='$id'";
    $run = mysqli_query($db, $query);
    echo "<script>alert('product Delete Suceessfully.');</script>";
    echo "<script>window.location.href ='manage-product.php'</script>";
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
        $query= "SELECT * FROM products WHERE id='$id'";
        $result=mysqli_query($db,$query);
        if (mysqli_num_rows($result)>0) {
            while ($show= mysqli_fetch_assoc($result)){        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row d-flex align-items-center mb-3">
                <div class="form-floating mb-3">
                    <input type="text" name="name" value="<?php echo $show['name']; ?>" class="form-control"
                        id="floatingInputUsername" placeholder="Your Name" required>
                    <label for="floatingInputUsername">Your name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="brand" value="<?php echo $show['brand'];; ?>" class="form-control"
                        id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">brand</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="description" name="description" value="<?php echo $show['description'];; ?>"
                        class="form-control" id="floatingdescription" placeholder="description" required>
                    <label for="floatingdescription">description</label>
                </div>
                <div class="mb-0">
                    <button type="submit" name="update-btn" class="btn btn-warning">UPDATE</button>
                    <button type="submit" name="delete-btn" class="btn btn-danger">DELETE</button>
                </div>
        </form>
        <?php }} ?>
    </div>
</div>