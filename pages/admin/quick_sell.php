<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
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
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title"><b>Make a Sell Here</b></h3>
          <button type="button" class="btn btn-primary btn-sm rounded-0" data-toggle="modal" data-target=".myModal">
            <i class="fas fa-plus"></i> Add Customer
          </button>
        </div>
        
        <div class="card-body">
          <form id="sellForm" onsubmit="return false">
            <!-- Order Header -->
            <div class="order-header">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <select name="customer_name" id="customer_name" class="form-control select2">
                      <option selected disabled>Select a customer</option>
                      <?php 
                        $all_customer = $obj->all('member');
                        foreach ($all_customer as $customer) {
                          echo "<option value='{$customer->id}'>{$customer->name}</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="orderdate">Order Date</label>
                  <input type="text" class="form-control datepicker" name="orderdate" id="orderdate" autocomplete="off">
                </div>
              </div>
            </div>
            
            <!-- Order Items -->
            <div class="card p-4 bg-light">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Total Quantity</th>
                    <th>Price</th>
                    <th>Order Quantity</th>
                    <th>Total Price</th>
                    <th>Product Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="invoiceItem">
                  <!-- Invoice items will be added dynamically via AJAX -->
                </tbody>
              </table>
              <div class="text-right mt-3">
                <button type="button" class="btn btn-primary" id="addNewRowBtn">Add</button>
              </div>
            </div>
            
            <!-- Invoice Summary -->
            <div class="invoice-area card pt-3 bg-light">
              <div class="row">
                <div class="col-lg-8 offset-lg-2">
                  <div class="form-group row">
                    <label class="col-md-3" for="subtotal">Subtotal</label>
                    <div class="col-md-8">
                      <input type="number" class="form-control form-control-sm" name="subtotal" id="subtotal">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-3" for="prev_due">Previous Due</label>
                    <div class="col-md-8">
                      <input type="number" class="form-control form-control-sm" name="prev_due" id="prev_due">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-3" for="netTotal">Net Total</label>
                    <div class="col-md-8">
                      <input type="number" class="form-control form-control-sm" name="netTotal" id="netTotal">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-3" for="paidBill">Paid Amount</label>
                    <div class="col-md-8">
                      <input type="number" class="form-control form-control-sm" name="paidBill" id="paidBill">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-3" for="dueBill">Due Amount</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control form-control-sm" name="dueBill" id="dueBill">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-md-3" for="payMethode">Payment Method</label>
                    <div class="col-md-8">
                      <select name="payMethode" id="payMethode" class="form-control form-control-sm select2">
                        <option selected disabled>Select a payment method</option>
                        <?php 
                          $all_methode = $obj->all('paymethode');
                          foreach ($all_methode as $payMethode) {
                            echo "<option value='{$payMethode->name}'>{$payMethode->name}</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-block" id="sellBtn">Make Sell</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
