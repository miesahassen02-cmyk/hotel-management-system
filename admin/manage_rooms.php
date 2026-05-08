<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['room_number'])) {
    $stmt = $pdo->prepare('INSERT INTO rooms (room_number, room_type, price, status, description) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status'], $_POST['description']]);
    $success = 'Room added successfully.';
}
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY room_number ASC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Manage Rooms</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="card mb-4"><div class="card-body"><h5 class="card-title">Add Room</h5>
            <form method="post" class="row gy-3">
                <div class="col-md-3"><input class="form-control" name="room_number" placeholder="Room Number" required></div>
                <div class="col-md-3">
                    <select class="form-select" name="room_type" required>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="suite">Suite</option>
                        <option value="deluxe">Deluxe</option>
                    </select>
                </div>
                <div class="col-md-2"><input class="form-control" type="number" step="0.01" name="price" placeholder="Price" required></div>
                <div class="col-md-2">
                    <select class="form-select" name="status" required>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                <div class="col-md-12"><textarea class="form-control" name="description" placeholder="Description"></textarea></div>
                <div class="col-12"><button class="btn btn-primary">Save Room</button></div>
            </form>
        </div></div>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>Room</th><th>Type</th><th>Price</th><th>Status</th><th>Description</th></tr></thead><tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo htmlspecialchars($room['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                    <td>$<?php echo number_format($room['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($room['status']); ?></td>
                    <td><?php echo htmlspecialchars($room['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
