<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('housekeeping');
require_once __DIR__ . '/../config/db.php';

$cleaningRooms = $pdo->query('SELECT * FROM rooms WHERE status = "cleaning" ORDER BY room_number')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Cleaning Schedule</h2>
        <?php if (empty($cleaningRooms)): ?>
            <div class="alert alert-info">No rooms are currently scheduled for cleaning.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($cleaningRooms as $room): ?>
                    <div class="col-md-6 mb-3"><div class="card"><div class="card-body">
                        <h5 class="card-title">Room <?php echo htmlspecialchars($room['room_number']); ?></h5>
                        <p class="card-text">Type: <?php echo htmlspecialchars($room['room_type']); ?></p>
                        <p class="card-text">Description: <?php echo htmlspecialchars($room['description']); ?></p>
                    </div></div></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
