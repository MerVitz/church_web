<?php
$serverName = $_SERVER['SERVER_NAME'];

if ($serverName === 'localhost' || $serverName === '127.0.0.1') {
    // Localhost settings
    $host = "127.0.0.1";
    $dbname = "church_web";
    $username = "root";
    $password = "";
} else {
    // Live/production settings
    $host = "localhost";
    $dbname = "allsaint_church_web";
    $username = "allsaint_church_admin";
    $password = "churchadmin";
}

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
