<?php
$pageTitle = "Get Involved";
?>

<!-- Main Content -->
<main class="flex-grow bg-white py-16 px-4 text-center">
    
    <div class="max-w-4xl mx-auto">
        <h2 class="text-4xl text-[#6C8BC9] font-bold mb-4 uppercase tracking-wide">Get Involved</h2>
        <p class="text-lg text-black max-w-2xl mx-auto mb-14">
            Discover meaningful ways to participate and contribute to our church community. Whether through giving, serving, or praying, there's a place for everyone to make a difference.
        </p>
    </div>

    <!-- Involvement Options -->
    <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3 container mx-auto text-left">
        <!-- ITEM -->
        <div class="group bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl">
            <img src="public/images/members.png" alt="Become a Member" class="w-16 h-16 mb-6 mx-auto">
            <h3 class="text-2xl text-[#6C8BC9] mb-3 text-center">Become a Member</h3>
            <p class="text-black text-sm mb-4">
                Join our church family and be part of a loving, faith-filled community. Grow spiritually and connect with others in meaningful ways.
            </p>
            <a href="/?page=become-member" class="text-sm text-[#6C8BC9] hover:text-[#D18C7C] transition font-medium">Join Now →</a>
        </div>

        <!-- ITEM -->
        <div class="group bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl">
            <img src="public/images/giving-icon.png" alt="Giving" class="w-16 h-16 mb-6 mx-auto">
            <h3 class="text-2xl text-[#6C8BC9] mb-3 text-center">Support by Giving</h3>
            <p class="text-black text-sm mb-4">
                Your contributions support ministries, missions, and community outreach. Every gift counts and creates impact.
            </p>
            <a href="#giving" class="text-sm text-[#6C8BC9] hover:text-[#D18C7C] transition font-medium">Give Now →</a>
        </div>

        <!-- ITEM -->
        <div class="group bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl">
            <img src="public/images/mission-icon.png" alt="Go on Mission" class="w-16 h-16 mb-6 mx-auto">
            <h3 class="text-2xl text-[#6C8BC9] mb-3 text-center">Go on Mission</h3>
            <p class="text-black text-sm mb-4">
                Join mission trips and outreach programs to serve communities and share God’s love beyond the church walls.
            </p>
            <a href="/?page=become-member" class="text-sm text-[#6C8BC9] hover:text-[#D18C7C] transition font-medium">Join a Mission →</a>
        </div>

        <!-- ITEM -->
        <div class="group bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl">
            <img src="public/images/departments-icon.png" alt="Departments" class="w-16 h-16 mb-6 mx-auto">
            <h3 class="text-2xl text-[#6C8BC9] mb-3 text-center">Join Our Departments</h3>
            <p class="text-black text-sm mb-4">
                Use your skills and passions in ministry. There’s a place for everyone in our various departments.
            </p>
            <a href="/?page=departments" class="text-sm text-[#6C8BC9] hover:text-[#D18C7C] transition font-medium">Explore Departments →</a>
        </div>

        <!-- ITEM -->
        <div class="group bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl">
            <img src="public/images/prayer-icon.png" alt="Prayer" class="w-16 h-16 mb-6 mx-auto">
            <h3 class="text-2xl text-[#6C8BC9] mb-3 text-center">Pray for the Ministry</h3>
            <p class="text-black text-sm mb-4">
                Intercede for our church, leaders, and community. Your prayers bring strength, clarity, and growth.
            </p>
            <button onclick="openJoinModal('Prayer Team')" class="text-sm text-[#6C8BC9] hover:text-[#D18C7C] transition font-medium">Join Prayer Team →</button>
        </div>

        <!-- ITEM -->
        <div class="group bg-white rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl">
            <img src="public/images/events-icon.png" alt="Events" class="w-16 h-16 mb-6 mx-auto">
            <h3 class="text-2xl text-[#6C8BC9] mb-3 text-center">Attend Our Events</h3>
            <p class="text-black text-sm mb-4">
                Engage with others through worship, seminars, and fellowships designed to uplift and inspire.
            </p>
            <a href="/?page=activities" class="text-sm text-[#6C8BC9] hover:text-[#D18C7C] transition font-medium">View Events →</a>
        </div>
    </div>
</main>


    <!-- Join Prayer Team Modal -->
<div id="joinModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-[#ffffff] rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-xl font-bold text-[#6C8BC9]">Join Prayer Team</h3>
            <button onclick="closeJoinModal()" class="text-black hover:text-[#D18C7C]">×</button>
        </div>
        <form id="joinForm" class="space-y-4">
            <input type="hidden" name="ministry_application" value="1">
            
            <div>
                <label for="fullName" class="block text-black">Full Name</label>
                <input type="text" id="fullName" name="fullName"
                    class="mt-1 w-full p-2 border rounded-md focus:border-[#6C8BC9] focus:ring" required>
            </div>
            <div>
                <label for="emailJoin" class="block text-black">Email</label>
                <input type="email" id="emailJoin" name="emailJoin"
                    class="mt-1 w-full p-2 border rounded-md focus:border-[#6C8BC9] focus:ring" required>
            </div>
            <div>
                <label for="phoneJoin" class="block text-black">Phone</label>
                <input type="text" id="phoneJoin" name="phoneJoin"
                    class="mt-1 w-full p-2 border rounded-md focus:border-[#6C8BC9] focus:ring" required>
            </div>
            <div>
                <label for="ministryName" class="block text-black">Ministry</label>
                <input type="text" id="ministryName" name="ministryName"
                    class="mt-1 w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeJoinModal()" class="mr-2 px-4 py-2 border rounded hover:bg-[#6C8BC9] hover:text-white">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#D18C7C] text-white rounded hover:bg-[#6C8BC9]">Submit</button>
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