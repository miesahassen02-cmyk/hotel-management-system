<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/db.php';

$revenue = $pdo->query('SELECT IFNULL(SUM(amount), 0) FROM payments')->fetchColumn();
$bookingsCount = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$unpaidCount = $pdo->query("SELECT COUNT(*) FROM invoices WHERE status = 'unpaid'")->fetchColumn();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Admin Reports</h2>
        <div class="row">
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Total Revenue</h5><p class="card-text">$<?php echo number_format($revenue, 2); ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Total Bookings</h5><p class="card-text"><?php echo $bookingsCount; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Unpaid Invoices</h5><p class="card-text"><?php echo $unpaidCount; ?></p></div></div></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
