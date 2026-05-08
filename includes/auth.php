<?php
// Authentication helpers
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

function redirectTo($path) {
    header('Location: ' . SITE_URL . ltrim($path, '/'));
    exit;
}

function normalizeRole($role) {
    return trim(strtolower((string) $role));
}

if (isset($_SESSION['role'])) {
    $_SESSION['role'] = normalizeRole($_SESSION['role']);
}

function login($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = normalizeRole($user['role']);
        $_SESSION['full_name'] = $user['full_name'];
        return true;
    }
    return false;
}

function logout() {
    session_unset();
    session_destroy();
    redirectTo('login.php');
}

function isLoggedIn() {
    return !empty($_SESSION['user_id']);
}

function hasRole($role) {
    return isset($_SESSION['role']) && normalizeRole($_SESSION['role']) === normalizeRole($role);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirectTo('login.php');
    }
}

function requireRole($role) {
    requireLogin();
    if (!hasRole($role)) {
        die('Access denied.');
    }
}
?>
