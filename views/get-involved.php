<?php
$pageTitle = "Get Involved";
?>

<!-- Main Content -->
<main class="flex-grow bg-[#d1b3b3] z-0 py-12 px-4 text-center  relative">
    <div class="absolute inset-0 bg-[#efe5e5] opacity-40"></div>
    <div class="relative z-1 max-w-4xl mx-auto text-white">
        <h2 class="text-4xl font-bold mb-6">Get Involved</h2>
        <p class="text-lg mb-12 max-w-2xl mx-auto">
            Discover meaningful ways to participate and contribute to our church community. Whether through giving, serving, or praying, there's a place for everyone to make a difference.
        </p>
    </div>

    <div class="relative z-10 container mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-10 text-left">
        
        <!-- Become a Member -->
        <div class="p-8 bg-[#efe5e5] bg-opacity-90 rounded-lg shadow-lg">
            <img src="public/images/members.png" alt="Become a Member" class="w-16 h-16 mb-4 mx-auto">
            <h3 class="text-2xl font-semibold text-[#660000]">Become a Member</h3>
            <p class="text-gray-700 mt-4">
                Join our church family and be part of a loving, faith-filled community. As a member, you will grow spiritually, connect with others, and actively participate in the life of our church.
            </p>
            <a href="/?page=become-member" class="mt-4 inline-block text-[#660000] font-bold">Join Now →</a>
        </div>

        <!-- Support by Giving -->
        <div class="p-8 bg-[#efe5e5] bg-opacity-90 rounded-lg shadow-lg">
            <img src="public/images/giving-icon.png" alt="Giving" class="w-20 h-20 mb-4 mx-auto">
            <h3 class="text-2xl font-semibold text-[#660000]">Support by Giving</h3>
            <p class="text-gray-700 mt-4">
                Your generous contributions help sustain our ministries, support the needy, and expand our outreach efforts. Every gift, no matter the size, makes an impact.
            </p>
            <a href="#giving" class="mt-4 inline-block text-[#660000] font-bold">Give Now →</a>
        </div>

        <!-- Go on Mission -->
        <div class="p-8 bg-[#efe5e5] bg-opacity-90 rounded-lg shadow-lg">
            <img src="public/images/mission-icon.png" alt="Mission" class="w-16 h-16 mb-4 mx-auto">
            <h3 class="text-2xl font-semibold text-[#660000]">Go on Mission</h3>
            <p class="text-gray-700 mt-4">
                Join us in reaching communities locally and globally, spreading the love of Christ through mission trips, evangelism, and community service projects.
            </p>
            <a href="/?page=become-member" class="mt-4 inline-block text-[#660000] font-bold">Join a Mission →</a>
        </div>

        <!-- Join Our Ministries -->
        <div class="p-8 bg-[#efe5e5] bg-opacity-90 rounded-lg shadow-lg">
            <img src="public/images/ministries-icon.png" alt="Ministries" class="w-16 h-16 mb-4 mx-auto">
            <h3 class="text-2xl font-semibold text-[#660000]">Join Our Ministries</h3>
            <p class="text-gray-700 mt-4">
                Whether it's the worship team, youth ministry, or outreach programs, there's a place for you to serve using your unique gifts and talents.
            </p>
            <a href="/?page=ministries" class="mt-4 inline-block text-[#660000] font-bold">Explore Ministries →</a>
        </div>

        <!-- Pray for the Ministry -->
        <div class="p-8 bg-[#efe5e5] bg-opacity-90 rounded-lg shadow-lg">
            <img src="public/images/prayer-icon.png" alt="Prayer" class="w-16 h-16 mb-4 mx-auto">
            <h3 class="text-2xl font-semibold text-[#660000]">Pray for the Ministry</h3>
            <p class="text-gray-700 mt-4">
                We believe in the power of prayer. Join us in lifting our leaders, missionaries, and community in prayer as we seek God's guidance and blessings.
            </p>
            <button onclick="openJoinModal('Prayer Team')" class="mt-4 inline-block text-[#660000] font-bold">Join Prayer Team →</button>
            </div>

        <!-- Attend Our Events -->
        <div class="p-8 bg-[#efe5e5] bg-opacity-90 rounded-lg shadow-lg">
            <img src="public/images/events-icon.png" alt="Events" class="w-16 h-16 mb-4 mx-auto">
            <h3 class="text-2xl font-semibold text-[#660000]">Attend Our Events</h3>
            <p class="text-gray-700 mt-4">
                Stay connected by attending our church events, worship services, and special programs. There's always something for everyone to enjoy and grow in faith.
            </p>
            <a href="/?page=activities" class="mt-4 inline-block text-[#660000] font-bold">View Events →</a>
        </div>
    </div>
    <div id="message-wrapper" class="fixed inset-0 z-[100000] pointer-events-none flex items-start justify-center">
        <div id="response-message" class="mt-5">
    </div>
