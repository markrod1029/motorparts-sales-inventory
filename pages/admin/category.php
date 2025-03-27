<?php

// Fetch all categories from the database
$sql = "SELECT * FROM category ";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="m-0 text-dark">Category</h1>
                </div>
                <div class="col-md-6 mt-3">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


            <!-- Category Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>All Category Info</b></h3>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)) : ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($category['name']) ?></td>
                                            <td><?= htmlspecialchars($category['description']) ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="index.php?page=category_form&&edit_id=<?= $category['id'] ?>" class="btn btn-secondary btn-sm rounded-0"><i class="fas fa-edit"></i></a>
                                                    <form action="../../app/action/category_process.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm rounded-0" onclick="return confirm('Are you sure you want to delete this Category?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4">No categories found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>