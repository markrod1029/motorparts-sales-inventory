<?php
session_start();

// Fetch all suppliers
$supplier_query = "SELECT * FROM suppliers";
$supplier_result = mysqli_query($conn, $supplier_query);

// Fetch all products (including stock_quantity)
$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_query);

// Handle form submission
$message = ""; // Para sa JavaScript alert
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $supplier_id = isset($_POST['p_supliar']) ? intval($_POST['p_supliar']) : null;
    $product_id = isset($_POST['p_product_name']) ? intval($_POST['p_product_name']) : null;
    $buy_price = isset($_POST['p_p_price']) ? floatval($_POST['p_p_price']) : null;
    $sell_price = isset($_POST['p_p_sell_price']) ? floatval($_POST['p_p_sell_price']) : null;
    $purchase_quantity = isset($_POST['p_pn_quantity']) ? intval($_POST['p_pn_quantity']) : 0;
    $created_at = date('Y-m-d H:i:s');

    if ($supplier_id && $product_id && $buy_price && $sell_price ) {
        // INSERT new purchase record into `factory_products`
        $query = "INSERT INTO factory_products (supplier_id, product_id, buy_price, sell_price, purchase_quantity, created_at) 
                  VALUES ('$supplier_id', '$product_id', '$buy_price', '$sell_price', '$purchase_quantity', '$created_at')";

        if (mysqli_query($conn, $query)) {
            // UPDATE `products.quantity` (add purchase quantity)
            $update_query = "UPDATE products SET quantity = quantity + $purchase_quantity, buy_price = '$buy_price', sell_price = '$sell_price'  WHERE id = '$product_id'";
            if (mysqli_query($conn, $update_query)) {
                $message = "Product purchase recorded successfully! Stock updated.";
            } else {
                $message = "Purchase saved but stock update failed: " . mysqli_error($conn);
                echo "<script>
            alert('$message');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "?page=buy_form';
          </script>";
    exit();
            }
        } else {
            $message = "Error saving purchase: " . mysqli_error($conn);
        }
    } else {
        $message = "All fields are required.";
        echo "<script>
            alert('$message');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "?page=buy_form';
          </script>";
    exit();
    }

    // Redirect back to the same page with JavaScript alert
    echo "<script>
            alert('$message');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "?page=buy_list';
          </script>";
    exit();
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="m-0 text-dark">Buy Products</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-lg-8 offset-lg-2 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b> New Product</b></h3>
                        </div>

                        <div class="card-body">
                            <!-- Form Start -->
                            <form id="addByproductForm" method="POST">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="p_supliar">Supplier Name *</label>
                                            <select name="p_supliar" id="p_supliar" class="form-control select2">
                                                <option selected disabled>Select a Supplier</option>
                                                <?php while ($supplier = mysqli_fetch_assoc($supplier_result)) : ?>
                                                    <option value="<?= $supplier['id']; ?>"><?= $supplier['company']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="p_product_name">Purchase Product *</label>
                                            <select name="p_product_name" id="p_product_name" class="form-control select2">
                                                <option selected disabled>Select a product</option>
                                                <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
                                                    <option value="<?= $product['id']; ?>" 
                                                    data-stock="<?= $product['quantity']; ?>"
                                                    data-buy_price="<?php echo $product['buy_price']; ?>" 
                                                    data-sell_price="<?php echo $product['sell_price']; ?>" 
                                                    >
                                                        <?= $product['product_name']; ?> (<?= $product['brand_name']; ?>)
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="p_p_price">Buy Price *</label>
                                            <input type="number" class="form-control" id="p_p_price" name="p_p_price">
                                        </div>

                                        <div class="form-group">
                                            <label for="p_pn_quantity">Purchase Quantity *</label>
                                            <input type="number" class="form-control" id="p_pn_quantity" name="p_pn_quantity">
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="puchar_date">Purchase Date *</label>
                                            <input type="text" class="form-control datepicker" name="puchar_date" id="puchar_date" value="<?= date('Y-m-d'); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="p_p_quantity">Stock Quantity *</label>
                                            <input type="number" class="form-control" id="p_p_quantity" name="p_p_quantity" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="p_p_sell_price">Sell Price *</label>
                                            <input type="number" class="form-control" id="p_p_sell_price" name="p_p_sell_price">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btn-lg px-4" name="submit">
                                        Submit Purchase
                                    </button>
                                </div>
                            </form>
                            <!-- Form End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript to Update Stock Quantity Without AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Auto-set today's date in the purchase date field
    let today = new Date().toISOString().split('T')[0]; 
    $("#puchar_date").val(today);

    // When a product is selected, update the stock quantity field
    $("#p_product_name").change(function() {
        var stockQuantity = $(this).find(":selected").data("stock");
        $("#p_p_quantity").val(stockQuantity);
        $("#p_p_sell_price").val(stockQuantity);
        $("#p_p_price").val(stockQuantity);
    });
});
</script>

<?php mysqli_close($conn); ?>
