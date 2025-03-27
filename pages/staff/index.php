<?php
require_once(__DIR__ . '/../../app/session/staffSession.php');
require_once '../../inc/header.php';
require_once '../../inc/staffSidebar.php';
require_once(__DIR__ . '/../../app/init.php'); // Database connection

?>

<?php
// Dynamic page loading
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$pages = [
  'dashboard' => 'dashboard.php',
  'products' => 'product.php',
  'sell_list' => 'sell_list.php',
  'sell_form' => 'sell_form.php',
  'view_sell' => 'view_sell.php',
  'sales_report' => 'sales_report.php',
  'view_sales' => 'view_sales.php',
  'info_sales' => 'info_sales.php',
  'profile' => 'profile.php',
];

// Check if the requested page exists in the array
if (array_key_exists($page, $pages)) {
  require_once $pages[$page];
} else {
  require_once 'notfound.php';
}
?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<?php require_once '../../inc/footer.php'; ?>