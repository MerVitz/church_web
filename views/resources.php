<?php 
$pageTitle = "Resources"; 
include_once "includes/models.php"; 
$sermons = getLatestSermons();
$audio_sermons = getLatestAudioSermons();
$galleries = getGallery();

?>

<!-- Main Content -->
<main class="flex-grow bg-[#ffffff] py-8 px-4 text-center relative bg-cover bg-center bg-fixed" style="background-image: url('public/images/resources.jpg');">
    <!-- Translucent Overlay -->
    <div class="absolute inset-0 bg-[#ffffff] bg-opacity-60"></div>

    <!-- Content Wrapper -->
    <div class="relative">
        <!-- YouTube Video Previews (Carousel style) -->
        <div class="mb-12">
            <h3 class="text-2xl font-semibold text-[#6C8BC9] mb-4">Watch Our Latest Sermons</h3>

            <!-- Carousel Container -->
            <div id="videoCarouselWrapper" class="relative overflow-hidden w-full">
                <!-- Left Navigation Button (Initially Hidden) -->
                <button id="prevBtn" class="hidden absolute left-2 top-1/2 transform -translate-y-1/2 z-10 bg-[#6C8BC9] bg-opacity-70 text-white p-2 rounded-full hover:bg-opacity-90">
                    <img src="/public/images/bx-skip-previous-circle.svg" alt="Previous" class="w-10 h-10">
                </button>

                <!-- Right Navigation Button (Initially Hidden) -->
                <button id="nextBtn" class="hidden absolute right-2 top-1/2 transform -translate-y-1/2 z-10 bg-[#6C8BC9] bg-opacity-70 text-white p-2 rounded-full hover:bg-opacity-90">
                    <img src="/public/images/bx-skip-next-circle.svg" alt="Next" class="w-10 h-10">
                </button>

                <div id="videoCarousel" class="flex transition-transform duration-700 ease-in-out">
                    <?php foreach ($sermons as $sermon): ?>
                        <div class="video-item flex-shrink-0 w-full md:w-1/2 px-2">
                            <div class="bg-[#ffffff] shadow-lg rounded-lg p-4 text-left">
                                <!-- Title -->
                                <h4 class="text-lg md:text-xl font-bold text-[#6C8BC9] mb-2">
                                    <?= htmlspecialchars($sermon['title']); ?>
                                </h4>
                                <!-- Date & Speaker Row -->
                                <div class="flex justify-between items-center text-black text-sm font-medium mb-2">
                                    <!-- Date (Left) -->
                                    <div class="flex items-center">
                                        <img src="/public/images/bx-calendar.svg" alt="Calendar" class="w-5 h-5 mr-2">
                                        <span><?= date("F d, Y", strtotime($sermon['date'])); ?></span>
                                    </div>
                                    <!-- Speaker (Right) -->
                                    <div class="flex items-center">
                                        <span><?= htmlspecialchars($sermon['speaker']); ?></span>
                                        <img src="/public/images/speaker.png" alt="Speaker" class="w-6 h-6 ml-2">
                                    </div>
                                </div>
                                <!-- YouTube Video -->
                                <iframe class="video-frame w-full h-[270px] md:h-[330px] rounded-md mt-2"
                                    src="<?= htmlspecialchars($sermon['youtube_link']); ?>?rel=0&showinfo=0&modestbranding=1&enablejsapi=1"
                                    frameborder="0" allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Audio Sermons Section -->
        <div class="mb-12">
            <h3 class="text-center text-2xl font-semibold text-[#6C8BC9] mb-4">Listen to Our Latest Sermons</h3>

            <div class="max-w-xl mx-auto overflow-y-auto max-h-96 border border-[#6C8BC9] rounded-lg shadow-lg">
                <table class="min-w-full border-collapse">
                    <thead class="bg-[#6C8BC9] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Sermon Title</th>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Audio</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#ffffff] text-black">
                        <?php foreach ($audio_sermons as $sermon): ?>
                            <tr class="border-b border-[#6C8BC9]/20">
                                <td class="py-3 px-4"><?php echo htmlspecialchars($sermon['title']); ?></td>
                                <td class="py-3 px-4"><?php echo date("M d, Y", strtotime($sermon['date'])); ?></td>
                                <td class="py-3 px-4">
                                    <audio controls class="w-40">
                                        <source src="<?php echo htmlspecialchars($sermon['audio_file']); ?>" type="audio/mpeg">
                                    </audio>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Gallery Section -->
        <section class="py-8 bg-[#ffffff] text-center">
            <div class="container mx-auto px-6 md:px-12">
                <h3 class="text-4xl font-bold text-[#6C8BC9] mb-6">Church Gallery</h3>

                <?php foreach ($galleries as $gallery) : ?>
                    <div class="mb-10">
                        <h4 class="text-2xl font-semibold text-[#6C8BC9] mb-4"><?= htmlspecialchars($gallery['category_name']) ?></h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Lightbox-enabled images -->
                            <div class="relative group">
                                <a href="<?= htmlspecialchars($gallery['image1']) ?>" data-lightbox="gallery-<?= $gallery['id']; ?>">
                                    <img src="<?= htmlspecialchars($gallery['image1']) ?>" class="w-full h-auto object-cover rounded-lg shadow-lg">
                                </a>
                                <button class="download-btn absolute bottom-2 right-2 p-2 bg-[#6C8BC9] rounded-md text-white hover:bg-[#D18C7C]" 
                                        data-url="<?= htmlspecialchars($gallery['image1']) ?>">
                                    <img src="public/images/bx-download.svg" class="w-5 h-5" alt="Download">
                                </button>
                            </div>

                            <div class="relative group">
                                <a href="<?= htmlspecialchars($gallery['image2']) ?>" data-lightbox="gallery-<?= $gallery['id']; ?>">
                                    <img src="<?= htmlspecialchars($gallery['image2']) ?>" class="w-full h-auto object-cover rounded-lg shadow-lg">
                                </a>
                                <button class="download-btn absolute bottom-2 right-2 p-2 bg-[#6C8BC9] rounded-md text-white hover:bg-[#D18C7C]" 
                                        data-url="<?= htmlspecialchars($gallery['image2']) ?>">
                                    <img src="public/images/bx-download.svg" class="w-5 h-5" alt="Download">
                                </button>
                            </div>

                            <div class="relative group">
                                <a href="<?= htmlspecialchars($gallery['image3']) ?>" data-lightbox="gallery-<?= $gallery['id']; ?>">
                                    <img src="<?= htmlspecialchars($gallery['image3']) ?>" class="w-full h-auto object-cover rounded-lg shadow-lg">
                                </a>
                                <button class="download-btn absolute bottom-2 right-2 p-2 bg-[#6C8BC9] rounded-md text-white hover:bg-[#D18C7C]" 
                                        data-url="<?= htmlspecialchars($gallery['image3']) ?>">
                                    <img src="public/images/bx-download.svg" class="w-5 h-5" alt="Download">
                                </button>
                            </div>
                        </div>

                        <!-- More Photos Button -->
                        <a href="<?= htmlspecialchars($gallery['drive_link']) ?>" target="_blank" 
                           class="mt-4 inline-block bg-[#6C8BC9] text-white py-2 px-6 rounded-md shadow-lg hover:bg-[#D18C7C] transition">
                            View More Photos
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousel = document.getElementById("videoCarousel");
        const videoItems = document.querySelectorAll(".video-item");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const videoFrames = document.querySelectorAll(".video-frame");

        let index = 0;
        let autoScrollInterval;
        let autoScrollActive = true; // Track if auto-scroll is active

        function updateCarousel() {
            carousel.style.transition = "transform 700ms ease-in-out";
            carousel.style.transform = `translateX(-${index * videoItems[0].offsetWidth}px)`;
        }

        function startAutoScroll() {
            autoScrollInterval = setInterval(() => {
                if (!autoScrollActive) return; // If stopped, don't auto-scroll
                index++;
                updateCarousel();
                if (index >= videoItems.length - 1) {
                    setTimeout(() => {
                        carousel.style.transition = "none";
                        carousel.style.transform = "translateX(0px)";
                        index = 0;
                    }, 700);
                }
            }, 5000);
        }
        startAutoScroll();

        function stopAutoScrollAndShowButtons() {
            clearInterval(autoScrollInterval);
            autoScrollActive = false; // Stop the auto-scroll
            prevBtn.classList.remove("hidden");
            nextBtn.classList.remove("hidden");
        }

        // Stop scrolling when a user clicks any part of the sermon card
        videoItems.forEach((item) => {
            item.addEventListener("click", stopAutoScrollAndShowButtons);
        });

        prevBtn.addEventListener("click", () => {
            stopAutoScrollAndShowButtons();
            index = Math.max(index - 1, 0);
            updateCarousel();
        });

        nextBtn.addEventListener("click", () => {
            stopAutoScrollAndShowButtons();
            index = Math.min(index + 1, videoItems.length - 1);
            updateCarousel();
        });
    });

</script>