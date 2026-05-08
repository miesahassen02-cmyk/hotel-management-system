<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('accountant');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['invoice_status']) && !empty($_POST['invoice_id'])) {
        $stmt = $pdo->prepare('UPDATE invoices SET status = ? WHERE id = ?');
        $stmt->execute([$_POST['invoice_status'], $_POST['invoice_id']]);
        $success = 'Invoice status updated.';
    }
    if (!empty($_POST['booking_id']) && !empty($_POST['invoice_total'])) {
        $stmt = $pdo->prepare('INSERT INTO invoices (booking_id, total_amount, status) VALUES (?, ?, ?)');
        $stmt->execute([$_POST['booking_id'], $_POST['invoice_total'], 'unpaid']);
        $success = 'Invoice created successfully.';
    }
}
$bookings = $pdo->query('SELECT b.id, u.full_name, r.room_number FROM bookings b JOIN users u ON b.customer_id = u.id JOIN rooms r ON b.room_id = r.id ORDER BY b.created_at DESC')->fetchAll();
$invoices = $pdo->query('SELECT i.*, u.full_name, r.room_number FROM invoices i JOIN bookings b ON i.booking_id = b.id JOIN users u ON b.customer_id = u.id JOIN rooms r ON b.room_id = r.id ORDER BY i.invoice_date DESC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Invoices</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="card mb-4"><div class="card-body"><h5 class="card-title">Create Invoice</h5>
            <form method="post" class="row gy-3">
                <div class="col-md-4">
                    <select class="form-select" name="booking_id" required>
                        <option value="">Select Booking</option>
                        <?php foreach ($bookings as $booking): ?>
                            <option value="<?php echo $booking['id']; ?>">#<?php echo $booking['id']; ?> - <?php echo htmlspecialchars($booking['full_name']); ?> / Room <?php echo htmlspecialchars($booking['room_number']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><input type="number" step="0.01" class="form-control" name="invoice_total" placeholder="Total Amount" required></div>
                <div class="col-md-4"><button class="btn btn-primary">Create Invoice</button></div>
            </form>
        </div></div>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Booking</th><th>Customer</th><th>Room</th><th>Amount</th><th>Status</th><th>Date</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td><?php echo $invoice['id']; ?></td>
                    <td><?php echo $invoice['booking_id']; ?></td>
                    <td><?php echo htmlspecialchars($invoice['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($invoice['room_number']); ?></td>
                    <td>$<?php echo number_format($invoice['total_amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($invoice['status']); ?></td>
                    <td><?php echo htmlspecialchars($invoice['invoice_date']); ?></td>
                    <td>
                        <form method="post" class="d-flex gap-2">
                            <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                            <select name="invoice_status" class="form-select">
                                <option value="unpaid" <?php echo $invoice['status'] === 'unpaid' ? 'selected' : ''; ?>>Unpaid</option>
                                <option value="paid" <?php echo $invoice['status'] === 'paid' ? 'selected' : ''; ?>>Paid</option>
                                <option value="overdue" <?php echo $invoice['status'] === 'overdue' ? 'selected' : ''; ?>>Overdue</option>
                            </select>
                            <button class="btn btn-sm btn-secondary">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
