<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('receptionist');
require_once __DIR__ . '/../config/db.php';

$confirmed = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'confirmed'")->fetchColumn();
$checkedIn = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'checked_in'")->fetchColumn();
$availableRooms = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'available'")->fetchColumn();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Receptionist Dashboard</h2>
        <div class="row">
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Confirmed Bookings</h5><p class="card-text"><?php echo $confirmed; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Checked-in Guests</h5><p class="card-text"><?php echo $checkedIn; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Available Rooms</h5><p class="card-text"><?php echo $availableRooms; ?></p></div></div></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
