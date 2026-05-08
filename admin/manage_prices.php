<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['room_id']) && isset($_POST['price'])) {
    $stmt = $pdo->prepare('UPDATE rooms SET price = ? WHERE id = ?');
    $stmt->execute([$_POST['price'], $_POST['room_id']]);
    $success = 'Room price updated.';
}
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY room_number ASC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Manage Prices</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>Room</th><th>Type</th><th>Current Price</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo htmlspecialchars($room['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                    <td>$<?php echo number_format($room['price'], 2); ?></td>
                    <td>
                        <form method="post" class="d-flex gap-2">
                            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                            <input type="number" step="0.01" class="form-control form-control-sm" name="price" placeholder="New price" required>
                            <button class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
