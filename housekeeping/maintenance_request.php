<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('housekeeping');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['request_id']) && !empty($_POST['status'])) {
        $stmt = $pdo->prepare('UPDATE maintenance_requests SET status = ? WHERE id = ?');
        $stmt->execute([$_POST['status'], $_POST['request_id']]);
        $success = 'Maintenance request updated.';
    } elseif (!empty($_POST['room_id']) && !empty($_POST['description'])) {
        $stmt = $pdo->prepare('INSERT INTO maintenance_requests (room_id, request_description, status) VALUES (?, ?, ?)');
        $stmt->execute([$_POST['room_id'], $_POST['description'], 'open']);
        $success = 'Maintenance request submitted.';
    }
}
$rooms = $pdo->query('SELECT * FROM rooms ORDER BY room_number')->fetchAll();
$requests = $pdo->query('SELECT mr.*, r.room_number FROM maintenance_requests mr JOIN rooms r ON mr.room_id = r.id ORDER BY mr.requested_at DESC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Maintenance Request</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="card mb-4"><div class="card-body"><h5 class="card-title">Submit Request</h5>
            <form method="post" class="row gy-3">
                <div class="col-md-4">
                    <select class="form-select" name="room_id" required>
                        <option value="">Select Room</option>
                        <?php foreach ($rooms as $room): ?>
                            <option value="<?php echo $room['id']; ?>">Room <?php echo htmlspecialchars($room['room_number']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6"><textarea class="form-control" name="description" rows="2" placeholder="Request description" required></textarea></div>
                <div class="col-md-2"><button class="btn btn-primary w-100">Submit Request</button></div>
            </form>
        </div></div>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Room</th><th>Description</th><th>Status</th><th>Requested At</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?php echo $request['id']; ?></td>
                    <td><?php echo htmlspecialchars($request['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($request['request_description']); ?></td>
                    <td><?php echo htmlspecialchars($request['status']); ?></td>
                    <td><?php echo htmlspecialchars($request['requested_at']); ?></td>
                    <td>
                        <form method="post" class="d-flex gap-2">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <select name="status" class="form-select form-select-sm">
                                <option value="open" <?php echo $request['status'] === 'open' ? 'selected' : ''; ?>>Open</option>
                                <option value="in_progress" <?php echo $request['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="resolved" <?php echo $request['status'] === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
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
