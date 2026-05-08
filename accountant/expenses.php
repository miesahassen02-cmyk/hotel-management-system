<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('accountant');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['description']) && !empty($_POST['amount'])) {
    $stmt = $pdo->prepare('INSERT INTO expenses (description, amount, expense_date) VALUES (?, ?, ?)');
    $stmt->execute([$_POST['description'], $_POST['amount'], $_POST['expense_date']]);
    $success = 'Expense recorded successfully.';
}
$expenses = $pdo->query('SELECT * FROM expenses ORDER BY expense_date DESC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Expenses</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="card mb-4"><div class="card-body"><h5 class="card-title">Record Expense</h5>
            <form method="post" class="row gy-3">
                <div class="col-md-4"><input class="form-control" name="description" placeholder="Description" required></div>
                <div class="col-md-3"><input class="form-control" type="number" step="0.01" name="amount" placeholder="Amount" required></div>
                <div class="col-md-3"><input class="form-control" type="date" name="expense_date" value="<?php echo date('Y-m-d'); ?>" required></div>
                <div class="col-md-2"><button class="btn btn-primary w-100">Save Expense</button></div>
            </form>
        </div></div>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Description</th><th>Amount</th><th>Date</th></tr></thead><tbody>
            <?php foreach ($expenses as $expense): ?>
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
<?php include __DIR__ . '/../includes/footer.php'; ?>
