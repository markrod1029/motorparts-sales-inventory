<?php
// Initialize variables
$edit_id = "";
$name = "";
$company = "";
$address = "";
$contact = "";
$email = "";

// Check if editing
if (isset($_GET['edit_id'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_id']);
    $result = mysqli_query($conn, "SELECT * FROM member WHERE id = '$edit_id'");
    
    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $company = $row['company'];
        $address = $row['address'];
        $contact = $row['con_num'];
        $email = $row['email'];
    } else {
        header("Location: index.php?page=error_page");
        exit();
    }
}

// Handle form submission (Add & Edit)
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if ($edit_id) {
        // Update record
        $query = "UPDATE member SET name='$name', company='$company', address='$address', con_num='$contact', email='$email' WHERE id='$edit_id'";
    } else {
        // Insert new record
        $query = "INSERT INTO member (name, company, address, con_num, email) VALUES ('$name', '$company', '$address', '$contact', '$email')";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: index.php?page=category");
        exit();
    } else {
        echo "<p class='text-danger'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Category</h1>
        </div>
        <div class="col-sm-6 mt-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Category</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <hr>
      <div class="row">
        <div class="col-md-8 offset-md-2 col-lg-8 offset-lg-2 mt-3">
          <div class="card">
            <div class="card-header">
              <h4 class="float-left"><?= $edit_id ? "Update this customer" : "Add new customer" ?></h4>
              <?php if ($edit_id): ?>
                <h4 class="float-right"><b>Customer ID:</b> #<?= $edit_id ?></h4>
              <?php endif; ?>
            </div>
            <div class="card-body">
              <form method="post">
                <div class="form-group">
                  <label for="name">Name *:</label>
                  <input type="text" class="form-control add-member" id="name" name="name" value="<?= $name ?>" required>
                </div>
                <div class="form-group">
                  <label for="company">Company *:</label>
                  <input type="text" class="form-control add-member" id="company" name="company" value="<?= $company ?>" required>
                </div>
                <div class="form-group">
                  <label for="address">Address:</label>
                  <textarea rows="3" class="form-control" id="address" name="address"><?= $address ?></textarea>
                </div>
                <div class="form-group">
                  <label for="contact">Contact Number *:</label>
                  <input type="text" class="form-control add-member" id="contact" name="contact" value="<?= $contact ?>" required>
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control add-member" id="email" name="email" value="<?= $email ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block rounded-0">
                  <?= $edit_id ? "Update Customer" : "Add Customer" ?>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php mysqli_close($conn); ?>
