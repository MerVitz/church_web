<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../../includes/db.php';

// Set response type to JSON
header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate empty fields
    if (empty($username) || empty($password)) {
        echo json_encode(["error" => "Username and password are required."]);
        exit();
    }

    error_log("Login Attempt - Username: $username");

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        error_log("User Not Found!");
        echo json_encode(["error" => "Unregistered username."]);
        exit();
    }

    error_log("User found in DB: " . json_encode($admin));

    // Verify hashed password
    if (!password_verify($password, $admin['password'])) {
        error_log("Incorrect Password!");
        echo json_encode(["error" => "Incorrect password."]);
        exit();
    }

    // Login successful - Store session
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['admin'] = true;

    error_log("Session Path: " . session_save_path());
    error_log("User logged in successfully.");
    
    echo json_encode(["success" => true, "redirect" => "?page=admin-home"]);
    
    exit();
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['admin']);
}

// Function to redirect unauthorized users
function requireAuth() {
    if (!isLoggedIn()) {
        header("Location: /public/admin/login.php");
        exit();
    }
}

// Function to generate CSRF Token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to verify CSRF Token
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
