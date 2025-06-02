<?php 
$pageTitle = "Who We Are"; 
include_once "includes/models.php"; 
// Fetch Who We Are data
$whoWeAre = getWhoWeAre();
?>

<!-- Main Content -->
<main class="flex-grow bg-white py-12 px-4  relative">
    <!-- Background Image with Gradient Overlay (Hidden on Large Screens) -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#d1b2b2]/90 to-transparent md:hidden">
        <img 
            src="<?= htmlspecialchars($whoWeAre['image_url'] ?? 'public/images/default.jpg'); ?>" 
            alt="Church Community" 
            class="w-full h-full object-cover opacity-20"
        >
    </div>

    <!-- Content Section -->
    <div class="relative container mx-auto text-left md:flex items-center">
        <!-- Text Section -->
        <div class="md:w-1/2 px-6">
            <h2 class="text-4xl font-bold text-[#660000] mb-6">
                <?= htmlspecialchars($whoWeAre['title'] ?? 'Who We Are'); ?>
            </h2>
            <p class="text-lg text-gray-800 leading-relaxed mb-4">
                <?= nl2br(htmlspecialchars($whoWeAre['content'] ?? 'Content coming soon...')); ?>
            </p>
            <a href="/?page=become-member" class="mt-4 inline-block bg-[#660000] text-white px-6 py-3 rounded-md shadow-lg hover:bg-[#3d0000]">
                Get Involved
            </a>
        </div>

        <!-- Image Section (Visible on Large Screens) -->
        <div class="hidden md:block md:w-1/2 px-6">
            <img 
                src="<?= htmlspecialchars($whoWeAre['image_url'] ?? 'public/images/default.jpg'); ?>" 
                alt="Church Community" 
                class="rounded-lg shadow-lg w-full h-auto"
            >
        </div>
    </div>
</main>