<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = normalizeRole($_POST['role'] ?? 'customer');
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($username && $password && $email) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username, password, email, role, full_name, phone) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$username, $passwordHash, $email, $role, $full_name, $phone]);
        $success = 'User added successfully.';
    } else {
        $error = 'Username, password, and email are required.';
    }
}
$users = $pdo->query('SELECT * FROM users ORDER BY created_at DESC')->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Manage Users</h2>
        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <div class="card mb-4"><div class="card-body"><h5 class="card-title">Add User</h5>
            <form method="post" class="row gy-3">
                <div class="col-md-4"><input class="form-control" name="username" placeholder="Username" required></div>
                <div class="col-md-4"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
                <div class="col-md-4"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
                <div class="col-md-4"><input class="form-control" name="full_name" placeholder="Full Name"></div>
                <div class="col-md-4"><input class="form-control" name="phone" placeholder="Phone"></div>
                <div class="col-md-4">
                    <select class="form-select" name="role" required>
                        <option value="customer">Customer</option>
                        <option value="receptionist">Receptionist</option>
                        <option value="manager">Manager</option>
                        <option value="housekeeping">Housekeeping</option>
                        <option value="accountant">Accountant</option>
                    </select>
                </div>
                <div class="col-12"><button class="btn btn-primary">Save User</button></div>
            </form>
        </div></div>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Name</th><th>Phone</th></tr></thead><tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
