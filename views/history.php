<?php
$pageTitle = "History of ACK";
include_once "includes/models.php";
$history = getHistory();
?>

<!-- Main Content -->
<main class="flex-grow bg-white py-12 px-4 ">
    <h2 class="text-4xl font-bold text-[#660000] text-center mb-6">History of the Anglican Church of Kenya</h2>
    <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto mb-12">
        Explore the journey of our church through the years, from humble beginnings to a thriving community of faith and service.
    </p>

    <div class="container mx-auto overflow-x-auto scroll-smooth">
        <div class="relative space-y-12 max-w-4xl mx-auto">
            <?php foreach ($history as $row): ?>
                <div class="flex flex-col md:flex-row <?php echo ($row['alignment'] == 'right') ? 'md:flex-row-reverse' : ''; ?> items-center md:items-start">
                    <div class="md:w-1/2 <?php echo ($row['alignment'] == 'left') ? 'text-right md:pr-10' : 'text-left md:pl-10'; ?> animate-fadeIn">
                        <h3 class="text-2xl font-semibold text-[#660000]"><?= htmlspecialchars($row['year']); ?> - <?= htmlspecialchars($row['title']); ?></h3>
                        <p class="text-gray-800 mt-2"><?= htmlspecialchars($row['description']); ?></p>
                    </div>
                    <div class="w-24 h-24 bg-gray-200 rounded-full overflow-hidden border-4 border-[#660000] shadow-lg">
                        <img src="<?= htmlspecialchars($row['image_path']); ?>" alt="<?= htmlspecialchars($row['title']); ?>" class="w-full h-full object-cover">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>