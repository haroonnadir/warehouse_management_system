<?php
require_once 'main.php';
$id= $_GET['id'];
//UPDATE DATE 
if (isset($_POST['update-btn'])) {
    $account_name = $_POST['account_name'];
    $account_type = $_POST['account_type'];
    $parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : null;

  $query ="UPDATE chartofaccounts SET account_name = '$account_name', account_type = '$account_type', parent_id = " . ($parent_id ? $parent_id : "NULL") . " WHERE id = '$edit_id'";
  $run = mysqli_query($db, $query) or die("ERROR");
  echo "<script>alert('Charts of Account Update Suceessfully.');</script>";
  echo "<script>window.location.href ='manage-charts-account.php'</script>";
}

//DELETE DATA
if (isset($_POST['delete-btn'])) {
    $query = "DELETE FROM chartofaccounts WHERE id='$id'";
    $run = mysqli_query($db, $query);
    echo "<script>alert('Charts of Account Delete Suceessfully.');</script>";
    echo "<script>window.location.href ='manage-charts-account.php'</script>";
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
        $query= "SELECT * FROM chartofaccounts WHERE id='$id'";
        $result=mysqli_query($db,$query);
        if (mysqli_num_rows($result)>0) {
            while ($show= mysqli_fetch_assoc($result)){        
                $account_name = $show['account_name'];
                $account_type = $show['account_type'];
                $parent_id = $show['parent_id'];
            ?>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" name="account_name" class="form-control" id="account_name"
                    value="<?php echo $account_name; ?>" required>
                <label for="account_name">Account Name</label>
            </div>
            <div class="form-floating mb-3">
                <select name="account_type" class="form-select" id="account_type" required>
                    <option value="parent" <?php echo ($account_type == 'parent') ? 'selected' : ''; ?>>Parent</option>
                    <option value="control" <?php echo ($account_type == 'control') ? 'selected' : ''; ?>>Control
                    </option>
                    <option value="ledger" <?php echo ($account_type == 'ledger') ? 'selected' : ''; ?>>Ledger</option>
                </select>
                <label for="account_type">Account Type</label>
            </div>
            <div class="form-floating mb-3">
                <select name="parent_id" class="form-select" id="parent_id">
                    <option value="">No Parent</option>
                    <?php
                                    // Fetch parent accounts
                                    $parent_query = $db->query("SELECT * FROM chartofaccounts WHERE account_type != 'ledger'");
                                    while($parent_row = $parent_query->fetch_assoc()) {
                                        $selected = ($parent_row['id'] == $parent_id) ? 'selected' : '';
                                        echo '<option value="'.$parent_row['id'].'" '.$selected.'>'.$parent_row['account_name'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="parent_id">Parent Account</label>
            </div>
            <div class="mb-3">
                <button type="submit" name="update-btn" class="btn btn-warning">UPDATE</button>
                <button type="submit" name="delete-btn" class="btn btn-danger">DELETE</button>
            </div>
        </form>
        <?php }} ?>
    </div>
</div>