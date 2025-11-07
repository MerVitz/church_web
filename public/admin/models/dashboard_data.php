<?php
include_once __DIR__ . '/../../../includes/db.php';

// Safe count wrapper: handles missing tables or bad queries gracefully
function safeCount($conn, $sql, $context = "") {
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    } catch (PDOException $e) {
        error_log("Dashboard query failed [{$context}]: " . $e->getMessage());
        return 0; // fallback so dashboard doesn’t break
    }
}

function getTotal($conn, $table) {
    return safeCount($conn, "SELECT COUNT(*) AS total FROM $table", "getTotal:$table");
}

function getCountWhere($conn, $table, $condition) {
    return safeCount($conn, "SELECT COUNT(*) AS total FROM $table WHERE $condition", "getCountWhere:$table");
}

try {
    // Top Stats
    $totalAdmins = getTotal($conn, "admins");
    $totalDepartments = getTotal($conn, "Departments");
    $totalMembers = getTotal($conn, "new_members");
    $totalPrayerRequests = getTotal($conn, "prayer_requests");

    // Church Engagement
    $unreadMessages = getCountWhere($conn, "contact_messages", "status = 'unread'");
    $upcomingEvents = getCountWhere($conn, "upcoming_events", "date >= CURDATE()");
    $pendingAnnouncements = getCountWhere($conn, "announcements", "status = 'draft'");

    // Departments Trends
    $totalDepartmentsApplications = getTotal($conn, "department_applications");
    $newDepartmentApplications = getCountWhere(
        $conn,
        "department_applications",
        "submitted_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)"
    );

    // Top Requested Departments
    $topDepartments = [];
    try {
        $stmt = $conn->prepare("
            SELECT department_name, COUNT(*) AS count 
            FROM department_applications 
            GROUP BY department_name 
            ORDER BY count DESC 
            LIMIT 3
        ");
        $stmt->execute();
        $topDepartments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Dashboard query failed [topDepartments]: " . $e->getMessage());
    }

    // Content & Media
    $totalSermons = getTotal($conn, "latest_sermons");
    $totalAudioSermons = getTotal($conn, "audio_sermons");
    $totalImageSets = getTotal($conn, "gallery");

    // Most Recent Sermon
    $recentSermon = ["title" => "N/A", "speaker" => "N/A", "date" => "N/A"];
    try {
        $stmt = $conn->prepare("SELECT title, speaker, date FROM latest_sermons ORDER BY date DESC LIMIT 1");
        $stmt->execute();
        $recentSermon = $stmt->fetch(PDO::FETCH_ASSOC) ?: $recentSermon;
    } catch (PDOException $e) {
        error_log("Dashboard query failed [recentSermon]: " . $e->getMessage());
    }

    // Return JSON Response
    echo json_encode([
        'totalAdmins' => $totalAdmins,
        'totalDepartments' => $totalDepartments,
        'totalMembers' => $totalMembers,
        'totalPrayerRequests' => $totalPrayerRequests,
        'unreadMessages' => $unreadMessages,
        'upcomingEvents' => $upcomingEvents,
        'pendingAnnouncements' => $pendingAnnouncements,
        'totalDepartmentApplications' => $totalDepartmentsApplications,
        'newDepartmentApplications' => $newDepartmentApplications,
        'topDepartments' => $topDepartments,
        'totalSermons' => $totalSermons,
        'totalAudioSermons' => $totalAudioSermons,
        'totalImageSets' => $totalImageSets,
        'recentSermon' => $recentSermon
    ]);

} catch (Exception $e) {
    error_log("Dashboard failed: " . $e->getMessage());
    echo json_encode(['error' => 'Dashboard data could not be loaded.']);
}