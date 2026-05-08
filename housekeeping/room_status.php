<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('housekeeping');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['room_id']) && !empty($_POST['status'])) {
    $stmt = $pdo->prepare('UPDATE rooms SET status = ? WHERE id = ?');
    $stmt->execute([$_POST['status'], $_POST['room_id']]);
    $success = 'Room status updated.';
}
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY room_number')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Room Status</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>Room</th><th>Type</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo htmlspecialchars($room['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                    <td><?php echo htmlspecialchars($room['status']); ?></td>
                    <td>
                        <form method="post" class="d-flex gap-2 align-items-center">
                            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                            <select name="status" class="form-select form-select-sm">
                                <option value="available" <?php echo $room['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                                <option value="occupied" <?php echo $room['status'] === 'occupied' ? 'selected' : ''; ?>>Occupied</option>
                                <option value="cleaning" <?php echo $room['status'] === 'cleaning' ? 'selected' : ''; ?>>Cleaning</option>
                                <option value="maintenance" <?php echo $room['status'] === 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                            </select>
                            <button class="btn btn-sm btn-secondary">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
