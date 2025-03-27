<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Kunin ang product_id at purchase_quantity bago idelete
    $query = "SELECT product_id, purchase_quantity FROM factory_products WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $purchase_quantity = $row['purchase_quantity'];

        // Update ang total quantity sa products table (Bawas quantity)
        $update_query = "UPDATE products SET quantity = quantity - '$purchase_quantity' WHERE id = '$product_id'";
        mysqli_query($conn, $update_query);

        // Tanggalin ang purchase record sa factory_products
        $delete_query = "DELETE FROM factory_products WHERE id = '$id'";
        if (mysqli_query($conn, $delete_query)) {
            echo "<script>
                    alert('Purchase deleted successfully. Product quantity updated.');
                    window.location.href = 'index.php?page=buy_list';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Failed to delete purchase.');
                    window.location.href = 'index.php?page=buy_list';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Purchase not found.');
                window.location.href = 'index.php?page=buy_list';
              </script>";
        exit;
    }
}

// Fetch all factory products with related product and supplier details
$sql = "SELECT factory_products.*, 
               products.product_name, products.brand_name, 
               CONCAT_WS(' ', suppliers.fname, suppliers.mname, suppliers.lname) AS supplier_name
        FROM factory_products
        LEFT JOIN products ON products.id = factory_products.product_id
        LEFT JOIN suppliers ON suppliers.id = factory_products.supplier_id";
$result = mysqli_query($conn, $sql);
$factorys = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Total Purchase Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Purchase</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="card-header">
            <h3 class="card-title"><b>Purchase Product List</b></h3>
            <a href="index.php?page=buy_form" class="btn btn-primary btn-sm float-right rounded-0">
              <i class="fas fa-plus"></i> Add Purchase
            </a>
          </div>
          
          <div class="table-responsive">
            <table id="data" class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Brand Name</th>
                  <th>Supplier Name</th>
                  <th>Buy Price</th>
                  <th>Sell Price</th>
                  <th>Purchase Quantity</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($factorys as $factory) : ?>
                    <tr>
                      <td><?= htmlspecialchars($factory['product_name']) ?></td>
                      <td><?= htmlspecialchars($factory['brand_name']) ?></td>
                      <td><?= htmlspecialchars($factory['supplier_name']) ?></td>
                      <td><?= number_format($factory['buy_price'], 2) ?></td>
                      <td><?= number_format($factory['sell_price'], 2) ?></td>
                      <td><?= intval($factory['purchase_quantity']) ?></td>
                      <td>
                        <div class="btn-group">
                         
                          <form action="index.php?page=buy_list" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $factory['id'] ?>">
                            <button type="button" class="btn btn-danger btn-sm rounded-0" 
                                    onclick="confirmDelete(this)">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- JavaScript for Delete Confirmation -->
<script>
function confirmDelete(button) {
    if (confirm("Are you sure you want to delete this purchase? This will reduce the product quantity.")) {
        button.closest("form").submit();
    }
}
</script>

<?php 
// Close the database connection
mysqli_close($conn);
?>
