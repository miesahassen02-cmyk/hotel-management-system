<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('manager');
require_once __DIR__ . '/../config/db.php';

$staff = $pdo->query("SELECT id, username, role, full_name FROM users WHERE role IN ('receptionist', 'housekeeping', 'accountant') ORDER BY role, full_name")->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Staff Monitor</h2>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Name</th><th>Role</th><th>Username</th></tr></thead><tbody>
            <?php foreach ($staff as $member): ?>
                <tr>
                    <td><?php echo $member['id']; ?></td>
                    <td><?php echo htmlspecialchars($member['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($member['role']); ?></td>
                    <td><?php echo htmlspecialchars($member['username']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
