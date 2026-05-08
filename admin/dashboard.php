<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/db.php';

$totalUsers = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$totalRooms = $pdo->query('SELECT COUNT(*) FROM rooms')->fetchColumn();
$activeBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status IN ('pending','confirmed','checked_in')")->fetchColumn();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Admin Dashboard</h2>
        <div class="row">
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Total Users</h5><p class="card-text"><?php echo $totalUsers; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Total Rooms</h5><p class="card-text"><?php echo $totalRooms; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Active Bookings</h5><p class="card-text"><?php echo $activeBookings; ?></p></div></div></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