</div>
</main>

<!-- Join Prayer Team Modal -->
<div id="joinModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-xl font-bold text-[#660000]">Join Prayer Team</h3>
            <button onclick="closeJoinModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <form id="joinForm" class="space-y-4">
            <input type="hidden" name="ministry_application" value="1">
            
            <div>
                <label for="fullName" class="block text-gray-700">Full Name</label>
                <input type="text" id="fullName" name="fullName"
                    class="mt-1 w-full p-2 border rounded-md focus:border-[#660000] focus:ring" required>
            </div>
            <div>
                <label for="emailJoin" class="block text-gray-700">Email</label>
                <input type="email" id="emailJoin" name="emailJoin"
                    class="mt-1 w-full p-2 border rounded-md focus:border-[#660000] focus:ring" required>
            </div>
            <div>
                <label for="phoneJoin" class="block text-gray-700">Phone</label>
                <input type="text" id="phoneJoin" name="phoneJoin"
                    class="mt-1 w-full p-2 border rounded-md focus:border-[#660000] focus:ring" required>
            </div>
            <div>
                <label for="ministryName" class="block text-gray-700">Ministry</label>
                <input type="text" id="ministryName" name="ministryName"
                    class="mt-1 w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeJoinModal()" class="mr-2 px-4 py-2 border rounded hover:bg-gray-200">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#660000] text-white rounded hover:bg-[#550000]">Submit</button>
            </div>
        </form>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("#joinForm").submit(function(event) {
            event.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "includes/models.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    let messageHtml = `
                        <div class="bg-${response.status === 'success' ? 'green' : 'red'}-100 border border-${response.status === 'success' ? 'green' : 'red'}-400 text-${response.status === 'success' ? 'green' : 'red'}-700 px-4 py-3 rounded shadow-lg">
                            <strong class="font-bold">${response.status === 'success' ? 'Success!' : 'Error!'}</strong>
                            <span class="block sm:inline">${response.message}</span>
                        </div>
                    `;

                    $("#response-message").html(messageHtml).fadeIn();

                    if (response.status === "success") {
                        $("#joinForm")[0].reset();
                        setTimeout(closeJoinModal, 500);
                    }

                    // Auto-hide message after 5 seconds
                    setTimeout(function() {
                        $("#response-message").fadeOut("slow");
                    }, 5000);
                },
                error: function() {
                    $("#response-message").html(
                        `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">Something went wrong. Please try again.</span>
                        </div>`
                    ).fadeIn();

                    // Auto-hide error message after 5 seconds
                    setTimeout(function() {
                        $("#response-message").fadeOut("slow");
                    }, 5000);
                }
            });
        });
    });

    function openJoinModal(ministryName) {
        document.getElementById("modalTitle").innerText = `Join ${ministryName}`;
        document.getElementById("ministryName").value = ministryName;
        document.getElementById("joinModal").classList.remove("hidden");
    }

    function closeJoinModal() {
        document.getElementById("joinModal").classList.add("hidden");
    }
</script>