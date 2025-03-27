<?php

// Fetch all staff members
$query = "SELECT * FROM users WHERE role = 'staff' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$staffMembers = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $staffMembers[] = $row;
  }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Staff Management</h1>
        </div>
        <div class="col-md-6 mt-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Staff</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Table Card -->
      <div class="card">

        <!-- Card Body -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="data" class="display dataTable text-center">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($staffMembers as $staff): ?>
                    <tr>
                      <td><?= htmlspecialchars($staff['id']) ?></td>
                      <td>
                        <?= htmlspecialchars($staff['fname']) . " " .
                          htmlspecialchars($staff['mname']) . " " .
                          htmlspecialchars($staff['lname']) ?>
                      </td>
                      <td><?= htmlspecialchars($staff['contact']) ?></td>
                      <td><?= htmlspecialchars($staff['email']) ?></td>
                      <td><?= htmlspecialchars($staff['address']) ?></td>
                      <td>
                        <div class="btn-group">
                          <a href="index.php?page=staff_form&id=<?= htmlspecialchars($staff['id']) ?>" class="btn btn-secondary btn-sm rounded-0">
                            <i class="fas fa-edit"></i>
                          </a>
                          <form action="../../app/action/staff_process.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($staff['id']) ?>">
                            <button type="submit" class="btn btn-danger btn-sm rounded-0" onclick="return confirm('Are you sure you want to delete this staff member?')">
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
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </section>
</div>

<?php mysqli_close($conn); ?>