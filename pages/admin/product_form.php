<?php

// Fetch categories
$category_query = "SELECT id, name FROM category";
$category_result = mysqli_query($conn, $category_query);

$categories = [];
if ($category_result) {
  while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row;
  }
}

// Check if editing a product
$product_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$product = null;

if ($product_id > 0) {
  $query = "SELECT * FROM products WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
  }
  mysqli_stmt_close($stmt);
}
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark"><?= $product ? 'Edit Product' : 'Add a New Product' ?></h1>
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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b><?= $product ? 'Edit Product' : 'Add a New Product' ?></b></h3>
        </div>

        <div class="card-body">
          <div class="alert alert-primary alert-dismissible fade show addProductError-area" role="alert" style="display: none;">
            <span id="addProductError"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="../../app/action/product_process.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product ? $product['id'] : '' ?>">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="product_name">Product Name * :</label>
                  <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $product ? htmlspecialchars($product['product_name']) : '' ?>" placeholder="Product name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="brand">Brand Name * :</label>
                  <input type="text" class="form-control" id="brand" name="brand" value="<?= $product ? htmlspecialchars($product['brand_name']) : '' ?>" placeholder="Brand name" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="p_category">Product Category * :</label>
                  <select name="p_category" id="p_category" class="form-control select2" required>
                    <option disabled <?= !$product ? 'selected' : '' ?>>Select a category</option>
                    <?php
                    foreach ($categories as $category) {
                      $selected = ($product && $product['category_id'] == $category['id']) ? 'selected' : '';
                      echo '<option value="' . htmlspecialchars($category['id']) . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="product_source">Product Source * :</label>
                  <select name="product_source" id="product_source" class="form-control select2" required>
                    <option value="factory" <?= ($product && $product['product_source'] == 'factory') ? 'selected' : '' ?>>Factory</option>
                    <option value="buy" <?= ($product && $product['product_source'] == 'buy') ? 'selected' : '' ?>>Buying</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="sku">SKU :</label>
                  <input type="text" class="form-control" id="sku" name="sku" value="<?= $product ? htmlspecialchars($product['sku']) : '' ?>" placeholder="Product SKU">
                </div>
              </div>

              
            </div>

            <div class="form-group text-center">
              <button type="submit" class="btn btn-success btn-lg px-4" name="submit">

                <?= $product ? 'Update Product' : 'Add Product' ?></button>
            </div>
        </div>
        </form>
      </div>
    </div>
</div>
</section>
</div>

<?php mysqli_close($conn); ?>