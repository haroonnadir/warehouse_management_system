<?php
// Database connection
$db=mysqli_connect('localhost','root','','warehouse_final'); 

if(isset($_POST['warehouse_id'])) {
    $warehouse_id = $_POST['warehouse_id'];

    // Query to fetch products in the selected warehouse
    $query = $db->query("SELECT p.id, p.name FROM products p INNER JOIN products_in_warehouses pw ON p.id = pw.product_id WHERE pw.warehouse_id = '$warehouse_id'");
    
    $products = array();
    while($row = $query->fetch_assoc()) {
        $products[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }

    // Return JSON response
    echo json_encode($products);
}
?>
