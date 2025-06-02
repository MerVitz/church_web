<?php
$pageTitle = "Become a Member";
include_once "includes/models.php";
$welcome = getWelcomeMessage();
?>

<!-- Main Content -->
<main class="flex-grow bg-white py-12 px-4 text-center ">

    <!-- Welcome Message Section -->
    <section class="py-16">
        <div class="container mx-auto px-6 md:px-12">
            <div class="max-w-4xl mx-auto bg-white rounded-lg p-8 shadow-lg">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">

                    <!-- Vicar's Image (Left Side) -->
                    <div class="flex-shrink-0">
                        <img src="<?= $welcome['image'] ?>" alt="<?= $welcome['vicar_name'] ?>" 
                            class="w-48 h-48 rounded-full object-cover shadow-md border-4 border-[#660000]">
                    </div>

                    <!-- Message from the Vicar (Right Side) -->
                    <div class="text-center md:text-left">
                        <h3 class="text-3xl font-semibold text-[#660000] mb-4">
                            Message From The <?= $welcome['title'] ?> - <?= $welcome['vicar_name'] ?>
                        </h3>
                        <p class="text-lg text-gray-600">
                            <?= nl2br($welcome['message']) ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Become a Member Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 md:px-12 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-[#660000] mb-6 md:mb-8">Become a Member</h2>

            <!-- Call to Action: Join Now (Form Section) -->
            <div class="bg-white shadow-lg rounded-lg p-6 md:p-8 max-w-2xl mx-auto">
                <h3 class="text-2xl md:text-3xl font-semibold text-[#660000] mb-4">Ready to Join?</h3>
                <p class="text-base md:text-lg text-gray-600 mb-6">
                    Joining our church family is easy! Fill out the form below to get started, and a member of our team
                    will reach out to welcome you personally.
                </p>
         
            <!-- Success Message (Initially Hidden) -->
        <div id="successMembershipMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4 shadow-md">
            <strong>Success!</strong> Your membership request has been submitted successfully.
        </div>


        <!-- Membership Form -->
        <form id="membership-form" method="POST" class="bg-white space-y-4">

            <!-- Full Name -->
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                <label for="full-name" class="text-gray-800 font-semibold w-full md:w-32 text-left md:text-right">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="full-name" name="full-name" required
                    class="p-3 border border-[#660000] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#660000] w-full">
            </div>

            <!-- Email Address -->
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                <label for="email" class="text-gray-800 font-semibold w-full md:w-32 text-left md:text-right">
                    Email (Optional)
                </label>
                <input type="email" id="email" name="email" placeholder="Your Email Address"
                    class="p-3 border border-[#660000] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#660000] w-full">
            </div>

            <!-- Phone Number -->
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                <label for="phone" class="text-gray-800 font-semibold w-full md:w-32 text-left md:text-right">
                    Phone (Optional)
                </label>
                <div class="flex border border-[#660000] rounded-lg overflow-hidden w-full">
                    <select id="country-code" name="country-code"
                        class="bg-gray-100 px-3 py-3 border-r border-[#660000] text-gray-700 focus:outline-none w-1/4 min-w-[100px]">
                        <option value="+254">+254</option>
                        <option value="+255">+255</option>
                        <option value="+256">+256</option>
                        <option value="+260">+260</option>
                        <option value="+1">+1 (USA)</option>
                        <option value="+44">+44 (UK)</option>
                        <option value="+234">+234 (Nigeria)</option>
                    </select>
                    <input type="text" id="phone" name="phone"
                        class="p-3 focus:outline-none focus:ring-2 focus:ring-[#660000] w-3/4" placeholder="Your Phone Number">
                </div>
            </div>

            <!-- Location -->
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                <label for="location" class="text-gray-800 font-semibold w-full md:w-32 text-left md:text-right">
                    Location <span class="text-red-500">*</span>
                </label>
                <input type="text" id="location" name="location" required
                    class="p-3 border border-[#660000] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#660000] w-full">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-6">
                <button type="submit" id="submitMember"
                    class="w-full md:w-1/2 bg-[#660000] text-white py-3 rounded-lg hover:bg-[#993333] transition duration-300 font-semibold">
                    Submit Membership Request
                </button>
            </div>
        </form>


            </div>
        </div>
    </section>
</main>
<script>
document.getElementById("membership-form").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("membership_request", true);
    var submitBtn = document.getElementById("submitMember");
    var successMessage = document.getElementById("successMembershipMessage");

    submitBtn.disabled = true;
    submitBtn.textContent = "Submitting...";

    fetch("includes/models.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            successMessage.classList.remove("hidden");
            document.getElementById("membership-form").reset();

            setTimeout(() => {
                successMessage.classList.add("hidden");
            }, 5000);
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error))
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit Membership Request";
    });
});
</script>