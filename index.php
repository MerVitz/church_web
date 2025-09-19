<?php 
/**
 * Main entry point of the website.
 * 
 * This file serves as the **template wrapper** for all pages. It:
 * - Loads the **header** once.
 * - Dynamically loads the **page content** using `router.php`.
 * - Loads the **footer** once.
 * The content displayed in the `<div class="content">` section
 * depends on the value of the `page` parameter in the URL.
 * Example: `index.php?page=about` will load `about.php` dynamically.
 * 
 * Ensures a **structured layout** and prevents accidental page repetition.
 */

 $page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Detect if this is an admin page
$isAdminPage = ['admin-login', 'admin-home'];

if (!in_array($page, $isAdminPage)) {
    include_once 'includes/header.php';
}
?>

<!-- Main Content Section -->
<div class="content" id="content">
    <?php 
    include_once 'routes/router.php';
    ?>
</div>

<?php 
if (!in_array($page, $isAdminPage)) {
    include_once "includes/announcements.php"; 
    include_once 'includes/footer.php';
}
?>