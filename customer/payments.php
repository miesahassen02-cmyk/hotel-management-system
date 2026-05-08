<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('customer');
require_once __DIR__ . '/../config/db.php';

$customerId = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['booking_id']) && !empty($_POST['amount'])) {
    $stmt = $pdo->prepare('INSERT INTO payments (booking_id, amount, payment_method) VALUES (?, ?, ?)');
    $stmt->execute([$_POST['booking_id'], $_POST['amount'], $_POST['payment_method']]);
    $success = 'Payment recorded successfully.';
}
$bookings = $pdo->prepare('SELECT id, status FROM bookings WHERE customer_id = ? ORDER BY created_at DESC');
$bookings->execute([$customerId]);
$bookings = $bookings->fetchAll();
$payments = $pdo->prepare('SELECT p.*, b.room_id FROM payments p JOIN bookings b ON p.booking_id = b.id WHERE b.customer_id = ? ORDER BY p.payment_date DESC');
$payments->execute([$customerId]);
$payments = $payments->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Payments</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="card mb-4"><div class="card-body"><h5 class="card-title">Record Payment</h5>
            <form method="post" class="row gy-3">
                <div class="col-md-4">
                    <select class="form-select" name="booking_id" required>
                        <option value="">Select Booking</option>
                        <?php foreach ($bookings as $booking): ?>
                            <option value="<?php echo $booking['id']; ?>">Booking #<?php echo $booking['id']; ?> (<?php echo htmlspecialchars($booking['status']); ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><input type="number" step="0.01" class="form-control" name="amount" placeholder="Amount" required></div>
                <div class="col-md-4">
                    <select class="form-select" name="payment_method">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="online">Online</option>
                    </select>
                </div>
                <div class="col-12"><button class="btn btn-primary">Submit Payment</button></div>
            </form>
        </div></div>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Booking</th><th>Amount</th><th>Method</th><th>Date</th></tr></thead><tbody>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo $payment['id']; ?></td>
                    <td><?php echo $payment['booking_id']; ?></td>
                    <td>$<?php echo number_format($payment['amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
