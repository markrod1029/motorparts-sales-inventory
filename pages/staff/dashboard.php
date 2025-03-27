<?php

// Function to count total records in a table
function total_count($conn, $table)
{
    $query = "SELECT COUNT(*) FROM $table";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result)[0] ?? 0;
}

// Function to sum a column with optional filters
function getTotalSales($conn, $year = null, $month = null)
{
    $id = $_SESSION['staff'];
    $query = "SELECT SUM(subtotal) FROM sales WHERE user_id = '$id'"; // Base query

    if ($year) {
        $query .= " AND YEAR(order_date) = $year";
    }

    if ($month) {
        $query .= " AND MONTH(order_date) = $month";
    }

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result)[0] ?? 0;
}

// Function to get total transactions (total cost of purchases) with filters
function getTotalTransactions($conn, $year = null, $month = null) {
    $query = "SELECT SUM(buy_price * purchase_quantity) FROM factory_products WHERE 1";

    if ($year) {
        $query .= " AND YEAR(created_at) = $year";
    }
    if ($month) {
        $query .= " AND MONTH(created_at) = $month";
    }

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result)[0] ?? 0;
}

// Function to get total quantity bought with filters
function getTotalBuyProduct($conn, $year = null, $month = null) {
    $query = "SELECT SUM(purchase_quantity) FROM factory_products WHERE 1";

    if ($year) {
        $query .= " AND YEAR(created_at) = $year";
    }
    if ($month) {
        $query .= " AND MONTH(created_at) = $month";
    }

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result)[0] ?? 0;
}

// Get filters from dropdown selection
$selected_year = $_GET['year'] ?? date('Y');
$selected_month = $_GET['month'] ?? null;

// Fetching totals
$total_products = total_count($conn, 'products');
$total_sales = getTotalSales($conn, $selected_year, $selected_month);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Analytics</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Analytics</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content" style="min-height:80vh;">
        <div class="container-fluid">

            <!-- Filters Row -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="font-weight-bold">Select Year</label>
                    <form method="GET" action="">
                        <select name="year" class="form-control" onchange="this.form.submit()">
                            <option value="">All Years</option>
                            <?php
                            $current_year = date('Y');
                            for ($y = $current_year; $y >= 2000; $y--) {
                                $selected = ($selected_year == $y) ? "selected" : "";
                                echo "<option value='$y' $selected>$y</option>";
                            }
                            ?>
                        </select>
                    </form>
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">Select Month</label>
                    <form method="GET" action="">
                        <select name="month" class="form-control" onchange="this.form.submit()">
                            <option value="">All Months</option>
                            <?php
                            for ($m = 1; $m <= 12; $m++) {
                                $month_name = date('F', mktime(0, 0, 0, $m, 1));
                                $selected = ($selected_month == $m) ? "selected" : "";
                                echo "<option value='$m' $selected>$month_name</option>";
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Info Boxes Row -->
            <div class="row">
                <!-- Total Products -->
                <div class="col-xl-6 col-sm-6">
                    <div class="info-box bg-primary">
                        <div class="info-box-content">
                            <span class="info-box-text">Total Products</span>
                            <span class="info-box-number"><?php echo $total_products; ?></span>
                        </div>
                        <span class="info-box-icon"><i class="material-symbols-outlined">inventory</i></span>
                    </div>
                </div>

          

                <!-- Total Sales -->
                <div class="col-xl-6 col-sm-6">
                    <div class="info-box bg-info">
                        <div class="info-box-content">
                            <span class="info-box-text">Total Sales</span>
                            <span class="info-box-number"><?php echo number_format($total_sales, 2); ?></span>
                        </div>
                        <span class="info-box-icon"><i class="material-symbols-outlined">sell</i></span>
                    </div>
                </div>
            </div>

         

        </div>
    </section>
</div>

<?php mysqli_close($conn); ?>
