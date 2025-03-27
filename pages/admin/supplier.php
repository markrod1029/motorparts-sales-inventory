<?php

// Fetch all suppliers from the database
$sql = "SELECT *, s.id AS sup_id FROM suppliers s";
$result = mysqli_query($conn, $sql);
$suppliers = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Supplier</h1>
        </div>
        <div class="col-md-6 mt-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Supplier</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Supplier Table -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>All Supplier Info</b></h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="data" class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Company</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($suppliers as $supplier) : ?>
                  <tr>
                    <td><?= htmlspecialchars($supplier['fname']. ' '.$supplier['mname']. ' '. $supplier['lname']) ?></td>
                    <td><?= htmlspecialchars($supplier['company']) ?></td>
                    <td><?= htmlspecialchars($supplier['address']) ?></td>
                    <td><?= htmlspecialchars($supplier['contact']) ?></td>
                    <td>
                      <div class="btn-group">
                        <a href="index.php?page=supplier_form&&edit_id=<?= $supplier['sup_id'] ?>" class="btn btn-secondary btn-sm rounded-0"><i class="fas fa-edit"></i></a>
                        <form action="../../app/action/supplier_process.php" method="POST" style="display:inline;">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="id" value="<?= htmlspecialchars($supplier['sup_id']) ?>">
                          <button type="submit" class="btn btn-danger btn-sm rounded-0" onclick="return confirm('Are you sure you want to delete this Supplier?')">
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
