<?php
/**
 * Admin Hero Section Editor
 * ---------------------------------------
 * Purpose:
 * - Provides an interface for admins to edit the homepage hero slider.
 * - Allows selecting a hero slide, fetching its details via AJAX, and updating them.
 *
 * Features:
 * - Session-protected (only logged-in admins can access).
 * - Dropdown list of available hero slides from DB.
 * - Form to edit title, content, and image URL.
 * - AJAX form submission to update hero data without page reload.
 *
 * Dependencies:
 * - Requires `heroModel.php` for DB interactions:
 *      - getHeroSections($conn) → fetches all hero slides
 *      - getHeroById($conn, $id) → fetches details of a single hero
 *      - POST with action=updateHero → updates slide details
 * - Requires active session with `$_SESSION['admin']`.
 *
 * Security:
 * - Redirects unauthorized users to login.
 * - Uses prepared statements inside heroModel (not here).
 */

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: /?page=admin-login");
    exit();
}

include_once __DIR__ . "/../models/heroModel.php";

// Fetch all hero slides for dropdown
$heroSections = getHeroSections($conn);

// If hero_id is requested, return data as JSON (AJAX endpoint)
if (isset($_GET['hero_id'])) {
    $heroData = getHeroById($conn, $_GET['hero_id']);
    echo json_encode($heroData ?: ["error" => "Hero section not found"]);
    exit();
}
?>
<div class="h-full w-full flex flex-col space-y-6 p-6 overflow-y-auto">

    <h1 class="text-3xl font-bold text-gray-700 mb-6">Edit Homepage Hero Section</h1>

    <!-- Dropdown to select hero slide -->
    <label for="hero_id" class="block text-lg font-semibold text-gray-700 mb-2">Select Hero Slide:</label>
    <select name="hero_id" id="hero_id" class="w-full p-2 border border-gray-300 rounded-md" onchange="loadHeroDetails(this.value)">
        <option value="">-- Select a Hero Slide --</option>
        <?php foreach ($heroSections as $index => $hero): ?>
            <option value="<?= htmlspecialchars($hero['id']) ?>">Slide <?= $index + 1 ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Hero Edit Form -->
    <div id="editHeroSection" class="hidden mt-6">
        <div id="heroMessage" class="hidden p-3 text-center font-semibold rounded-md mb-4"></div>
        
        <form method="POST" id="heroForm">
            <input type="hidden" name="id" id="hero_id_hidden">

            <label for="title" class="block text-lg font-semibold text-gray-700 mb-2">Title:</label>
            <input type="text" name="title" id="title" class="w-full p-2 border border-gray-300 rounded-md">

            <label for="hero_content" class="block text-lg font-semibold text-gray-700 mb-2">Hero Content:</label>
            <textarea name="content" id="hero_content" rows="4" class="w-full p-2 border border-gray-300 rounded-md"></textarea>

            <label for="image_url" class="block text-lg font-semibold text-gray-700 mb-2">Image URL:</label>
            <input type="text" name="image_url" id="image_url" class="w-full p-2 border border-gray-300 rounded-md">

            <button type="submit" class="mt-4 p-3 bg-[#d4963a] text-white font-semibold rounded-lg hover:bg-[#b37d2a] transition">
                Save Changes
            </button>
        </form>
    </div>
</div>
<script>
    /**
     * Load hero details from backend when a slide is selected.
     */
    function loadHeroDetails(heroId) {
        if (!heroId) {
            document.getElementById("editHeroSection").classList.add("hidden");
            return;
        }

        fetch(`/public/admin/components/pages.php?hero_id=${heroId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showMessage(data.error, "red");
                    return;
                }

                // Populate form with hero data
                document.getElementById("hero_id_hidden").value = data.id || "";
                document.getElementById("title").value = data.title || "";
                document.getElementById("hero_content").value = data.content || "";
                document.getElementById("image_url").value = data.image_url || "";

                document.getElementById("editHeroSection").classList.remove("hidden");
            })
            .catch(error => {
                console.error("Error fetching hero data:", error);
                showMessage("Error fetching hero data.", "red");
            });
    }

    /**
     * Handle form submission via AJAX (update hero).
     */
    document.getElementById("heroForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        formData.append("action", "updateHero");

        fetch("/public/admin/models/heroModel.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                showMessage("Hero section updated successfully!", "green");
            } else {
                showMessage("Failed to update hero section: " + data.message, "red");
            }
        })
        .catch(error => {
            console.error("Error submitting form:", error);
            showMessage("An error occurred while updating.", "red");
        });
    });

    /**
     * Utility: Show success/error messages.
     */
    function showMessage(message, type) {
        let messageBox = document.getElementById("heroMessage");
        messageBox.textContent = message;
        messageBox.classList.remove("hidden");

        if (type === "green") {
            messageBox.classList.add("bg-green-100", "text-green-800");
            messageBox.classList.remove("bg-red-100", "text-red-800");
        } else {
            messageBox.classList.add("bg-red-100", "text-red-800");
            messageBox.classList.remove("bg-green-100", "text-green-800");
        }

        setTimeout(() => {
            messageBox.classList.add("hidden");
        }, 3000);
    }
</script>
