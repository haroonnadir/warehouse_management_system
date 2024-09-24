<?php require_once 'main.php' ?>
<?php
$user_id=$_SESSION['authid'];
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $account_id = $_POST['account_id'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $voucher_number = $_POST['voucher_number'];
    $reference_number = $_POST['reference_number'];
    $location = $_POST['location'];
    $product_id = $_POST['product_id'] ? $_POST['product_id'] : null;
    $quantity = $_POST['quantity'] ? $_POST['quantity'] : null;
    $unit_price = $_POST['unit_price'] ? $_POST['unit_price'] : null;

    // Insert transaction
    $sql = "INSERT INTO transactions (account_id, type, amount, date, description, voucher_number, reference_number, location, product_id, quantity, unit_price, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isdsssssiidd", $account_id, $type, $amount, $date, $description, $voucher_number, $reference_number, $location, $product_id, $quantity, $unit_price, $user_id);
    
    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Transaction added successfully</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Fetch accounts for dropdown
$accounts_query = "SELECT id, account_name FROM chartofaccounts WHERE account_type = 'ledger'";
$accounts_result = $db->query($accounts_query);

// Fetch products for dropdown
$products_query = "SELECT id, name FROM products";
$products_result = $db->query($products_query);

// Fetch and display transactions
$sql = "SELECT t.*, c.account_name, p.name as product_name, u.name 
        FROM transactions t
        JOIN chartofaccounts c ON t.account_id = c.id
        LEFT JOIN products p ON t.product_id = p.id
        JOIN users u ON t.user_id = u.id
        ORDER BY t.date DESC";

$result = $db->query($sql);
?>
<div class="wrapper d-flex align-items-stretch">
    <?php require_once 'nav.php'; ?>
    <!-- Page Content  -->
    <div id="content" class="p-4">
        <?php require_once 'left-side.php' ?>
        <!-- start: BASIC EXAMPLE -->
        <div class="section-title">
            <h2>ADMIN || TRANSECTION</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="row">
                    <div class="mb-3 form-floating">
                        <select name="account_id" id="account_id" class="form-control" required>
                            <option value="">Select Account</option>
                            <?php while ($account = $accounts_result->fetch_assoc()): ?>
                            <option value="<?php echo $account['id']; ?>">
                                <?php echo $account['account_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label for="account_id">Account</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select name="type" id="type" class="form-control" required>
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                        </select>
                        <label for="type">Type</label>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 form-floating">
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required
                            placeholder="">
                        <label for="amount">Amount</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="datetime-local" name="date" id="date" class="form-control" required placeholder="">
                        <label for="date">Date</label>
                    </div>
                </div>
                <div class="mb-3 form-floating">
                    <textarea name="description" id="description" class="form-control" rows="3"
                        placeholder=""></textarea>
                    <label for="description">Description</label>
                </div>
                <div class="row">
                    <div class="mb-3 form-floating">
                        <input type="text" name="voucher_number" id="voucher_number" class="form-control"
                            placeholder="">
                        <label for="voucher_number">Voucher Number</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" name="reference_number" id="reference_number" class="form-control"
                            placeholder="">
                        <label for="reference_number">Reference Number</label>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 form-floating">
                        <select name="location" id="location" class="form-control" required>
                            <option value="Lahore">Lahore</option>
                            <option value="Karachi">Karachi</option>
                            <option value="Rawalpindi">Rawalpindi</option>
                            <option value="Faisalabad">Faisalabad</option>
                            <option value="Quetta">Quetta</option>
                        </select>
                        <label for="location">Location</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select name="product_id" id="product_id" class="form-control">
                            <option value="">Select Product (if applicable)</option>
                            <?php while ($product = $products_result->fetch_assoc()): ?>
                            <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                        <label for="product_id">Product</label>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 form-floating">
                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="">
                        <label for="quantity">Quantity</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control"
                            placeholder="">
                        <label for="unit_price">Unit Price</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Transaction</button>
            </form>
        </div>

        <table class="table py-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Account</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Voucher</th>
                    <th>Reference</th>
                    <th>Location</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>User</th>
                </tr>
            </thead>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['account_name']; ?></td>
                <td><?php echo ucfirst($row['type']); ?></td>
                <td><?php echo number_format($row['amount'], 2); ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($row['date'])); ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['voucher_number']; ?></td>
                <td><?php echo $row['reference_number']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['unit_price'] ? number_format($row['unit_price'], 2) : ''; ?></td>
                <td><?php echo $row['name']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>