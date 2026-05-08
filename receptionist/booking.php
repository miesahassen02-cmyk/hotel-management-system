<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('receptionist');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['customer_id']) && !empty($_POST['room_id'])) {
    $stmt = $pdo->prepare('INSERT INTO bookings (customer_id, room_id, check_in_date, check_out_date, total_amount, status) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['customer_id'], $_POST['room_id'], $_POST['check_in_date'], $_POST['check_out_date'], $_POST['total_amount'], 'confirmed']);
    $pdo->prepare('UPDATE rooms SET status = ? WHERE id = ?')->execute(['occupied', $_POST['room_id']]);
    $success = 'Booking confirmed successfully.';
}
$customers = $pdo->query("SELECT id, full_name FROM users WHERE role = 'customer'")->fetchAll();
$rooms = $pdo->query("SELECT * FROM rooms WHERE status = 'available' ORDER BY room_number")->fetchAll();
$bookings = $pdo->query('SELECT b.*, u.full_name AS customer_name, r.room_number FROM bookings b JOIN users u ON b.customer_id = u.id JOIN rooms r ON b.room_id = r.id ORDER BY b.created_at DESC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Booking / Reservation</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <div class="card mb-4"><div class="card-body"><h5 class="card-title">Create Booking</h5>
            <form method="post" class="row gy-3">
                <div class="col-md-4">
                    <select class="form-select" name="customer_id" required>
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer['id']; ?>"><?php echo htmlspecialchars($customer['full_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="room_id" required>
                        <option value="">Select Room</option>
                        <?php foreach ($rooms as $room): ?>
                            <option value="<?php echo $room['id']; ?>"><?php echo htmlspecialchars($room['room_number']) . ' (' . htmlspecialchars($room['room_type']) . ')'; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><input type="date" class="form-control" name="check_in_date" required></div>
                <div class="col-md-4"><input type="date" class="form-control" name="check_out_date" required></div>
                <div class="col-md-4"><input type="number" step="0.01" class="form-control" name="total_amount" placeholder="Total Amount" required></div>
                <div class="col-12"><button class="btn btn-primary">Confirm Booking</button></div>
            </form>
        </div></div>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Customer</th><th>Room</th><th>Check-In</th><th>Check-Out</th><th>Status</th></tr></thead><tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo htmlspecialchars($booking['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($booking['check_in_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['check_out_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
