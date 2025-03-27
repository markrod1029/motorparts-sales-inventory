<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
            <?php
            $photo = !empty($user['photo']) ? "../../vendor/assets/images/" . $user['photo'] : "../../vendor/assets/images/default.png";
            ?>

            <img src="<?php echo $photo; ?>">
          </a>
          <div class="dropdown-menu dropdown-menu-right p-0">
            <a href="index.php?page=profile" class="dropdown-item p-1">
              <i class="material-symbols-outlined">person</i> Profile
            </a>


            <a href="../../app/action/logout.php" class="dropdown-item pic p-1">
              <i class="material-symbols-outlined">logout</i> Logout
            </a>
          </div>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->