<?php
require_once(__DIR__ . '/../init.php'); // Database connection

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($action === 'delete') {
        // Handle product deletion
        $product_id = isset($_POST['id']) ? intval($_POST['id']) : null;

        if ($product_id) {
            $query = "DELETE FROM products WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $product_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $message = "Product deleted successfully!";
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            $message = "Invalid product ID.";
        }

        mysqli_close($conn);
        echo "<script>alert('$message'); window.location.href = '../../pages/admin/index.php?page=products';</script>";
        exit();
    } else {
        // Handle product add/update
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
        $product_name = isset($_POST['product_name']) ? mysqli_real_escape_string($conn, trim($_POST['product_name'])) : '';
        $brand = isset($_POST['brand']) ? mysqli_real_escape_string($conn, trim($_POST['brand'])) : '';
        $p_category = isset($_POST['p_category']) ? intval($_POST['p_category']) : 0;
        $product_source = isset($_POST['product_source']) ? mysqli_real_escape_string($conn, trim($_POST['product_source'])) : '';
        $sku = isset($_POST['sku']) ? mysqli_real_escape_string($conn, trim($_POST['sku'])) : '';

        // Validation
        if (empty($product_name) || empty($brand) || $p_category <= 0 || empty($product_source) || empty($sku)) {
            echo "<script>alert('All fields are required.'); window.location.href = '../../pages/admin/index.php?page=products';</script>";
            exit();
        }

        if ($product_id) {
            // Update existing product
            $query = "UPDATE products SET product_name = ?, brand_name = ?, category_id = ?, product_source = ?, sku = ?, updated_at = NOW() WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssissi", $product_name, $brand, $p_category, $product_source, $sku, $product_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $message = "Product updated successfully!";
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            // Insert new product
            $query = "INSERT INTO products (product_name, brand_name, category_id, product_source, sku, created_at, updated_at) 
                      VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssiss", $product_name, $brand, $p_category, $product_source, $sku);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $message = "Product added successfully!";
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
        echo "<script>alert('$message'); window.location.href = '../../pages/admin/index.php?page=products';</script>";
        exit();
    }
}

// If no valid action was provided
echo "<script>alert('Invalid action.'); window.location.href = '../../pages/admin/index.php?page=products';</script>";
exit();
?>
