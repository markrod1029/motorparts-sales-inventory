<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Sales Product Report</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Sales Report</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card">

        <!-- Card Body -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="data" class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Sales No</th>
                  <th>date</th>
                  <th>Sub Total</th>
                  <th>Change</th>
                  <th>total Payment</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $id = $user['id'];
                $query = "SELECT * FROM sales WHERE user_id = '$id' ORDER BY sales.id DESC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) { ?>

                  <tr>
                    <td><?php echo $row['order_number'] ?></td>
                    <td><?php echo date("F d, Y", strtotime($row['order_date'])); ?></td>
                    <td><?php echo number_format($row['subtotal'], 2) ?></td>
                    <td><?php echo number_format($row['change_amount'], 2) ?></td>
                    <td><?php echo number_format($row['total_payment'], 2) ?></td>

                    <td>
                      <div class="btn-group">
                        <a href="index.php?page=info_sales&view_id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-secondary btn-sm rounded-0">
                          <i class="fas fa-eye"></i>
                        </a>

                      </div>
                    </td>

                  </tr>
                <?php  }

                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

<?php
// Close connection
mysqli_close($conn);
?>