<?php
require_once(__DIR__ . '/../../app/init.php'); 
require_once(__DIR__ . '/../../app/session/adminSession.php');

$user_id = $user['id'];

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, trim($_POST['fname']));
    $mname = mysqli_real_escape_string($conn, trim($_POST['mname']));
    $lname = mysqli_real_escape_string($conn, trim($_POST['lname']));
    $contact = mysqli_real_escape_string($conn, trim($_POST['contact']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    $update_fields = "fname='$fname', mname='$mname', lname='$lname', contact='$contact', email='$email'";

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/../../vendor/assets/images/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = time() . "_" . str_replace(' ', '_', $_FILES['profileImage']['name']);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target_file)) {
                $update_fields .= ", photo='$image_name'"; // Update new image path in database
                
                if (!empty($user['photo']) && $user['photo'] != 'default.png' && file_exists($target_dir . $user['photo'])) {
                    unlink($target_dir . $user['photo']);
                }
            } else {
                echo "<script>alert('Error uploading image. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, JPEG, and PNG allowed.');</script>";
        }
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_fields .= ", password='$hashed_password'";
    }

    $query = "UPDATE users SET $update_fields WHERE id=$user_id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['user']['photo'] = $image_name ?? $user['photo'];
        echo "<script>alert('Profile updated successfully!'); window.location.href='index.php?page=profile';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="card">
            <div class="card-body row">
                <div class="col-5 text-center d-flex align-items-center justify-content-center">
                    <div class="">
                        <?php 
                            $photo = !empty($user['photo']) ? "../../vendor/assets/images/" . $user['photo'] : "../../vendor/assets/images/default.png"; 
                        ?>
                        <label for="profileImageInput">
                            <img src="<?php echo $photo; ?>" id="profileImagePreview" alt="Profile Picture" class="img-thumbnail" style="border-radius:50%; cursor:pointer; width:200px; height:200px; object-fit:cover;">
                        </label>
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('profileImageInput').click()">
                                <i class="fas fa-camera"></i> Change Photo
                            </button>
                        </div>
                        <h2 class="mt-3"><strong><?php echo htmlspecialchars($user['fname']) . ' ' . htmlspecialchars($user['mname']) . ' ' . htmlspecialchars($user['lname']); ?></strong></h2>
                        <p class="lead mb-5"><?php echo htmlspecialchars($user['address'] ?? ''); ?><br><?php echo htmlspecialchars($user['contact']); ?></p>
                    </div>
                </div>

                <div class="col-7">
                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                        <input type="file" id="profileImageInput" name="profileImage" style="display:none;" accept="image/*" onchange="previewImage(event)">

                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="mname">Middle Name</label>
                            <input type="text" name="mname" class="form-control" value="<?php echo htmlspecialchars($user['mname']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($user['lname']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact</label>
                            <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($user['contact']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New password">
                            <small class="text-muted">Leave blank to keep current password</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profileImagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>