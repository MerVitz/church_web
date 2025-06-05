<?php
include_once "db.php";

/**
 * Fetch contact details from the database.
 */
function getContactInfo() {
    global $conn;
    $stmt = $conn->prepare("SELECT location, phone, email FROM contact_details LIMIT 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fetch giving & offerings details.
 */
function getGivingOfferings() {
    global $conn;
    $stmt = $conn->prepare("SELECT paybill, assistance_phone FROM giving_offerings LIMIT 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fetch social media links.
 */
function getSocialLinks() {
    global $conn;
    $stmt = $conn->prepare("SELECT platform, url, icon FROM social_links");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Fetch announcements from the database.
 */
function getAnnouncements() {
    global $conn;
    $stmt = $conn->prepare("SELECT id, title, content, views FROM announcements ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Fetch notices from the database.
 */
function getNotices() {
    global $conn;
    $stmt = $conn->prepare("SELECT id, notice_text, read_count, created_at FROM notices ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Fetch Vision, Mission, and Slogan content.
 */
function getVisionMissionSlogan() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vision_mission_slogan ORDER BY id ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Fetch Hero Section Content (Max 3 Items).
 */
function getHeroContent() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM hero ORDER BY id ASC LIMIT 3");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Fetch Gallery preview pictures.
 */
function getGallery() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM gallery ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Fetch Latest Audio Sermons Data.
 */
function getLatestAudioSermons() {
    global $conn;
    $stmt = $conn->query("SELECT title, date, audio_file FROM audio_sermons ORDER BY date DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Fetch Latest Video Sermons Data.
 */
function getLatestSermons() {
    global $conn;
    $stmt = $conn->query("SELECT title, date, speaker, youtube_link FROM latest_sermons ORDER BY date DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Fetch Who We Are section data.
 */
function getWhoWeAre() {
    global $conn;
    $stmt = $conn->query("SELECT title, content, image_url FROM who_we_are LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



/**
 * Fetch all historical records.
 */
function getHistory() {
    global $conn;
    return $conn->query("SELECT * FROM history ORDER BY id ASC")->fetchAll();
}


/**
 * Fetch all departments.
 */
function getDepartments() {
    global $conn;
    return $conn->query("SELECT * FROM departments ORDER BY id ASC")->fetchAll();
}


/**
 * Fetch all upcoming events.
 */
function getUpcomingEvents() {
    global $conn;
    return $conn->query("SELECT * FROM upcoming_events ORDER BY date ASC")->fetchAll();
}

/**
 * Fetch all activities.
 */
function getActivities() {
    global $conn;
    return $conn->query("SELECT * FROM activities ORDER BY id DESC")->fetchAll();
}

/**
 * Fetch administration leaders.
 */
function getAdministrationLeaders() {
    global $conn;
    return $conn->query("SELECT * FROM administration ORDER BY id ASC")->fetchAll();
}

/**
 * Fetch the vicar welcome message.
 */
function getWelcomeMessage() {
    global $conn;
    return $conn->query("SELECT * FROM welcome_message LIMIT 1")->fetch(PDO::FETCH_ASSOC);
}

/**
 * Handles membership form submission
 * @return void
 */
function handleMembershipSubmission() {
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["membership_request"])) {
        $name = trim($_POST["full-name"]);
        $email = !empty($_POST["email"]) ? trim($_POST["email"]) : NULL;
        $phone = !empty($_POST["phone"]) ? trim($_POST["country-code"]) . trim($_POST["phone"]) : NULL;
        $location = trim($_POST["location"]);

        if (empty($name) || empty($location)) {
            echo json_encode(["status" => "error", "message" => "Full name and location are required."]);
            exit();
        }

        try {
            // Insert into `new_members` table
            $stmt = $conn->prepare("INSERT INTO new_members (name, email, phone, location, submitted_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $phone, $location]);

            echo json_encode(["status" => "success", "message" => "Your membership application has been received."]);
            exit();
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
            exit();
        }
    }
}



/**
 * Handles contact form submission
 * @return void
 */
function handleContactSubmission() {
    global $conn;

    error_log("handleContactSubmission() function triggered"); // Debugging

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contact_request"])) {
        error_log("contact_request is set in POST request");

        $name = isset($_POST["name"]) ? trim($_POST["name"]) : null;
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
        $countryCode = isset($_POST["country-code"]) ? trim($_POST["country-code"]) : "";
        $phone = (isset($_POST["phone"]) && !empty($_POST["phone"])) ? $countryCode . trim($_POST["phone"]) : null;
        $message = isset($_POST["message"]) ? trim($_POST["message"]) : null;

        error_log("Received Data: Name=$name, Email=$email, Phone=$phone, Message=$message");

        // Validate input
        if (empty($name) || empty($message)) {
            echo json_encode(["status" => "error", "message" => "Name and message are required."]);
            exit();
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Invalid email address."]);
            exit();
        }

        try {
            // Insert into `contact_messages` table
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message, submitted_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $phone, $message]);

            echo json_encode(["status" => "success", "message" => "Your message has been sent successfully."]);
            error_log("Message inserted successfully");
            exit();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
            exit();
        }
    }
}


/**
 * Handles department application form submission
 * @return string JSON response
 */
function handleDepartmentApplication() {
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["department_application"])) {
        $fullName = trim($_POST["fullName"]);
        $email = trim($_POST["emailJoin"]);
        $phone = trim($_POST["phoneJoin"]);
        $departmentName = trim($_POST["departmentName"]);

        try {
            // Insert into `department_applications` table
            $stmt = $conn->prepare("INSERT INTO department_applications (full_name, email, phone, department_name) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fullName, $email, $phone, $departmentName]);

            echo json_encode(["status" => "success", "message" => "Your request has been received successfully."]);
            exit();
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
            exit();
        }
    }
}

/**
 * Handles prayer request form submission
 * @return void
 */
function handlePrayerRequest() {
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["prayer_request"])) {
        $prayerRequest = trim($_POST["prayerRequest"]);
        $email = !empty($_POST["email"]) ? trim($_POST["email"]) : NULL;
        $phone = !empty($_POST["phone"]) ? trim($_POST["phone"]) : NULL;

        if (empty($prayerRequest)) {
            echo json_encode(["status" => "error", "message" => "Prayer request is required."]);
            exit();
        }

        try {
            // Insert into `prayer_requests` table
            $stmt = $conn->prepare("INSERT INTO prayer_requests (request, email, phone, submitted_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$prayerRequest, $email, $phone]);

            echo json_encode(["status" => "success", "message" => "Your prayer request has been submitted successfully."]);
            exit();
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
            exit();
        }
    }
}

// Call the functions to process the requests
handlePrayerRequest();
handleDepartmentApplication();
handleContactSubmission();
handleMembershipSubmission();
?>
