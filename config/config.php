<?php
// Application configuration

define('SITE_NAME', 'Hotel Management System');
define('SITE_URL', 'http://localhost/hotel%20management%20system/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'hms');
define('DB_USER', 'root');
define('DB_PASS', '');

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('UTC');
?>
