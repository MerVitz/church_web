<?php 
$pageTitle = "Who We Are"; 
include_once "includes/models.php"; 
$whoWeAre = getWhoWeAre();
?>

<!-- Main Content -->
<main class="flex-grow py-8 px-4 bg-white bg-[url('<?= htmlspecialchars($whoWeAre['image_url'] ?? 'public/images/default.jpg'); ?>')] bg-cover bg-center bg-no-repeat md:bg-none">
    <div class="container mx-auto text-left md:flex items-center bg-white/90 md:bg-transparent p-6 rounded-lg shadow-lg">
        <!-- Text Section -->
        <div class="md:w-1/2">
            <h2 class="text-4xl font-bold text-[#6C8BC9] mb-6">
                <?= htmlspecialchars($whoWeAre['title'] ?? 'Who We Are'); ?>
            </h2>
            <p class="text-lg text-black leading-relaxed mb-4">
                <?= nl2br(htmlspecialchars($whoWeAre['content'] ?? 'Content coming soon...')); ?>
            </p>
            <a href="?page=become-member" class="mt-4 inline-block bg-[#6C8BC9] text-white px-6 py-3 rounded-md shadow-lg hover:bg-[#D18C7C]">
                Get Involved
            </a>
        </div>

        <!-- Image Section (Large screens only) -->
        <div class="hidden md:block md:w-1/2 px-6">
            <img 
                src="<?= htmlspecialchars($whoWeAre['image_url'] ?? 'public/images/default.jpg'); ?>" 
                alt="Church Community" 
                class="rounded-lg shadow-lg w-full h-auto"
            >
        </div>
    </div>
</main>
