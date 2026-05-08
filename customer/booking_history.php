<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('customer');
require_once __DIR__ . '/../config/db.php';

$customerId = $_SESSION['user_id'];
$history = $pdo->prepare('SELECT b.*, r.room_number, r.room_type FROM bookings b JOIN rooms r ON b.room_id = r.id WHERE b.customer_id = ? ORDER BY b.created_at DESC');
$history->execute([$customerId]);
$history = $history->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Booking History</h2>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>Room</th><th>Check-In</th><th>Check-Out</th><th>Status</th><th>Total</th></tr></thead><tbody>
            <?php foreach ($history as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['room_number']); ?> (<?php echo htmlspecialchars($booking['room_type']); ?>)</td>
                    <td><?php echo htmlspecialchars($booking['check_in_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['check_out_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['status']); ?></td>
                    <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
