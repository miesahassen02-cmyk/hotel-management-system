<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('receptionist');
require_once __DIR__ . '/../config/db.php';

$rooms = $pdo->query('SELECT * FROM rooms ORDER BY room_number ASC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Room Availability</h2>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>Room</th><th>Type</th><th>Status</th><th>Price</th></tr></thead><tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo htmlspecialchars($room['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                    <td><?php echo htmlspecialchars($room['status']); ?></td>
                    <td>$<?php echo number_format($room['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
