<?php
include_once __DIR__ . '/../../../includes/db.php';

/**
 * Fetch all hero sections.
 */
function getHeroSections($conn) {
    $storagePath = "/uploads/heroes/"; // keep inside function

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
    $storagePath = "/uploads/heroes/"; // keep inside function

    $stmt = $conn->prepare("SELECT * FROM hero WHERE id = ?");
    $stmt->execute([$id]);
    $hero = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($hero) {
        if (!empty($hero['image_url'])) {
            $hero['image_url'] = $storagePath . $hero['image_url'];
        }
        return $hero;
    } else {
        return null;
    }
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
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "updateHero") {
    if (!isset($_POST['id'], $_POST['title'], $_POST['content'], $_POST['image_url'])) {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
        exit();
    }

    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_filename = basename($_POST['image_url']); // only filename

    try {
        if (updateHero($conn, $id, $title, $content, $image_filename)) {
            echo json_encode(["status" => "success", "message" => "Hero section updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update hero section."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
    exit();
}
?>
