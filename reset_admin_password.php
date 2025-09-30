<?php
// reset_admin_password.php
// Run once, then delete

include __DIR__ . '/includes/db.php';

$username = 'admin';
$newPassword = 'NewSecureP@ssw0rd!';

if (empty($newPassword) || strlen($newPassword) < 8) {
    die("Choose a stronger password (min 8 chars).");
}

$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

try {
    // Remove updated_at since your table doesn't have it
    $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE username = ?");
    $stmt->execute([$hashed, $username]);

    if ($stmt->rowCount() > 0) {
        echo "Password reset successfully for user '{$username}'.";
    } else {
        echo "No user found with username '{$username}'.";
    }
} catch (PDOException $e) {
    echo "DB Error: " . htmlspecialchars($e->getMessage());
}
