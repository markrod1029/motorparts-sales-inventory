

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content mt-5">
    <div class="container-fluid">
      <div class="card view_sell_page_info">
        <div class="card-header">
          Sell Information
        </div>
        <div class="card-body">
          <?php 
          if (isset($_GET['view_id'])) {
              $view_id = $_GET['view_id'];
              
              // Kunin ang sales data mula sa `sales` table
              $query = "SELECT * FROM sales WHERE id = $view_id";
              $result = mysqli_query($conn, $query);
              $sell_total = mysqli_fetch_assoc($result);

              if ($sell_total) {
          ?>
                <div class="row">
                  <div class="col-md-6">
                    <p><b>Order Date:</b> <?= $sell_total['order_date']; ?></p>
                    <p><b>Invoice No:</b> <?= $sell_total['order_number']; ?></p>
                  </div>
                </div> 

                <!-- Sales Products Table -->
                <table class="table table-bordered text-center mt-4">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Total Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $invoice_id = $sell_total['id'];
                    $query = "SELECT * FROM sales_products WHERE sales_id = $invoice_id";
                    $result = mysqli_query($conn, $query);
                    $i = 0;

                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        // Kung product_id == 0, ipakita ang "Others" bilang pangalan
                        $product_name = ($row['product_id'] == 0) ? "Service and Repair" : getProductName($row['product_id'], $conn);
                        $unit_price = number_format($row['price'] / $row['order_quantity'], 2);
                        $total_price = number_format($row['total_price'], 2);
                    ?>
                      <tr>
                        <td><?= $i; ?></td>
                        <td><?= $product_name; ?></td>
                        <td><?= $row['order_quantity']; ?></td>
                        <td><?= $unit_price; ?></td>
                        <td><?= $total_price; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>

                <!-- Summary -->
                <div class="row mt-4">
                  <div class="col-md-4 offset-md-8">
                    <table class="table">
                      <tr>
                        <td><b>Subtotal</b></td>
                        <td>:</td>
                        <td><?= number_format($sell_total['subtotal'], 2); ?></td>
                      </tr>
                     
                      <tr>
                        <td><b>Change(Sukli)</b></td>
                        <td>:</td>
                        <td><?= number_format($sell_total['change_amount'], 2); ?></td>
                      </tr>
                      <tr>
                        <td><b>Paid Amount</b></td>
                        <td>:</td>
                        <td><?= number_format($sell_total['total_payment'], 2); ?></td>
                      </tr>
                    </table>
                  </div>
                </div>

                <!-- Buttons -->
                <div class="view_sell_button-area mt-4">
                  <button type="button" onclick="window.print()" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Print</button>
                </div>

          <?php  
              }
          }
          ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?php 
// Close connection
mysqli_close($conn);
?>

<!-- Helper Function -->
<?php
function getProductName($product_id, $conn) {
    $query = "SELECT product_name FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row ? $row['product_name'] : "Unknown";
}
?>

<!-- Print Styles -->
<style>
@page {
  margin-top: 150px;
  margin-bottom: 100px;
}

@media print {
  body {
    font-size: 12px;
  }
  .view_sell_button-area {
    display: none;
  }
  footer.main-footer {
    display: none;
  }
  .card.view_sell_page_info {
    margin-top: 100px;
  }
}
</style>
