
<?php require_once 'main.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<?php

function getInventoryReport($db) {
    $sql = "SELECT p.id, p.name, p.brand, piw.quantity, w.location 
            FROM products p
            JOIN products_in_warehouses piw ON p.id = piw.product_id
            JOIN warehouses w ON piw.warehouse_id = w.id
            ORDER BY w.location, p.name";
    return $db->query($sql);
}


function getStockAgingReport($db) {
    $sql = "SELECT p.id, p.name, piw.quantity, w.location, 
            DATEDIFF(CURDATE(), MAX(i.date)) as days_in_stock
            FROM products p
            JOIN products_in_warehouses piw ON p.id = piw.product_id
            JOIN warehouses w ON piw.warehouse_id = w.id
            LEFT JOIN inventory i ON p.id = i.product_id AND i.type = 'in'
            GROUP BY p.id, w.id
            ORDER BY days_in_stock DESC";
    return $db->query($sql);
}


function getStockValueReport($db) {
    $sql = "SELECT p.id, p.name, piw.quantity, w.location, 
            COALESCE(t.unit_price, 0) as unit_price, 
            (piw.quantity * COALESCE(t.unit_price, 0)) as total_value
            FROM products p
            JOIN products_in_warehouses piw ON p.id = piw.product_id
            JOIN warehouses w ON piw.warehouse_id = w.id
            LEFT JOIN (
                SELECT product_id, unit_price
                FROM transactions
                WHERE unit_price IS NOT NULL
                GROUP BY product_id
                HAVING MAX(date)
            ) t ON p.id = t.product_id
            ORDER BY total_value DESC";
    return $db->query($sql);
}


function getStockMovementReport($db) {
    $sql = "SELECT p.id, p.name, i.type, i.quantity, i.date, 
            sw.location as source, dw.location as destination
            FROM inventory i
            JOIN products p ON i.product_id = p.id
            LEFT JOIN warehouses sw ON i.source_warehouse_id = sw.id
            LEFT JOIN warehouses dw ON i.destination_warehouse_id = dw.id
            ORDER BY i.date DESC
            LIMIT 100";
    return $db->query($sql);
}


function getItemWiseReport($db) {
    $sql = "SELECT p.id, p.name, p.brand, 
            SUM(CASE WHEN i.type = 'in' THEN i.quantity ELSE 0 END) as total_in,
            SUM(CASE WHEN i.type = 'out' THEN i.quantity ELSE 0 END) as total_out,
            SUM(CASE WHEN i.type = 'in' THEN i.quantity ELSE -i.quantity END) as net_quantity
            FROM products p
            LEFT JOIN inventory i ON p.id = i.product_id
            GROUP BY p.id
            ORDER BY net_quantity DESC";
    return $db->query($sql);
}


function getDayWiseReport($db) {
    $sql = "SELECT DATE(i.date) as date, 
            SUM(CASE WHEN i.type = 'in' THEN i.quantity ELSE 0 END) as total_in,
            SUM(CASE WHEN i.type = 'out' THEN i.quantity ELSE 0 END) as total_out
            FROM inventory i
            WHERE i.date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY DATE(i.date)
            ORDER BY date DESC";
    return $db->query($sql);
}


function getWeekWiseReport($db) {
    $sql = "SELECT YEARWEEK(i.date) as year_week, 
            SUM(CASE WHEN i.type = 'in' THEN i.quantity ELSE 0 END) as total_in,
            SUM(CASE WHEN i.type = 'out' THEN i.quantity ELSE 0 END) as total_out
            FROM inventory i
            WHERE i.date >= DATE_SUB(CURDATE(), INTERVAL 12 WEEK)
            GROUP BY YEARWEEK(i.date)
            ORDER BY year_week DESC";
    return $db->query($sql);
}


