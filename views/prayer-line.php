<?php 
$pageTitle = "Prayer Line"; 
?>

<!-- Main Content -->
<main class="flex-grow bg-[#ffffff] py-8 px-4 text-center">

    <!-- Header Section -->
    <h2 class="text-3xl font-bold mb-4 text-[#6C8BC9]">Prayer Line</h2>
    <p class="text-black mb-8 max-w-2xl mx-auto leading-relaxed">
        We believe in the power of prayer. Share your prayer requests with us, and our team will stand with you in faith. 
        Your contact details are optional, and all requests will be handled with care and confidentiality.
    </p>

    <!-- Prayer Form Section -->
    <section class="max-w-2xl mx-auto bg-[#ffffff] p-8 shadow-lg rounded-lg border border-[#6C8BC9]">
        
        <!-- Section Title -->
        <h3 class="text-2xl font-semibold mb-6 text-[#6C8BC9]">Submit Your Prayer Request</h3>

        <!-- Success Message (Initially Hidden) -->
        <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4 shadow-md">
            <strong>Success!</strong> Your prayer request has been submitted successfully.
        </div>

        <!-- Prayer Request Form -->
        <form id="prayer-form" method="POST" class="space-y-6">
            
            <!-- Prayer Request Field -->
            <div class="flex flex-col text-left">
                <label for="prayerRequest" class="text-sm font-medium text-black">
                    Prayer Request <span class="text-[#D18C7C]">*</span>
                </label>
                <textarea id="prayerRequest" name="prayerRequest" rows="4" required 
                    class="mt-2 block w-full rounded-md border border-[#6C8BC9] shadow-sm focus:border-[#6C8BC9] focus:ring-2 focus:ring-[#6C8BC9] transition duration-200 p-3"></textarea>
            </div>  

            <!-- Email Field -->
            <div class="flex flex-col text-left">
                <label for="email" class="text-sm font-medium text-black">Email (Optional)</label>
                <input type="email" id="email" name="email" placeholder="Your Email Address" 
                    class="mt-2 block w-full rounded-md border border-[#6C8BC9] shadow-sm focus:border-[#6C8BC9] focus:ring-2 focus:ring-[#6C8BC9] transition duration-200 p-3">
            </div>

            <!-- Phone Number Field -->
            <div class="flex flex-col text-left">
                <label for="phone" class="text-sm font-medium text-black">Phone (Optional)</label>
                <input type="text" id="phone" name="phone" placeholder="Your Phone Number" 
                    class="mt-2 block w-full rounded-md border border-[#6C8BC9] shadow-sm focus:border-[#6C8BC9] focus:ring-2 focus:ring-[#6C8BC9] transition duration-200 p-3">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" id="submitBtn" 
                    class="bg-[#6C8BC9] text-white px-6 py-3 rounded-md shadow-md hover:bg-[#D18C7C] transition duration-300 transform hover:scale-105">
                    Submit Prayer Request
                </button>
            </div>
        </form>
    </section>
</main>

<!-- Custom JavaScript -->
<script>
    document.getElementById("prayer-form").addEventListener("submit", function(event) {
        event.preventDefault();

        var formData = new FormData(this);
        formData.append("prayer_request", true);
        var submitBtn = document.getElementById("submitBtn");
        var successMessage = document.getElementById("successMessage");

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
                document.getElementById("prayer-form").reset();

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
            submitBtn.textContent = "Submit Prayer Request";
        });
    });
</script>