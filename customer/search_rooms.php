<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('customer');
require_once __DIR__ . '/../config/db.php';

$rooms = $pdo->query('SELECT * FROM rooms WHERE status = "available" ORDER BY room_number')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Search Rooms</h2>
        <div class="row">
            <?php foreach ($rooms as $room): ?>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Room <?php echo htmlspecialchars($room['room_number']); ?></h5>
                            <p class="card-text">Type: <?php echo htmlspecialchars($room['room_type']); ?></p>
                            <p class="card-text">Price: $<?php echo number_format($room['price'], 2); ?></p>
                            <p class="card-text">Status: <?php echo htmlspecialchars($room['status']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($room['description']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
