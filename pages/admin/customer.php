<?php
// Query totals
$total_buy = 0;
$total_paid = 0;
$total_due = 0;

$result = mysqli_query($conn, "SELECT SUM(total_buy) as total_buy, SUM(total_paid) as total_paid, SUM(total_due) as total_due FROM member");
if ($row = mysqli_fetch_assoc($result)) {
    $total_buy = $row['total_buy'] ?? 0;
    $total_paid = $row['total_paid'] ?? 0;
    $total_due = $row['total_due'] ?? 0;
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Customer</h1>
        </div>
        <div class="col-md-6 mt-3">
          <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Customer</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- Statistics Info Boxes -->
      <div class="row">
        <div class="col-md-4">
          <div class="info-box bg-danger mb-3">
            <div class="info-box-content">
              <span class="info-box-text">Total Transaction</span>
              <span class="info-box-number"><?php echo number_format($total_buy, 2); ?></span>
            </div>
            <span class="info-box-icon"><i class="fa-solid fa-chart-line"></i></span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="info-box bg-success mb-3">
            <div class="info-box-content">
              <span class="info-box-text">Total Paid</span>
              <span class="info-box-number"><?php echo number_format($total_paid, 2); ?></span>
            </div>
            <span class="info-box-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="info-box bg-info mb-3">
            <div class="info-box-content">
              <span class="info-box-text">Total Due</span>
              <span class="info-box-number"><?php echo number_format($total_due, 2); ?></span>
            </div>
            <span class="info-box-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
          </div>
        </div>
      </div>

      <!-- Customer Table -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>All Customer Info</b></h3>
          <button type="button" class="btn btn-primary btn-sm float-right rounded-0" data-toggle="modal" data-target=".myModal">
            <i class="fas fa-plus"></i> Add New
          </button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="customerTable" class="table table-striped text-center">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Company</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Total Buy</th>
                  <th>Total Paid</th>
                  <th>Total Due</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = "SELECT * FROM member";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['company']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['contact']}</td>
                        <td>" . number_format($row['total_buy'], 2) . "</td>
                        <td>" . number_format($row['total_paid'], 2) . "</td>
                        <td>" . number_format($row['total_due'], 2) . "</td>
                        <td>
                          <button class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></button>
                          <button class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>
                        </td>
                      </tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- DataTables Script -->
<script>
  $(document).ready(function() {
    $('#customerTable').DataTable();
  });
</script>

<?php
// Close MySQL Connection
mysqli_close($conn);
?>
