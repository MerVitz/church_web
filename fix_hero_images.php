<?php
// RUN THIS SCRIPT ONLY ONCE THEN DELETE IT.

include_once __DIR__ . "/includes/db.php";

try {
    // Fetch all hero rows
    $stmt = $conn->query("SELECT id, image_url FROM hero");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $id = $row['id'];
        $filename = basename($row['image_url']); // extract only filename

        // Update DB with filename only
        $update = $conn->prepare("UPDATE hero SET image_url = ? WHERE id = ?");
        $update->execute([$filename, $id]);

        echo "Updated ID $id → $filename<br>";
    }

    echo "<br><strong>Done. All hero image paths cleaned successfully.</strong>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
