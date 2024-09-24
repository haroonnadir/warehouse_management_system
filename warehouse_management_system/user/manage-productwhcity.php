<?php require_once 'main.php'; ?>
<div class="wrapper d-flex align-items-stretch">
    <?php require_once 'nav.php'; ?>
    <!-- Page Content  -->
    <div id="content" class="p-4">
        <?php require_once 'left-side.php' ?>
        <div class="section-title">
            <h2>ADMIN ||Product in WH CITY</h2>
        </div>
        <table class="table md-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Product Name</th>
                    <th>Warehouse</th>
                    <th>Quantity</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php 
              $joinquery = "SELECT piw.id, p.name AS product_name, w.location AS warehouse_location, piw.quantity FROM products_in_warehouses piw JOIN Products p ON piw.product_id = p.id JOIN Warehouses w ON piw.warehouse_id = w.id";
              $john=mysqli_query($db,$joinquery);
              $count=0;
              while ($show=mysqli_fetch_array($john)) {
                $count++;
              ?>
            <tbody>
                <tr>
                    <th scope="row"><?php echo $count ?></th>
                    <td><?php echo $show['product_name']; ?></td>
                    <td><?php echo $show['warehouse_location']; ?></td>
                    <td><?php echo $show['quantity']; ?></td>
                    <td style="cursor:pointer">
                        <a href="prowhcity-update.php?id=<?php echo $show['id'];?>"><i class="fa fa-edit"></i></a>
                    </td>
                </tr>
            </tbody>
            <?php }?>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>