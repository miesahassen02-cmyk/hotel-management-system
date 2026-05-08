<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(SITE_NAME); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass py-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="<?php echo SITE_URL; ?>index.php"><?php echo htmlspecialchars(SITE_NAME); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>index.php">Home</a></li>
                        <li class="nav-item"><span class="nav-link disabled">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-outline-light btn-sm ms-2 rounded-pill" href="<?php echo SITE_URL; ?>register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-5 pb-5">
