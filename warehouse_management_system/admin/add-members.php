<?php require_once 'main.php' ?>
<?php
  if(isset($_POST['add-btn'])){
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $number   = $_POST['number'];
    $role     = 'user';
    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
    $permissions_str = implode(',', $permissions); // Convert array to comma-separated string
    $check_email = $db->query("SELECT * FROM users WHERE email = '$email'");
    if($check_email->num_rows > 0){
            echo "<script>alert('Email already exist.');</script>";
            echo "<script>window.location.href ='manage-members.php'</script>";
    }else
    {
      $insert = $db->query("INSERT INTO users (name,email,password,number,role,permissions,status) VALUES ('$name','$email','$password','$number','$role','$permissions_str',1)");
      if($insert){
        echo "<script>alert('User Suceessfully Added.');</script>";
        echo "<script>window.location.href ='manage-members.php'</script>";
      }else{
        echo "<script>alert('Something Went Wrong.');</script>";
        echo "<script>window.location.href ='manage-members.php'</script>";
      }
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
            <h2>ADMIN || ADD-MEMBERS</h2>
        </div>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="floatingInputUsername" placeholder="Your Name"
                    required>
                <label for="floatingInputUsername">Your name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                    required>
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password"
                    required>
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="number" class="form-control" id="floatingnumber" placeholder="Number"
                    required>
                <label for="floatingnumber">Number</label>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="edit"
                        id="flexCheckEdit">
                    <label class="form-check-label" for="flexCheckEdit">
                        Edit
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="delete"
                        id="flexCheckDelete">
                    <label class="form-check-label" for="flexCheckDelete">
                        Delete
                    </label>
                </div>
            </div>
            <div class="mb-0">
                <button type="submit" name="add-btn" class="btn btn-warning">SAVE</button>
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