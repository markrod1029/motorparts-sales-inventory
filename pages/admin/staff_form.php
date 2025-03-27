<?php

$staff_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$fname = $mname = $lname = $email = $password = $contact = $address = "";

// If editing, fetch staff data
if ($staff_id) {
  $query = "SELECT * FROM users WHERE id = $staff_id AND role = 'staff'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $staff = mysqli_fetch_assoc($result);
    $fname = $staff['fname'];
    $mname = $staff['mname'];
    $lname = $staff['lname'];
    $email = $staff['email'];
    $contact = $staff['contact'];
    $address = $staff['address'];
  }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?= $staff_id ? "Edit Staff" : "Add Staff" ?></h1>
        </div>
        <div class="col-sm-6 mt-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active"><?= $staff_id ? "Edit Staff" : "Add Staff" ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 offset-md-2 col-lg-8 offset-lg-2 mt-3">
          <div class="card">
            <div class="card-header">
              <h3><?= $staff_id ? "Edit Staff" : "Add New Staff" ?></h3>
            </div>
            <div class="card-body">

              <!-- Success & Error Messages -->
              <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Staff saved successfully!</div>
              <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Error processing request!</div>
              <?php endif; ?>

              <form action="../../app/action/staff_process.php" method="POST">
                <input type="hidden" name="id" value="<?= $staff_id ?>">

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fname">First Name *:</label>
                      <input type="text" class="form-control" id="fname" name="fname"
                        value="<?= htmlspecialchars($fname) ?>" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="mname">Middle Name:</label>
                      <input type="text" class="form-control" id="mname" name="mname" placeholder="Optional"
                        value="<?= htmlspecialchars($mname) ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="lname">Last Name *:</label>
                      <input type="text" class="form-control" id="lname" name="lname"
                        value="<?= htmlspecialchars($lname) ?>" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email" name="email"
                        value="<?= htmlspecialchars($email) ?>">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">Password :</label>
                      <input type="password" class="form-control" id="password" name="password" <?= $staff_id ? "" : "required" ?>>
                      <p><?= $staff_id ? "Leave blank to keep current password" : "" ?></p>

                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="contact">Contact Number *:</label>
                  <input type="text" class="form-control" id="contact" name="contact"
                    value="<?= htmlspecialchars($contact) ?>" required>
                </div>

                <div class="form-group">
                  <label for="address">Address *:</label>
                  <textarea rows="3" class="form-control" id="address" name="address" required><?= htmlspecialchars($address) ?></textarea>
                </div>
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-success btn-lg px-4" name="submit">
                    <?= $staff_id ? "Update Staff" : "Add Staff" ?>
                  </button>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>