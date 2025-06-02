<?php
$pageTitle = "Administration";
include_once "includes/models.php";
$leaders = getAdministrationLeaders(); 
?>

<!-- Administration Section -->
<main class="flex-grow bg-white py-12 px-4 text-center ">
    <h2 class="text-4xl font-bold text-[#660000] text-center mb-6">Administration</h2>
    <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto mb-12">
        Meet our dedicated leaders who guide and manage the Anglican Church of Kenya. 
        Together, they ensure the spiritual, administrative, and operational success of our church.
    </p>

    <!-- Senior Leaders Section -->
    <section class="mb-12">
        <h3 class="text-3xl font-semibold text-center text-[#a36666] mb-6">Senior Leaders</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 px-6 md:px-16 lg:px-24">
            <?php foreach ($leaders as $leader) : ?>
                <div class="bg-gradient-to-t from-[#e6dcdc] to-[#f9f4f4] shadow-lg rounded-tl-none rounded-tr-3xl rounded-br-none rounded-bl-3xl p-6 text-center">
                    <div class="overflow-hidden mx-auto w-36 h-36 mb-4 border-4 border-[#660000] rounded-full">
                        <img src="<?= $leader['image'] ?>" alt="<?= $leader['name'] ?>" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-lg font-bold text-[#660000]"><?= $leader['name'] ?></h4>
                    <p class="text-sm text-gray-700"><?= $leader['position'] ?></p>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed"><?= $leader['description'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>