<?php require_once 'main.php'; ?>
<div class="wrapper d-flex align-items-stretch">
    <?php require_once 'nav.php'; ?>
    <!-- Page Content  -->
    <div id="content" class="p-4">
        <?php require_once 'left-side.php' ?>
        <div class="section-title">
            <h2>ADMIN || INVENTORY</h2>
        </div>
        <table class="table md-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Product</th>
                    <th>Source Warehouse</th>
                    <th>Destination Warehouse</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Remarks</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php 
              $joinquery = "SELECT i.id, p.name AS product_name, sw.location AS source_warehouse, dw.location AS destination_warehouse, i.type, i.quantity, i.date, i.remarks FROM Inventory i JOIN Products p ON i.product_id = p.id LEFT JOIN Warehouses sw ON i.source_warehouse_id = sw.id LEFT JOIN Warehouses dw ON i.destination_warehouse_id = dw.id";
              $john=mysqli_query($db,$joinquery);
              $count=0;
              while ($show=mysqli_fetch_array($john)) {
                $count++;
              ?>
            <tbody>
                <tr>
                    <th scope="row"><?php echo $count ?></th>
                    <td><?php echo $show['product_name']; ?></td>
                    <td><?php echo $show['source_warehouse']; ?></td>
                    <td><?php echo $show['destination_warehouse']; ?></td>
                    <td><?php echo ucfirst($show['type']); ?></td>
                    <td><?php echo $show['quantity']; ?></td>
                    <td><?php echo date('M d, Y H:i:s', strtotime($show['date'])); ?></td>
                    <td><?php echo $show['remarks']; ?></td>
                    <td style="cursor:pointer">
                        <a href="inventry-update.php?id=<?php echo $show['id'];?>"><i class="fa fa-edit"></i></a>
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