function getMonthWiseReport($db) {
    $sql = "SELECT DATE_FORMAT(i.date, '%Y-%m') as month, 
            SUM(CASE WHEN i.type = 'in' THEN i.quantity ELSE 0 END) as total_in,
            SUM(CASE WHEN i.type = 'out' THEN i.quantity ELSE 0 END) as total_out
            FROM inventory i
            WHERE i.date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(i.date, '%Y-%m')
            ORDER BY month DESC";
    return $db->query($sql);
}


function getBrandWiseReport($db) {
    $sql = "SELECT p.brand, 
            SUM(CASE WHEN i.type = 'in' THEN i.quantity ELSE 0 END) as total_in,
            SUM(CASE WHEN i.type = 'out' THEN i.quantity ELSE 0 END) as total_out,
            SUM(CASE WHEN i.type = 'in' THEN i.quantity ELSE -i.quantity END) as net_quantity
            FROM products p
            LEFT JOIN inventory i ON p.id = i.product_id
            GROUP BY p.brand
            ORDER BY net_quantity DESC";
    return $db->query($sql);
}


function getCityWiseWarehouseReport($db) {
    $sql = "SELECT w.location, p.name, p.brand, piw.quantity
            FROM warehouses w
            JOIN products_in_warehouses piw ON w.id = piw.warehouse_id
            JOIN products p ON piw.product_id = p.id
            ORDER BY w.location, p.name";
    return $db->query($sql);
}

