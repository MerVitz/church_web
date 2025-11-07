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
    header("Location: ?page=admin-login");
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
<div class="h-full w-full flex flex-col p-8 space-y-10 overflow-y-auto text-gray-700">
    <!-- Tab Navigation -->
    <div class="flex gap-2 border-b border-gray-200">
        <button class="tab-btn active" data-tab="heroTab">Hero Slider</button>
        <button class="tab-btn" data-tab="noticeTab">Notice Board</button>
        <button class="tab-btn" data-tab="activitiesTab">Activities</button>
        <button class="tab-btn" data-tab="sermonsTab">Sermons</button>
    </div>

    <!-- HERO TAB -->
    <div id="heroTab" class="tab-content block space-y-6">

        <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
            <h2 class="text-lg font-medium mb-4">Edit Hero Slider</h2>

            <div class="space-y-4">

            <!-- Slide Select -->
            <div>
                <label for="hero_id" class="text-sm font-medium">Select Slide</label>
                <select name="hero_id" id="hero_id"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm"
                        onchange="loadHeroDetails(this.value)">
                    <option value="" selected>Select a slide to modify</option>
                    <?php foreach ($heroSections as $index => $hero): ?>
                        <option value="<?= htmlspecialchars($hero['id']) ?>">
                            Slide <?= $index + 1 ?> — <?= htmlspecialchars($hero['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

                <!-- Edit Section -->
                <div id="editHeroSection" class="hidden space-y-4">

                    <div id="heroMessage" class="hidden p-3 text-center text-sm rounded-md"></div>

                    <form method="POST" id="heroForm" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="id" id="hero_id_hidden">

                        <!-- Two Column Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <!-- Text Inputs -->
                            <div class="space-y-4 md:col-span-2">
                                <div>
                                    <label class="text-sm font-medium">Title</label>
                                    <input type="text" name="title" id="title"
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm">
                                </div>

                                <div>
                                    <label class="text-sm font-medium">Hero Content</label>
                                    <textarea name="content" id="hero_content" rows="5"
                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm"></textarea>
                                </div>

                                <div>
                                    <label class="text-sm font-medium">Upload New Image</label>
                                    <input type="file" id="heroImageInput" accept="image/*"
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm">
                                </div>

                                <input type="hidden" name="image_url" id="image_url">
                            </div>

                            <!-- Image Preview -->
                            <div>
                                <label class="text-sm font-medium">Current Preview</label>

                                <div class="mt-1 w-full h-48 border border-gray-300 bg-gray-50 rounded-md overflow-hidden">
                                    <img id="heroPreview" src="" class="w-full h-full object-cover hidden">
                                    <span id="heroNoImage" class="flex items-center justify-center h-full text-gray-400 text-xs">
                                        No image selected
                                    </span>
                                </div>

                                <p id="heroImageName" class="text-xs text-gray-600 mt-2 text-center"></p>
                            </div>

                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-2 bg-[#d4963a] text-white text-sm font-medium rounded-md hover:bg-[#b37d2a] transition">
                                Save Changes
                            </button>

                            <button type="button" id="cancelHeroEdit"
                                class="px-6 py-2 border border-gray-400 text-sm font-medium rounded-md hover:bg-gray-100 transition">
                                Cancel
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <div id="noticeTab" class="tab-content hidden"></div>
    <div id="activitiesTab" class="tab-content hidden"></div>
    <div id="sermonsTab" class="tab-content hidden"></div>

</div>


<script>
    var originalHeroData = null;

    document.addEventListener("DOMContentLoaded", () => {
        // Ensure form hidden on first load and the select starts at placeholder
        const select = document.getElementById("hero_id");
        const editSection = document.getElementById("editHeroSection");

        if (select) {
            // reset to placeholder
            select.value = "";
        }
        if (editSection) {
            editSection.classList.add("hidden");
        }
    });

    // Load slide data
    function loadHeroDetails(heroId) {
        console.log("📡 Loading hero slide:", heroId);
        if (!heroId) return;

        fetch(`/public/admin/components/pages.php?hero_id=${heroId}`)
            .then(response => response.json())
            .then(data => {
                console.log("?Data loaded:", data);

                originalHeroData = structuredClone(data);

                document.getElementById("hero_id_hidden").value = data.id ?? "";
                document.getElementById("title").value = data.title ?? "";
                document.getElementById("hero_content").value = data.content ?? "";
                document.getElementById("image_url").value = data.image_url ?? "";

                const preview = document.getElementById("heroPreview");
                const placeholder = document.getElementById("heroNoImage");
                const filenameLabel = document.getElementById("heroImageName");

                if (data.image_url) {
                    preview.src = data.image_url;
                    preview.classList.remove("hidden");
                    placeholder.classList.add("hidden");
                    filenameLabel.textContent = data.image_url;
                } else {
                    preview.classList.add("hidden");
                    placeholder.classList.remove("hidden");
                    filenameLabel.textContent = "";
                }

                document.getElementById("editHeroSection").classList.remove("hidden");
            })
            .catch(error => console.log("?Fetch error:", error));
    }


    // TAB SWITCHING
    document.querySelectorAll(".tab-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            document.querySelectorAll(".tab-content").forEach(c => c.classList.add("hidden"));
            document.getElementById(btn.dataset.tab).classList.remove("hidden");
        });
    });



    // Live image preview when selecting a new file
    document.getElementById("heroImageInput").addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById("heroPreview");
            preview.src = e.target.result;
            preview.classList.remove("hidden");

            document.getElementById("heroNoImage").classList.add("hidden");
            document.getElementById("heroImageName").textContent = file.name;
        };
        reader.readAsDataURL(file);
    });

    // Save changes
    document.getElementById("heroForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        formData.append("action", "updateHero");

        const file = document.getElementById("heroImageInput").files[0];
        if (file) formData.append("new_image", file);

        fetch("/public/admin/models/heroModel.php", { method: "POST", body: formData })
            .then(response => response.json())
            .then(data => showMessage(data.message, data.status === "success" ? "green" : "red"));
    });

    // Cancel edits
    document.getElementById("cancelHeroEdit").addEventListener("click", () => {
        if (!originalHeroData) return;

        document.getElementById("title").value = originalHeroData.title ?? "";
        document.getElementById("hero_content").value = originalHeroData.content ?? "";
        document.getElementById("image_url").value = originalHeroData.image_url ?? "";

        if (originalHeroData.image_url) {
            document.getElementById("heroPreview").src = originalHeroData.image_url;
            document.getElementById("heroPreview").classList.remove("hidden");
            document.getElementById("heroNoImage").classList.add("hidden");
            document.getElementById("heroImageName").textContent = originalHeroData.image_url;
        }

        document.getElementById("heroImageInput").value = "";
    });

    // Message UI
    function showMessage(message, type) {
        const box = document.getElementById("heroMessage");
        box.textContent = message;
        box.classList.remove("hidden");
        box.classList.toggle("bg-green-100", type === "green");
        box.classList.toggle("text-green-800", type === "green");
        box.classList.toggle("bg-red-100", type === "red");
        box.classList.toggle("text-red-800", type === "red");
        setTimeout(() => box.classList.add("hidden"), 3000);
    }
</script>

