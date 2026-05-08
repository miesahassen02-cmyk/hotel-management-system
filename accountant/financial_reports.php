<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('accountant');
require_once __DIR__ . '/../config/db.php';

function fetchReportValue(PDO $pdo, $sql) {
    try {
        return $pdo->query($sql)->fetchColumn();
    } catch (PDOException $e) {
        return false;
    }
}

$revenue = fetchReportValue($pdo, 'SELECT IFNULL(SUM(amount), 0) FROM payments');
$expensesTotal = fetchReportValue($pdo, 'SELECT IFNULL(SUM(amount), 0) FROM expenses');
$outstanding = fetchReportValue($pdo, "SELECT IFNULL(SUM(total_amount), 0) FROM invoices WHERE status = 'unpaid'");
$recentExpenses = [];
$schemaError = false;

if ($expensesTotal === false || $revenue === false || $outstanding === false) {
    $schemaError = true;
    $revenue = $revenue === false ? 0 : $revenue;
    $expensesTotal = $expensesTotal === false ? 0 : $expensesTotal;
    $outstanding = $outstanding === false ? 0 : $outstanding;
}
$profit = $revenue - $expensesTotal;

if (!$schemaError) {
    try {
        $recentExpenses = $pdo->query('SELECT * FROM expenses ORDER BY expense_date DESC LIMIT 10')->fetchAll();
    } catch (PDOException $e) {
        $schemaError = true;
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Financial Reports</h2>
        <?php if ($schemaError): ?>
            <div class="alert alert-warning">The financial schema is not fully initialized. Please import <strong>database/hms.sql</strong> or create the missing tables in the <code>hms</code> database.</div>
        <?php endif; ?>
        <div class="row mb-4">
            <div class="col-md-3"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Revenue</h5><p class="card-text">$<?php echo number_format($revenue, 2); ?></p></div></div></div>
            <div class="col-md-3"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Expenses</h5><p class="card-text">$<?php echo number_format($expensesTotal, 2); ?></p></div></div></div>
            <div class="col-md-3"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Profit</h5><p class="card-text">$<?php echo number_format($profit, 2); ?></p></div></div></div>
            <div class="col-md-3"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Outstanding</h5><p class="card-text">$<?php echo number_format($outstanding, 2); ?></p></div></div></div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Expenses</h5>
                <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Description</th><th>Amount</th><th>Date</th></tr></thead><tbody>
                    <?php foreach ($recentExpenses as $expense): ?>
                        <tr>
                            <td><?php echo $expense['id']; ?></td>
                            <td><?php echo htmlspecialchars($expense['description']); ?></td>
                            <td>$<?php echo number_format($expense['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($expense['expense_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody></table></div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
