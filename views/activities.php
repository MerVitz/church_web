<?php
$pageTitle = "Activities";
include_once "includes/models.php";
$events = getUpcomingEvents();
$activities = getActivities();
?>

<!-- Main Content -->
<main class="flex-grow bg-white py-12 px-4 ">
    <h2 class="text-4xl font-bold text-[#660000] text-center mb-6">Activities</h2>
    <p class="text-lg text-gray-700 text-center max-w-2xl mx-auto mb-12">
        Stay updated on our recent and upcoming events as we continue to grow in faith and community service.
    </p>

    <!-- Upcoming Events Section -->
    <section class="mb-20">
        <h3 class="text-3xl font-semibold text-center text-[#660000] mb-8">Upcoming Events</h3>

        <!-- Event Posters Carousel -->
        <div class="relative overflow-hidden max-w-5xl mx-auto">
            <div id="event-carousel" class="flex transition-transform duration-500 ease-in-out space-x-8">
                
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <div class="relative w-full md:w-1/2 flex-shrink-0 event-item">
                            <img src="<?= $event['poster'] ?>" alt="<?= htmlspecialchars($event['name']) ?>" class="w-full h-64 object-cover rounded-lg shadow-lg event-img">
                            <div class="absolute inset-0 flex justify-center items-center p-4 rounded-lg event-overlay">
                                <div class="bg-[#c19999] bg-opacity-60 text-white px-6 py-4 rounded-md">
                                    <h3 class="text-2xl font-bold text-center"><?= htmlspecialchars($event['name']) ?></h3>
                                    <p class="text-sm mt-2 text-center">Date: <?= date("jS F Y", strtotime($event['date'])) ?></p>
                                    <p class="text-sm text-center">Venue: <?= htmlspecialchars($event['venue']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-600">No upcoming events at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Periodic Activities Section -->
    <section>
        <h3 class="text-3xl font-semibold text-center text-[#660000] mb-8">Periodic Activities</h3>

        <div class="container mx-auto space-y-16">
            <?php $reverse = false; ?>
            <?php foreach ($activities as $activity): ?>
                <div class="flex flex-col md:flex-row<?= $reverse ? '-reverse' : ''; ?> items-center">
                    <div class="md:w-1/2">
                        <img src="<?= $activity['image'] ?>" alt="<?= $activity['name'] ?>" class="w-full h-64 object-cover rounded-lg shadow-lg">
                    </div>
                    <div class="md:w-1/2 md:<?= $reverse ? 'pr' : 'pl'; ?>-12 text-left animate-fadeIn">
                        <h3 class="text-3xl font-semibold text-[#660000]"><?= $activity['name'] ?></h3>
                        <p class="text-gray-800 mt-4"><?= $activity['description'] ?></p>
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