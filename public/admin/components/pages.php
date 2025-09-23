<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: /?page=admin-login");
    exit();
}

include_once __DIR__ . "/../models/heroModel.php";

$heroSections = getHeroSections($conn);

if (isset($_GET['hero_id'])) {
    $heroData = getHeroById($conn, $_GET['hero_id']);
    echo json_encode($heroData ?: ["error" => "Hero section not found"]);
    exit();
}
?>

<div class="w-full px-4 py-12">

    <!-- Page Heading -->
    <h1 class="text-xs sm:text-sm font-light text-gray-500 mb-10 tracking-wide uppercase text-right">
        Edit Homepage Hero Section
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Left: Slide Selector + Preview -->
        <div class="space-y-6">

            <!-- Hero Slide Selector -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <label for="hero_id" class="block text-xs font-medium text-gray-500 mb-2 tracking-wide uppercase">
                    Select Hero Slide
                </label>
                <select name="hero_id" id="hero_id"
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#d4963a] focus:outline-none transition"
                    onchange="loadHeroDetails(this.value)">
                    <option value="">-- Choose a Slide --</option>
                    <?php foreach ($heroSections as $index => $hero): ?>
                        <option value="<?= htmlspecialchars($hero['id']) ?>">Slide <?= $index + 1 ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Image Preview -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs font-medium text-gray-500 tracking-wide uppercase mb-3">
                    Preview
                </p>
                <img id="heroImagePreview" src="" alt="Image Preview"
                    class="hidden w-full max-h-64 object-cover rounded-md border border-gray-200">
            </div>

        </div>

        <!-- Right: Hero Form -->
        <div class="lg:col-span-2">
            <div id="editHeroSection" class="hidden">
                <!-- Feedback / Message -->
                <div id="heroMessage"
                     class="hidden p-3 text-center text-sm font-medium rounded-md mb-6"></div>

                <form method="POST" id="heroForm"
                      class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 space-y-6">
                    <input type="hidden" name="id" id="hero_id_hidden">

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-xs font-medium text-gray-500 mb-2 tracking-wide uppercase">
                            Title
                        </label>
                        <input type="text" name="title" id="title"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#d4963a] focus:outline-none transition">
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="hero_content" class="block text-xs font-medium text-gray-500 mb-2 tracking-wide uppercase">
                            Hero Content
                        </label>
                        <textarea name="content" id="hero_content" rows="4"
                                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#d4963a] focus:outline-none transition"></textarea>
                    </div>

                    <!-- Image Filename -->
                    <div>
                        <label for="image_filename" class="block text-xs font-medium text-gray-500 mb-2 tracking-wide uppercase">
                            Image Filename
                        </label>
                        <input type="text" name="image_filename" id="image_filename"
                               placeholder="example.jpg"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#d4963a] focus:outline-none transition">
                        <p class="mt-1 text-[11px] text-gray-400">
                            Only provide the filename (e.g. <code>banner1.jpg</code>). Images are stored in <code>/uploads/heroes/</code>.
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-6 py-2 bg-[#d4963a] text-white text-sm font-medium rounded-lg hover:bg-[#b37d2a] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#d4963a] transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




    <script>
        const storagePath = "/uploads/heroes/";
        const imageInput = document.getElementById("image_filename");
        const preview = document.getElementById("heroImagePreview");

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

                    // Fill fields
                    document.getElementById("hero_id_hidden").value = data.id || "";
                    document.getElementById("title").value = data.title || "";
                    document.getElementById("hero_content").value = data.content || "";

                    // Extract filename from full path (if provided)
                    let filename = "";
                    if (data.image_url) {
                        filename = data.image_url.split("/").pop(); // take last part only
                    }

                    imageInput.value = filename;

                    // Update preview
                    if (filename) {
                        preview.src = storagePath + filename;
                        preview.classList.remove("hidden");
                    } else {
                        preview.classList.add("hidden");
                        preview.src = "";
                    }

                    document.getElementById("editHeroSection").classList.remove("hidden");
                })
                .catch(error => {
                    console.error("Error fetching hero data:", error);
                    showMessage("Error fetching hero data.", "red");
                });
        }

        // Live preview on input
        imageInput.addEventListener("input", function() {
            const filename = this.value.trim();
            if (filename) {
                preview.src = storagePath + filename;
                preview.classList.remove("hidden");
            } else {
                preview.classList.add("hidden");
                preview.src = "";
            }
        });

        // Submit handler
        document.getElementById("heroForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent page reload

            let formData = new FormData(this);
            formData.append("action", "updateHero"); // Ensure the action is included

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
