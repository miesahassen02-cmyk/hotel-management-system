<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('admin');
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <h2>Settings</h2>
        <div class="card"><div class="card-body"><p>Manage application settings and administrative preferences here.</p></div></div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
