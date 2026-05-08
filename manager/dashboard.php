<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('manager');
require_once __DIR__ . '/../config/db.php';

$occupied = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'occupied'")->fetchColumn();
$totalRooms = $pdo->query('SELECT COUNT(*) FROM rooms')->fetchColumn();
$pendingBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$revenue = $pdo->query('SELECT IFNULL(SUM(amount),0) FROM payments')->fetchColumn();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Manager Dashboard</h2>
        <div class="row">
            <div class="col-md-3"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Occupancy</h5><p class="card-text"><?php echo $occupied . ' / ' . $totalRooms; ?></p></div></div></div>
            <div class="col-md-3"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Pending Bookings</h5><p class="card-text"><?php echo $pendingBookings; ?></p></div></div></div>
            <div class="col-md-3"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Revenue</h5><p class="card-text">$<?php echo number_format($revenue, 2); ?></p></div></div></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