?>
<div class="wrapper d-flex align-items-stretch">
    <?php require_once 'nav.php'; ?>
    <!-- Page Content  -->
    <div id="content" class="p-4">
        <?php require_once 'left-side.php' ?>
        <!-- start: BASIC EXAMPLE -->
        <div class="section-title">
            <h2>ADMIN || Reports</h2>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="mt-3">Reports</h3>
                    <div class="accordion" id="reportsAccordion">
                        <!-- Inventory Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingInventory">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseInventory" aria-expanded="true"
                                    aria-controls="collapseInventory">
                                    Inventory Report
                                </button>
                            </h2>
                            <div id="collapseInventory" class="accordion-collapse collapse show"
                                aria-labelledby="headingInventory" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Name</th>
                                                <th>Brand</th>
                                                <th>Quantity</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $inventoryResult = getInventoryReport($db);
                                            while ($row = $inventoryResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['id']}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['brand']}</td>
                                                        <td>{$row['quantity']}</td>
                                                        <td>{$row['location']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Aging Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingStockAging">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseStockAging" aria-expanded="false"
                                    aria-controls="collapseStockAging">
                                    Stock Aging Report
                                </button>
                            </h2>
                            <div id="collapseStockAging" class="accordion-collapse collapse"
                                aria-labelledby="headingStockAging" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Location</th>
                                                <th>Days in Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $agingResult = getStockAgingReport($db);
                                            while ($row = $agingResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['id']}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['quantity']}</td>
                                                        <td>{$row['location']}</td>
                                                        <td>{$row['days_in_stock']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Value Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingStockValue">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseStockValue" aria-expanded="false"
                                    aria-controls="collapseStockValue">
                                    Stock Value Report
                                </button>
                            </h2>
                            <div id="collapseStockValue" class="accordion-collapse collapse"
                                aria-labelledby="headingStockValue" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Location</th>
                                                <th>Unit Price</th>
                                                <th>Total Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $valueResult = getStockValueReport($db);
                                            while ($row = $valueResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['id']}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['quantity']}</td>
                                                        <td>{$row['location']}</td>
                                                        <td>₨ " . number_format($row['unit_price'], 2) . "</td>
                                                        <td>₨ " . number_format($row['total_value'], 2) . "</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Movement Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingStockMovement">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseStockMovement" aria-expanded="false"
                                    aria-controls="collapseStockMovement">
                                    Stock Movement Report
                                </button>
                            </h2>
                            <div id="collapseStockMovement" class="accordion-collapse collapse"
                                aria-labelledby="headingStockMovement" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>Source</th>
                                                <th>Destination</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $movementResult = getStockMovementReport($db);
                                            while ($row = $movementResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['id']}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['type']}</td>
                                                        <td>{$row['quantity']}</td>
                                                        <td>{$row['date']}</td>
                                                        <td>{$row['source']}</td>
                                                        <td>{$row['destination']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Item-wise Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingItemWise">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseItemWise" aria-expanded="false"
                                    aria-controls="collapseItemWise">
                                    Item-wise Report
                                </button>
                            </h2>
                            <div id="collapseItemWise" class="accordion-collapse collapse"
                                aria-labelledby="headingItemWise" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Name</th>
                                                <th>Brand</th>
                                                <th>Total In</th>
                                                <th>Total Out</th>
                                                <th>Net Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $itemWiseResult = getItemWiseReport($db);
                                            while ($row = $itemWiseResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['id']}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['brand']}</td>
                                                        <td>{$row['total_in']}</td>
                                                        <td>{$row['total_out']}</td>
                                                        <td>{$row['net_quantity']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Day-wise Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDayWise">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseDayWise" aria-expanded="false"
                                    aria-controls="collapseDayWise">
                                    Day-wise Report
                                </button>
                            </h2>
                            <div id="collapseDayWise" class="accordion-collapse collapse"
                                aria-labelledby="headingDayWise" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Total In</th>
                                                <th>Total Out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $dayWiseResult = getDayWiseReport($db);
                                            while ($row = $dayWiseResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['date']}</td>
                                                        <td>{$row['total_in']}</td>
                                                        <td>{$row['total_out']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Week-wise Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingWeekWise">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseWeekWise" aria-expanded="false"
                                    aria-controls="collapseWeekWise">
                                    Week-wise Report
                                </button>
                            </h2>
                            <div id="collapseWeekWise" class="accordion-collapse collapse"
                                aria-labelledby="headingWeekWise" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Year-Week</th>
                                                <th>Total In</th>
                                                <th>Total Out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $weekWiseResult = getWeekWiseReport($db);
                                            while ($row = $weekWiseResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['year_week']}</td>
                                                        <td>{$row['total_in']}</td>
                                                        <td>{$row['total_out']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Month-wise Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingMonthWise">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseMonthWise" aria-expanded="false"
                                    aria-controls="collapseMonthWise">
                                    Month-wise Report
                                </button>
                            </h2>
                            <div id="collapseMonthWise" class="accordion-collapse collapse"
                                aria-labelledby="headingMonthWise" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Total In</th>
                                                <th>Total Out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $monthWiseResult = getMonthWiseReport($db);
                                            while ($row = $monthWiseResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['month']}</td>
                                                        <td>{$row['total_in']}</td>
                                                        <td>{$row['total_out']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Brand-wise Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingBrandWise">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseBrandWise" aria-expanded="false"
                                    aria-controls="collapseBrandWise">
                                    Brand-wise Report
                                </button>
                            </h2>
                            <div id="collapseBrandWise" class="accordion-collapse collapse"
                                aria-labelledby="headingBrandWise" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Brand</th>
                                                <th>Total In</th>
                                                <th>Total Out</th>
                                                <th>Net Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $brandWiseResult = getBrandWiseReport($db);
                                            while ($row = $brandWiseResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['brand']}</td>
                                                        <td>{$row['total_in']}</td>
                                                        <td>{$row['total_out']}</td>
                                                        <td>{$row['net_quantity']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- City-wise Warehouse Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingCityWiseWarehouse">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseCityWiseWarehouse" aria-expanded="false"
                                    aria-controls="collapseCityWiseWarehouse">
                                    City-wise Warehouse Report
                                </button>
                            </h2>
                            <div id="collapseCityWiseWarehouse" class="accordion-collapse collapse"
                                aria-labelledby="headingCityWiseWarehouse" data-bs-parent="#reportsAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Name</th>
                                                <th>Brand</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cityWiseWarehouseResult = getCityWiseWarehouseReport($db);
                                            while ($row = $cityWiseWarehouseResult->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['location']}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['brand']}</td>
                                                        <td>{$row['quantity']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>