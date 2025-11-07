<?php
include_once __DIR__ . '/../../../includes/db.php';

/**
 * Fetch all hero sections.
 */
function getHeroSections($conn) {
    $storagePath = "/public/images/";

    $stmt = $conn->query("SELECT * FROM hero ORDER BY created_at DESC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as &$row) {
        if (!empty($row['image_url'])) {
            $row['image_url'] = $storagePath . $row['image_url'];
        }
    }

    return $rows;
}

/**
 * Fetch a single hero section by ID.
 */
function getHeroById($conn, $id) {
    $storagePath = "/public/images/";

    $stmt = $conn->prepare("SELECT * FROM hero WHERE id = ?");
    $stmt->execute([$id]);
    $hero = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($hero && !empty($hero['image_url'])) {
        $hero['image_url'] = $storagePath . $hero['image_url'];
    }

    return $hero ?: null;
}

/**
 * Update hero section (store filename only).
 */
function updateHero($conn, $id, $title, $content, $image_filename) {
    $stmt = $conn->prepare("UPDATE hero 
                            SET title = :title, content = :content, image_url = :image_url 
                            WHERE id = :id");
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);
    $stmt->bindParam(":image_url", $image_filename);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
    return $stmt->execute();
}

// Handle POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === "updateHero") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $image_filename = basename($_POST['image_url']); // default

    // If new image uploaded
    if (!empty($_FILES['new_image']['name'])) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/public/images/";
        $newFile = time() . "_" . basename($_FILES['new_image']['name']);
        move_uploaded_file($_FILES['new_image']['tmp_name'], $uploadDir . $newFile);
        $image_filename = $newFile;
    }

    if (updateHero($conn, $id, $title, $content, $image_filename)) {
        echo json_encode(["status" => "success", "message" => "Hero updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed."]);
    }
    exit();
}

?>
