<?php
require_once 'main.php';
$id= $_GET['id'];
//UPDATE DATE 
if (isset($_POST['update-btn'])) {
  $name     = $_POST['name'];
  $location    = $_POST['location'];
  $city = $_POST['city'];

  $query ="UPDATE warehouses SET name = '$name', location = '$location', 
  city = '$city' WHERE id='$id'";
  $run = mysqli_query($db, $query) or die("ERROR");
  echo "<script>alert('WH city Update Suceessfully.');</script>";
  echo "<script>window.location.href ='manage-whcity.php'</script>";
}

//DELETE DATA
if (isset($_POST['delete-btn'])) {
    $query = "DELETE FROM warehouses WHERE id='$id'";
    $run = mysqli_query($db, $query);
    echo "<script>alert('product Delete Suceessfully.');</script>";
    echo "<script>window.location.href ='manage-whcity.php'</script>";
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
        $query= "SELECT * FROM warehouses WHERE id='$id'";
        $result=mysqli_query($db,$query);
        if (mysqli_num_rows($result)>0) {
            while ($show= mysqli_fetch_assoc($result)){        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row d-flex align-items-center mb-3">
                <div class="form-floating mb-3">
                    <input type="text" name="name" value="<?php echo $show['name']; ?>" class="form-control"
                        id="floatingInputUsername" placeholder="Your Name" required>
                    <label for="floatingInputUsername">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="location" value="<?php echo $show['location'];; ?>" class="form-control"
                        id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">location</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="city" name="city" value="<?php echo $show['city'];; ?>"
                        class="form-control" id="floatingcity" placeholder="city" required>
                    <label for="floatingcity">city</label>
                </div>
                <div class="mb-0">
                    <button type="submit" name="update-btn" class="btn btn-warning">UPDATE</button>
                    <button type="submit" name="delete-btn" class="btn btn-danger">DELETE</button>
                </div>
        </form>
        <?php }} ?>
    </div>
</div>