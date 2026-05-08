<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('customer');
require_once __DIR__ . '/../config/db.php';

$customerId = $_SESSION['user_id'];
$bookingCount = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE customer_id = ?');
$bookingCount->execute([$customerId]);
$bookingCount = $bookingCount->fetchColumn();
$paymentCount = $pdo->prepare('SELECT COUNT(*) FROM payments WHERE booking_id IN (SELECT id FROM bookings WHERE customer_id = ?)');
$paymentCount->execute([$customerId]);
$paymentCount = $paymentCount->fetchColumn();
$availableRooms = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'available'")->fetchColumn();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Customer Dashboard</h2>
        <div class="row">
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Your Bookings</h5><p class="card-text"><?php echo $bookingCount; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Payments Made</h5><p class="card-text"><?php echo $paymentCount; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Available Rooms</h5><p class="card-text"><?php echo $availableRooms; ?></p></div></div></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
