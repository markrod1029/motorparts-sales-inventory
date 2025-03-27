<?php

// Fetch all products from the database
$sql = "SELECT *, category.name AS category_name, products.id AS prod_id FROM products
  LEFT JOIN category  ON products.category_id = category.id
";


$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Product List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Product List</b></h3>
         
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table id="data" class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Brand</th>
                  <th>Category</th>
                  <th>Source</th>
                  <th>Quantity</th>
                  <th>Buying Price</th>
                  <th>Selling Price</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($products as $product) : ?>
                    <tr>
                      <td><?= htmlspecialchars($product['product_name']) ?></td>
                      <td><?= htmlspecialchars($product['brand_name']) ?></td>
                      <td><?= htmlspecialchars($product['category_name']) ?></td>
                      <td><?= htmlspecialchars($product['product_source']) ?></td>
                      <td><?= htmlspecialchars($product['quantity']) ?></td>
                      <td><?= number_format($product['buy_price'], 2) ?></td>
                      <td><?= number_format($product['sell_price'], 2) ?></td>
                     
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

<!-- DataTables Initialization -->
<script>
  $(document).ready(function() {
    $('#productTable').DataTable({
      "ordering": true,
      "paging": true,
      "searching": true
    });
  });
</script>
