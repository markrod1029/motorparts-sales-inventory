<?php

// Fetch all products
$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_query);
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 mt-3">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">New Sell</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">New Sell</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Make a sell here</b></h3>
          <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#productModal">Add Product</button>
        </div>
        <div class="card-body">
          <form id="sellForm" method="POST" action="../../app/action/process_sell.php">
            <div class="form-group">
              <label for="orderdate">Order Date</label>
              <input type="text" class="form-control" name="orderdate" id="orderdate" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Total Quantity</th>
                    <th>Price</th>
                    <th>Order Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="invoiceItem"></tbody>
              </table>
            </div>

            <div class="form-group text-right">
              <label for="subtotal">Subtotal:</label>
              <input type="number" class="form-control d-inline-block w-auto" name="subtotal" id="subtotal" readonly>
            </div>

            <div class="form-group text-right">
              <label for="totalPayment">Total Payment:</label>
              <input type="number" class="form-control d-inline-block w-auto" name="totalPayment" id="totalPayment" required>
            </div>

            <div class="form-group text-right">
              <label for="change">Change (Sukli):</label>
              <input type="number" class="form-control d-inline-block w-auto" name="change" id="change" readonly>
              <input type="hidden"  name="id" value="<?php echo $user['id']?>" id="change" readonly>
            </div>

            <div class="form-group text-center">
              <button type="submit" class="btn btn-success">Make Sell</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Product Selection Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select Product</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <select id="productSelect" class="form-control">
          <option disabled selected>Select a product</option>
          <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
            <option value="<?php echo $product['id']; ?>" 
                    data-name="<?php echo $product['product_name']; ?>" 
                    data-price="<?php echo $product['sell_price']; ?>" 
                    data-quantity="<?php echo $product['quantity']; ?>">
              <?php echo $product['product_name']; ?> (<?php echo $product['brand_name']; ?>)
            </option>
          <?php endwhile; ?>
          <option value="other">Other</option>
        </select>

        <div id="customPriceContainer" class="mt-3" style="display: none;">
          <label for="customPrice">Enter Custom Price:</label>
          <input type="number" id="customPrice" class="form-control" step="0.01" min="0">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addProduct">Add</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    let count = 0;

    $('#productSelect').change(function() {
        let selected = $('#productSelect option:selected').val();
        $('#customPriceContainer').toggle(selected === "other");
    });

    $('#addProduct').click(function() {
        let selected = $('#productSelect option:selected');
        let id = selected.val();
        let name = selected.data('name');
        let price = parseFloat(selected.data('price')) || 0;
        let quantity = parseInt(selected.data('quantity')) || 0;
        let isOther = (id === "other");

        if (isOther) {
            name = "Other";
            price = parseFloat($('#customPrice').val()) || 0;
            quantity = "N/A"; 
        }

        if (!name || price <= 0) {
            alert('Please select a valid product or enter a custom price!');
            return;
        }

        count++;
        let row = `<tr id="row${count}">
                      <td>${count}</td>
                      <td>${name} <input type="hidden" name="product_id[]" value="${id}"></td>
                      <td>${quantity}</td>
                      <td><input type='number' class='form-control productPrice' name="price[]" value="${price.toFixed(2)}" step="0.01" min="0" ${isOther ? '' : 'readonly'}></td>
                      <td><input type='number' class='form-control orderQuantity' name="order_quantity[]" data-price='${price}' min='1' required></td>
                      <td class='totalPrice'>0.00</td>
                      <td><button type='button' class='btn btn-danger btn-sm removeRow' data-id='row${count}'>Delete</button></td>
                   </tr>`;

        $('#invoiceItem').append(row);
        $('#productModal').modal('hide');
        updateSubtotal();
    });

    $(document).on('input', '.orderQuantity, .productPrice', function() {
        let row = $(this).closest('tr');
        let qty = parseFloat(row.find('.orderQuantity').val()) || 0;
        let price = parseFloat(row.find('.productPrice').val()) || 0;
        let total = qty * price;
        row.find('.totalPrice').text(total.toFixed(2));
        updateSubtotal();
    });

    $(document).on('click', '.removeRow', function() {
        $('#' + $(this).data('id')).remove();
        updateSubtotal();
    });

    function updateSubtotal() {
        let subtotal = 0;
        $('.totalPrice').each(function() {
            subtotal += parseFloat($(this).text());
        });
        $('#subtotal').val(subtotal.toFixed(2));
        updateChange();
    }

    $('#totalPayment').on('input', function() {
        updateChange();
    });

    function updateChange() {
        let subtotal = parseFloat($('#subtotal').val()) || 0;
        let totalPayment = parseFloat($('#totalPayment').val()) || 0;
        $('#change').val((totalPayment - subtotal).toFixed(2));
    }
});
</script>
