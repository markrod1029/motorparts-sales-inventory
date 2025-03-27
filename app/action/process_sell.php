<?php
require_once(__DIR__ . '/../init.php'); // Database connection
ob_start(); // Start output buffering

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderDate = $_POST['orderdate'];
    $subtotal = $_POST['subtotal'];
    $totalPayment = $_POST['totalPayment'];
    $change = $_POST['change'];
    $user_id = $_POST['id'];

    // 1. Get last order_number and increment
    $orderQuery = "SELECT order_number FROM sales ORDER BY order_number DESC LIMIT 1";
    $orderResult = mysqli_query($conn, $orderQuery);
    $row = mysqli_fetch_assoc($orderResult);
    $lastOrderNumber = $row ? intval($row['order_number']) : 10000; // Default 10000 kung wala pang record
    $newOrderNumber = $lastOrderNumber + 1; // Increment ng isa

    // 2. Check stock availability for all products
    $insufficientStock = false;
    foreach ($_POST['product_id'] as $index => $product_id) {
        $order_quantity = $_POST['order_quantity'][$index];

        // Get current stock
        $stockQuery = "SELECT quantity FROM products WHERE id = '$product_id'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $product = mysqli_fetch_assoc($stockResult);
        
        if ($product && $product['quantity'] < $order_quantity) {
            $insufficientStock = true;
            break;
        }
    }

    // 3. If stock is insufficient, stop the process
    if ($insufficientStock) {
        echo "<script>alert('Error: Insufficient stock for one or more products!'); window.history.back();</script>";
        exit();
    }

    // 4. Insert sales transaction
    $sql = "INSERT INTO sales (user_id, order_number, order_date, subtotal, total_payment, change_amount) 
            VALUES ('$user_id', '$newOrderNumber', '$orderDate', '$subtotal', '$totalPayment', '$change')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $sales_id = mysqli_insert_id($conn); // Get last inserted sales ID

        // 5. Insert each product into `sales_products` and update product stock
        foreach ($_POST['product_id'] as $index => $product_id) {
            $price = $_POST['price'][$index];
            $order_quantity = $_POST['order_quantity'][$index];
            $total_price = $price * $order_quantity;

            // Insert into sales_products
            $sql = "INSERT INTO sales_products (sales_id,  product_id, price, order_quantity, total_price)
                    VALUES ('$sales_id',  '$product_id',  '$price', '$order_quantity', '$total_price')";
            mysqli_query($conn, $sql);

            // Update product stock
            $updateStock = "UPDATE products SET quantity = quantity - $order_quantity WHERE id = '$product_id'";
            mysqli_query($conn, $updateStock);
        }

        if($user_id > 1){
            echo "<script>alert('Sale recorded successfully!'); window.location.href='../../pages/staff/index.php?page=sell_form';</script>";
        } else {
            echo "<script>alert('Sale recorded successfully!'); window.location.href='../../pages/admin/index.php?page=sell_form';</script>";
        }
    } else {
        echo "<script>alert('Error saving sale!'); window.history.back();</script>";
    }
}
?>
