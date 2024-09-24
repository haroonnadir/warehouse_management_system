<?php require_once 'main.php' ?>
<?php
  if(isset($_POST['save'])){
    $account_name = $_POST['account_name'];
    $account_type = $_POST['account_type'];
    $parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : null;
      $insert = $db->query("INSERT INTO chartofaccounts (account_name, account_type, parent_id) VALUES ('$account_name', '$account_type', " . ($parent_id ? $parent_id : "NULL") . ")");
      if($insert){
        echo "<script>alert('Charts Account Suceessfully Added.');</script>";
        echo "<script>window.location.href ='manage-charts-account.php'</script>";
      }else{
        echo "<script>alert('Something Went Wrong.');</script>";
        echo "<script>window.location.href ='manage-charts-account.php'</script>";
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
            <h2>ADMIN || Charts Account</h2>
        </div>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" name="account_name" class="form-control" id="account_name" required>
                <label for="account_name">Account Name</label>
            </div>
            <div class="form-floating mb-3">
                <select name="account_type" class="form-select" id="account_type" required>
                    <option value="parent">Parent</option>
                    <option value="control">Control</option>
                    <option value="ledger">Ledger</option>
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
                                        echo '<option value="'.$parent_row['id'].'">'.$parent_row['account_name'].'</option>';
                                    }
                                    ?>
                </select>
                <label for="parent_id">Parent Account</label>
            </div>
            <div class="mb-3">
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