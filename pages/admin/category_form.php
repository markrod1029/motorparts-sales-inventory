<?php

$category_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null;
$name = "";
$description = "";

if ($category_id) {
    $query = "SELECT * FROM category WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $description = $row['description'];
    }
}

mysqli_close($conn);
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark"><?= $category_id ? "Edit" : "Add" ?> Category</h1>
        </div>
        <div class="col-md-6 mt-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active"><?= $category_id ? "Edit" : "Add" ?> Category</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 offset-md-2 col-lg-8 offset-lg-2 mt-3">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?= $category_id ? "Edit" : "Add" ?> Category</h3>
            </div>
            <div class="card-body">
              <form action="../../app/action/category_process.php" method="POST">
                <input type="hidden" name="id" value="<?= $category_id ?>"> <!-- Hidden ID -->
                <div class="form-group">
                  <label for="name">Category Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea rows="3" class="form-control" id="description" name="description"><?= htmlspecialchars($description) ?></textarea>
                </div>
                <div class="form-group  text-center">
                  <button type="submit" class="btn btn-primary btn-block mt-4 rounded-0"><?= $category_id ? "Update" : "Add" ?> Category</button>
                </div>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
