<?php 

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
          <h1 class="m-0 text-dark">Purchase Product Report</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Purchase Report</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
         
          
          <div class="table-responsive">
            <table id="data" class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Product Name</th>
                  <th>Brand Name</th>
                  <th>Supplier Name</th>
                  <th>Buy Price</th>
                  <th>Sell Price</th>
                  <th>Purchase Quantity</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($factorys as $factory) : ?>
                    <tr>
                    <td><?php echo date("F d, Y", strtotime($factory['created_at'])); ?></td>
                      <td><?= htmlspecialchars($factory['product_name']) ?></td>
                      <td><?= htmlspecialchars($factory['brand_name']) ?></td>
                      <td><?= htmlspecialchars($factory['supplier_name']) ?></td>
                      <td><?= number_format($factory['buy_price'], 2) ?></td>
                      <td><?= number_format($factory['sell_price'], 2) ?></td>
                      <td><?= intval($factory['purchase_quantity']) ?></td>
                      
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
