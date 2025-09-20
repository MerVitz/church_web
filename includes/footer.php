<?php
include_once "models.php"; 

$contact = getContactInfo();
$giving = getGivingOfferings();
$socials = getSocialLinks();
?>

<!-- Footer -->
<footer class="relative bg-contain bg-cover bg-center text-black py-12" 
        style="background-image: url('public/images/footer.jpg');">
    
    <!-- Background Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#ffffff]"></div>

    <div class="relative container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            
            <!-- Contact Information -->
            <div class="text-left space-y-4">
                <h3 class="text-2xl font-semibold text-[#000000] mb-4">Contact Us</h3>

                <!-- Location -->
                <div class="flex items-center gap-3 group p-2 rounded-md hover:bg-[#6C8BC9]/10 transition duration-300 hover:scale-[1.03]">
                    <img src="public/icons/location.svg" alt="Location" class="w-6 h-6 group-hover:scale-110 group-hover:brightness-110" />
                    <span class="text-black group-hover:text-[#6C8BC9] transition-colors duration-300">
                        <?= htmlspecialchars($contact['location']) ?>
                    </span>
                </div>

                <!-- Phone -->
                <div class="flex items-center gap-3 group p-2 rounded-md hover:bg-[#6C8BC9]/10 transition duration-300 hover:scale-[1.03]">
                    <img src="public/icons/phone.svg" alt="Phone" class="w-6 h-6 group-hover:scale-110 group-hover:brightness-110" />
                    <span class="text-black group-hover:text-[#6C8BC9] transition-colors duration-300">
                        <?= htmlspecialchars($contact['phone']) ?>
                    </span>
                </div>

                <!-- Email -->
                <div class="flex items-center gap-3 group p-2 rounded-md hover:bg-[#6C8BC9]/10 transition duration-300 hover:scale-[1.03]">
                    <img src="public/icons/email.svg" alt="Email" class="w-6 h-6 group-hover:scale-110 group-hover:brightness-110" />
                    <span class="text-black group-hover:text-[#6C8BC9] transition-colors duration-300">
                        <?= htmlspecialchars($contact['email']) ?>
                    </span>
                </div>
            </div>


            <!-- Giving & Offerings -->
            <div id="giving" class="bg-white p-6 rounded-lg shadow-md border border-[#6C8BC9] text-center">
                <img src="public/images/donation.png" alt="Giving Icon" class="w-12 h-12 mx-auto mb-3">
                <h3 class="text-2xl font-bold text-[#6C8BC9] mb-2">Giving & Offerings</h3>
                <p class="text-xl font-semibold text-black">Paybill Number: <span class="text-[#6C8BC9] font-bold"><?= htmlspecialchars($giving['paybill']) ?></span></p>
                <p class="text-sm text-black mt-2">Account: <em>Write the purpose – e.g. offertory, thanksgiving, tithe</em></p>
                <p class="text-sm text-black mt-2">Assistance? Call: <strong class="text-black"><?= htmlspecialchars($giving['assistance_phone']) ?></strong></p>
            </div>

            <!-- Prayer Line Button -->
            <div class="flex justify-center items-center">
                <a href="/?page=prayer-line" 
                   class="px-6 py-3 bg-[#6C8BC9] text-white rounded-lg hover:bg-[#D18C7C] shadow-md transition flex items-center space-x-3">
                    <img src="public/images/pray.png" alt="Prayer Icon" class="w-8 h-8">
                    <span class="text-lg font-semibold">Prayer Line</span>
                </a>
            </div>

            <!-- Quick Links -->
            <div class="text-left">
                <h3 class="text-2xl font-semibold text-[#000000] mb-4">Quick Links</h3>
                <ul class="grid grid-cols-2 gap-3 text-sm sm:text-base">
                    <?php
                        $links = [
                            ['href' => '/?page=home', 'text' => 'Home'],
                            ['href' => '/?page=who-we-are', 'text' => 'Who We Are'],
                            ['href' => '/?page=history', 'text' => 'History'],
                            ['href' => '/?page=administration', 'text' => 'Administration'],
                            ['href' => '/?page=governance', 'text' => 'Governance'],
                            ['href' => '/?page=departments', 'text' => 'Departments'],
                            ['href' => '/?page=activities', 'text' => 'Activities'],
                            ['href' => '/?page=resources', 'text' => 'Resources'],
                            ['href' => '/?page=get-involved', 'text' => 'Get Involved'],
                            ['href' => '/?page=contact-us', 'text' => 'Contact Us'],
                            ['href' => '/?page=become-member', 'text' => 'Join Us'],
                            ['href' => '/?page=prayer-line', 'text' => 'Prayer Line'],
                        ];

                        foreach ($links as $link) {
                            echo '
                            <li>
                                <a href="' . $link['href'] . '" class="group flex items-center gap-2 p-1 rounded-md text-black hover:text-[#6C8BC9] hover:bg-[#6C8BC9]/10 transition duration-300 ease-in-out transform hover:scale-[1.03]">
                                    <img src="public/icons/bx-link.svg" alt="Link Icon" class="w-4 h-4 transition duration-300 ease-in-out group-hover:scale-110 group-hover:brightness-110" />
                                    <span class="transition-colors duration-300">' . $link['text'] . '</span>
                                </a>
                            </li>
                                    ';
                        }
                    ?>
                </ul>
            </div>
        </div>

    <!-- Social Media Links -->
    <div class="text-center mt-6">
        <h3 class="text-2xl font-semibold text-[#000000] mb-4">Follow Us</h3>
        <div class="flex justify-center space-x-4">
            <?php foreach ($socials as $social): ?>
                <a href="<?= htmlspecialchars($social['url']) ?>" target="_blank" 
                class="w-12 h-12 flex items-center justify-center bg-white rounded-full shadow transition transform hover:scale-110 hover:bg-[#6C8BC9]">
                    <img src="<?= htmlspecialchars($social['icon']) ?>" 
                        alt="<?= htmlspecialchars($social['platform']) ?>" 
                        class="w-6 h-6 object-contain transition-transform duration-300 ease-in-out hover:filter hover:brightness-0 hover:invert">
                </a>
            <?php endforeach; ?>
        </div>
    </div>



        <!-- Footer Bottom: Copyright & Developer -->
        <div class="border-t border-[#6C8BC9] pt-6 text-center md:flex md:justify-between md:items-center mt-6">
            <!-- Copyright -->
            <p class="text-xs md:text-sm text-black leading-tight">
                © 2025 ACK ALL SAINTS MASENO PARISH. All Rights Reserved.
            </p>

            <!-- Developed By -->
            <p class="text-xs md:text-sm text-black flex items-center justify-center md:justify-start space-x-2 mt-2 md:mt-0">
                <span>Developed by</span> 
                <img src="public/images/coding-icon.png" alt="Coding Icon" class="w-4 h-4 md:w-5 md:h-5 inline">
                <a href="https://github.com/amakaluvitalis" target="_blank" class="text-black hover:text-[#D18C7C]">Almic Solutions</a>
            </p>
        </div>
    </div>
</footer>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Handle Image Download
        document.querySelectorAll(".download-btn").forEach(button => {
            button.addEventListener("click", function () {
                const imageUrl = this.getAttribute("data-url");
                const fileName = imageUrl.split('/').pop();

                fetch(imageUrl)
                    .then(response => response.blob())
                    .then(blob => {
                        const link = document.createElement("a");
                        link.href = URL.createObjectURL(blob);
                        link.download = fileName;
                        link.click();
                    })
                    .catch(error => console.error("Download failed:", error));
            });
        });

        const toggleButton = document.getElementById("toggleButton");
        const closeButton = document.getElementById("closePanel");
        const floatingButton = document.getElementById("floatingButton");
        const notificationPanel = document.getElementById("notificationPanel");

        // Make sure the floating button appears
        if (floatingButton) {
            floatingButton.classList.remove("hidden");
        }

        // Toggle notifications panel
        if (toggleButton && notificationPanel) {
            toggleButton.addEventListener("click", function () {
                notificationPanel.style.right = "10px"; // Slide into view
            });
        }

        // Close panel
        if (closeButton && notificationPanel) {
            closeButton.addEventListener("click", function () {
                notificationPanel.style.right = "-320px"; // Hide panel
            });
        }
    });
</script>