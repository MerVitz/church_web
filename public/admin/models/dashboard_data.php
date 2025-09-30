<?php
include_once __DIR__ . '/../../../includes/db.php';

try {
    // Fetch Total Counts
    function getTotal($conn, $table) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM $table");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    $totalAdmins = getTotal($conn, "admins");
    $totalMinistries = getTotal($conn, "ministries");
    $totalMembers = getTotal($conn, "new_members");
    $totalPrayerRequests = getTotal($conn, "prayer_requests");

    // Church Engagement
    function getCountWhere($conn, $table, $condition) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM $table WHERE $condition");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    $unreadMessages = getCountWhere($conn, "contact_messages", "status = 'unread'");
    $upcomingEvents = getCountWhere($conn, "upcoming_events", "date >= CURDATE()");
    $pendingAnnouncements = getCountWhere($conn, "announcements", "status='draft'");

    // Ministry Trends
    $totalMinistryApplications = getTotal($conn, "ministry_applications");
    $newMinistryApplications = getCountWhere($conn, "ministry_applications", "submitted_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");

    // Top Requested Ministries
    $stmt = $conn->prepare("SELECT ministry_name, COUNT(*) AS count FROM ministry_applications GROUP BY ministry_name ORDER BY count DESC LIMIT 3");
    $stmt->execute();
    $topMinistries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Content & Media
    $totalSermons = getTotal($conn, "latest_sermons");
    $totalAudioSermons = getTotal($conn, "audio_sermons");
    $totalImageSets = getTotal($conn, "gallery");

    // Most Recent Sermon
    $stmt = $conn->prepare("SELECT title, speaker, date FROM latest_sermons ORDER BY date DESC LIMIT 1");
    $stmt->execute();
    $recentSermon = $stmt->fetch(PDO::FETCH_ASSOC) ?: ["title" => "N/A", "speaker" => "N/A", "date" => "N/A"];

    // Return JSON Response
    echo json_encode([
        'totalAdmins' => $totalAdmins,
        'totalMinistries' => $totalMinistries,
        'totalMembers' => $totalMembers,
        'totalPrayerRequests' => $totalPrayerRequests,
        'unreadMessages' => $unreadMessages,
        'upcomingEvents' => $upcomingEvents,
        'pendingAnnouncements' => $pendingAnnouncements,
        'totalMinistryApplications' => $totalMinistryApplications,
        'newMinistryApplications' => $newMinistryApplications,
        'topMinistries' => $topMinistries,
        'totalSermons' => $totalSermons,
        'totalAudioSermons' => $totalAudioSermons,
        'totalImageSets' => $totalImageSets,
        'recentSermon' => $recentSermon
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
}
?>
