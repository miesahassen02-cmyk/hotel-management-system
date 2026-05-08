<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('receptionist');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['booking_id'])) {
    $stmt = $pdo->prepare('SELECT room_id FROM bookings WHERE id = ?');
    $stmt->execute([$_POST['booking_id']]);
    $roomId = $stmt->fetchColumn();
    $pdo->prepare('UPDATE bookings SET status = ? WHERE id = ?')->execute(['checked_out', $_POST['booking_id']]);
    if ($roomId) {
        $pdo->prepare('UPDATE rooms SET status = ? WHERE id = ?')->execute(['cleaning', $roomId]);
    }
    $success = 'Guest checked out successfully.';
}
$checkedIn = $pdo->query("SELECT b.id, u.full_name, r.room_number FROM bookings b JOIN users u ON b.customer_id = u.id JOIN rooms r ON b.room_id = r.id WHERE b.status = 'checked_in'")->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Check-out</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <?php if (empty($checkedIn)): ?><div class="alert alert-info">No guests are currently checked in.</div><?php endif; ?>
        <?php if (!empty($checkedIn)): ?>
            <form method="post" class="row gy-3">
                <div class="col-md-8">
                    <select class="form-select" name="booking_id" required>
                        <option value="">Select Checked-in Booking</option>
                        <?php foreach ($checkedIn as $booking): ?>
                            <option value="<?php echo $booking['id']; ?>"><?php echo htmlspecialchars($booking['full_name']) . ' - Room ' . htmlspecialchars($booking['room_number']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><button class="btn btn-primary w-100">Check Out</button></div>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
