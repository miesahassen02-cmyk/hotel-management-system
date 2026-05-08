<?php
require_once 'includes/auth.php';
if (isLoggedIn()) {
    redirectTo(normalizeRole($_SESSION['role']) . '/dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if (login($username, $password)) {
        redirectTo($_SESSION['role'] . '/dashboard.php');
    }
    $error = 'Invalid username or password.';
}
?>
<?php include 'includes/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Login</h2>
        <div class="alert alert-info">
            <h6 class="fw-bold">Demo accounts</h6>
            <p class="mb-2">Use one of these seeded users to log in immediately:</p>
            <ul class="mb-0">
                <li><strong>admin</strong> / password</li>
                <li><strong>receptionist1</strong> / password</li>
                <li><strong>customer1</strong> / password</li>
                <li><strong>manager1</strong> / password</li>
                <li><strong>housekeeping1</strong> / password</li>
                <li><strong>accountant1</strong> / password</li>
            </ul>
        </div>
        <?php if (!empty($_GET['registered'])): ?><div class="alert alert-success">Registration successful. Please log in.</div><?php endif; ?>
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3">Don&apos;t have an account? <a href="register.php">Register here</a>.</p>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
