<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Expire the session cookie
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, "/");
}

// Redirect to login page using the routing system
header("Location: ?page=admin-login");
exit();
?>
