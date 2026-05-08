<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('housekeeping');
require_once __DIR__ . '/../config/db.php';

$toClean = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'cleaning'")->fetchColumn();
$available = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'available'")->fetchColumn();
$maintenance = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'maintenance'")->fetchColumn();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Housekeeping Dashboard</h2>
        <div class="row">
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Rooms to Clean</h5><p class="card-text"><?php echo $toClean; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Available Rooms</h5><p class="card-text"><?php echo $available; ?></p></div></div></div>
            <div class="col-md-4"><div class="card mb-3"><div class="card-body"><h5 class="card-title">Maintenance Needed</h5><p class="card-text"><?php echo $maintenance; ?></p></div></div></div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
