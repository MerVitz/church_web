<?php
$pageTitle = "Activities";
include_once "includes/models.php";
$events = getUpcomingEvents();
$activities = getActivities();
?>

<!-- Main Content -->
<main class="flex-grow bg-[#ffffff] py-8 px-4">
    <!-- Header Section -->
    <div class="mb-12 max-w-4xl mx-auto text-center md:text-left px-4">
        <h2 class="text-[28px] font-normal text-black tracking-wide mb-2 uppercase">
            Activities
        </h2>
        <p class="text-sm md:text-base text-gray-700 leading-relaxed">
            Stay updated on our <span class="text-[#D18C7C] font-medium">recent and upcoming events</span> as we continue growing in faith and community service.
        </p>
    </div>

    <!-- Upcoming Events Section -->
    <section class="mb-12">
        <h3 class="text-3xl font-semibold text-center text-[#6C8BC9] mb-8">Upcoming Events</h3>

        <!-- Event Posters Carousel -->
        <div class="relative overflow-hidden max-w-5xl mx-auto">
            <div id="event-carousel" class="flex transition-transform duration-500 ease-in-out space-x-8">
                
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <div class="relative w-full md:w-1/2 flex-shrink-0 event-item">
                            <img src="<?= $event['poster'] ?>" alt="<?= htmlspecialchars($event['name']) ?>" class="w-full h-64 object-cover rounded-lg shadow-lg event-img">
                            <div class="absolute inset-0 flex justify-center items-center p-4 rounded-lg event-overlay">
                                <div class="bg-[#6C8BC9]/60 text-white px-6 py-4 rounded-md hover:bg-[#D18C7C]/60 transition">
                                    <h3 class="text-2xl font-bold text-center"><?= htmlspecialchars($event['name']) ?></h3>
                                    <p class="text-sm mt-2 text-center">Date: <?= date("jS F Y", strtotime($event['date'])) ?></p>
                                    <p class="text-sm text-center">Venue: <?= htmlspecialchars($event['venue']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-black">No upcoming events at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Periodic Activities Section -->
    <section>
        <h3 class="text-xl md:text-2xl font-medium text-black mb-6">
            Periodic Activities
        </h3>

        <div class="space-y-20">
            <?php $reverse = false; ?>
            <?php foreach ($activities as $activity): ?>
            <div class="flex flex-col md:flex-row<?= $reverse ? '-reverse' : '' ?> items-center gap-6">
                <div class="md:w-1/2">
                    <img src="<?= $activity['image'] ?>" alt="<?= $activity['name'] ?>" class="rounded-lg shadow-lg h-64 w-full object-cover">
                </div>
                <div class="md:w-1/2 md:<?= $reverse ? 'pr' : 'pl' ?>-12">
                    <h4 class="text-lg font-medium text-[#6C8BC9]"><?= $activity['name'] ?></h4>
                    <p class="text-gray-700 mt-4 leading-relaxed"><?= $activity['description'] ?></p>
                </div>
            </div>
            <?php $reverse = !$reverse; ?>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<!-- Carousel Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carousel = document.getElementById("event-carousel");
        let scrollAmount = 0;
        const slideWidth = carousel.children[0].offsetWidth + 32; // Get width + margin
        let carouselInterval;

        function slideCarousel() {
            scrollAmount += slideWidth;
            if (scrollAmount >= carousel.scrollWidth - carousel.offsetWidth) {
                carousel.appendChild(carousel.firstElementChild);
                scrollAmount = 0;
            }
            carousel.style.transform = `translateX(-${scrollAmount}px)`;
        }

        function startCarousel() {
            carouselInterval = setInterval(slideCarousel, 4000);
        }

        function stopCarousel() {
            clearInterval(carouselInterval);
        }

        const eventItems = document.querySelectorAll('.event-item');
        eventItems.forEach(item => {
            item.addEventListener('mouseenter', stopCarousel);
            item.addEventListener('mouseleave', startCarousel);
        });

        startCarousel();
    });
</script>