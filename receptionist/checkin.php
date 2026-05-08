<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('receptionist');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['booking_id'])) {
    $pdo->prepare('UPDATE bookings SET status = ? WHERE id = ?')->execute(['checked_in', $_POST['booking_id']]);
    $success = 'Guest checked in successfully.';
}
$pending = $pdo->query("SELECT b.id, u.full_name, r.room_number FROM bookings b JOIN users u ON b.customer_id = u.id JOIN rooms r ON b.room_id = r.id WHERE b.status = 'confirmed'")->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Check-in</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <?php if (empty($pending)): ?><div class="alert alert-info">No confirmed bookings are available for check-in.</div><?php endif; ?>
        <?php if (!empty($pending)): ?>
            <form method="post" class="row gy-3">
                <div class="col-md-8">
                    <select class="form-select" name="booking_id" required>
                        <option value="">Select Booking</option>
                        <?php foreach ($pending as $booking): ?>
                            <option value="<?php echo $booking['id']; ?>"><?php echo htmlspecialchars($booking['full_name']) . ' - Room ' . htmlspecialchars($booking['room_number']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><button class="btn btn-primary w-100">Check In</button></div>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
