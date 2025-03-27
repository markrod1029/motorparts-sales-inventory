<?php
require_once(__DIR__ . '/../../app/session/adminSession.php');
require_once '../../inc/header.php';
require_once '../../inc/sidebar.php';
require_once(__DIR__ . '/../../app/init.php'); // Database connection

?>

<?php
// Dynamic page loading
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$pages = [
  'dashboard' => 'dashboard.php',
  'suppliers' => 'supplier.php',
  'supplier_form' => 'supplier_form.php',
  'category' => 'category.php',
  'category_form' => 'category_form.php',
  'products' => 'product.php',
  'product_form' => 'product_form.php',
  'staff' => 'staff.php',
  'staff_form' => 'staff_form.php',
  'sell_list' => 'sell_list.php',
  'sell_form' => 'sell_form.php',
  'view_sell' => 'view_sell.php',
  'buy_form' => 'buy_form.php',
  'buy_list' => 'buy_list.php',
  'sales_report' => 'sales_report.php',
  'purchase_report' => 'purchase_report.php',
  'customer' => 'customer.php',
  'customer_form' => 'customer_form.php',
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