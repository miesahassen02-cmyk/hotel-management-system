<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('accountant');
require_once __DIR__ . '/../config/db.php';

function safeQueryValue($pdo, $sql) {
    try {
        return $pdo->query($sql)->fetchColumn();
    } catch (PDOException $e) {
        return false;
    }
}

$revenue = safeQueryValue($pdo, 'SELECT IFNULL(SUM(amount), 0) FROM payments');
$unpaidInvoiceCount = safeQueryValue($pdo, "SELECT COUNT(*) FROM invoices WHERE status = 'unpaid'");
$expenseTotal = safeQueryValue($pdo, 'SELECT IFNULL(SUM(amount), 0) FROM expenses');
$schemaError = $expenseTotal === false || $revenue === false || $unpaidInvoiceCount === false;
if ($revenue === false) {
    $revenue = 0;
}
if ($unpaidInvoiceCount === false) {
    $unpaidInvoiceCount = 0;
}
if ($expenseTotal === false) {
    $expenseTotal = 0;
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Accountant Dashboard</h2>
        <?php if ($schemaError): ?>
            <div class="alert alert-warning">The accountant dashboard is missing required data tables. Please import <strong>database/hms.sql</strong> in MySQL or create the missing tables.</div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Total Revenue</h5><p class="card-text">$<?php echo number_format($revenue, 2); ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Unpaid Invoices</h5><p class="card-text"><?php echo $unpaidInvoiceCount; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Total Expenses</h5><p class="card-text">$<?php echo number_format($expenseTotal, 2); ?></p></div></div></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
