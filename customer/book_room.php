<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('customer');
require_once __DIR__ . '/../config/db.php';

$rooms = $pdo->query('SELECT * FROM rooms WHERE status = "available" ORDER BY room_number')->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['room_id'])) {
    $customerId = $_SESSION['user_id'];
    $stmt = $pdo->prepare('INSERT INTO bookings (customer_id, room_id, check_in_date, check_out_date, total_amount, status) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$customerId, $_POST['room_id'], $_POST['check_in_date'], $_POST['check_out_date'], $_POST['total_amount'], 'pending']);
    $pdo->prepare('UPDATE rooms SET status = ? WHERE id = ?')->execute(['occupied', $_POST['room_id']]);
    $success = 'Room booked successfully. Awaiting confirmation.';
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Book Room</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <form method="post" class="row gy-3">
            <div class="col-md-4">
                <select class="form-select" name="room_id" required>
                    <option value="">Choose a room</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?php echo $room['id']; ?>"><?php echo htmlspecialchars($room['room_number']) . ' (' . htmlspecialchars($room['room_type']) . ') - $' . number_format($room['price'], 2); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4"><input type="date" class="form-control" name="check_in_date" required></div>
            <div class="col-md-4"><input type="date" class="form-control" name="check_out_date" required></div>
            <div class="col-md-4"><input type="number" step="0.01" class="form-control" name="total_amount" placeholder="Total Amount" required></div>
            <div class="col-12"><button class="btn btn-primary">Book Now</button></div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
