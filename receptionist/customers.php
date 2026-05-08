<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('receptionist');
require_once __DIR__ . '/../config/db.php';

$customers = $pdo->query("SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC")->fetchAll();
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Customer Management</h2>
        <div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Joined</th></tr></thead><tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo $customer['id']; ?></td>
                    <td><?php echo htmlspecialchars($customer['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                    <td><?php echo htmlspecialchars($customer['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody></table></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
