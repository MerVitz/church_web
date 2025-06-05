<?php 
$pageTitle = "Our Departments"; 
include_once "includes/models.php";
echo "<script>console.log('Current Page: $current_page');</script>"; 
$departments = getDepartments();
?>
<!-- Main Content -->
<main class="flex-grow bg-white py-16 px-4">
    <div class="container mx-auto max-w-7xl px-6 md:px-12">
        
        <!-- Header Section -->
        <div class="mb-12 max-w-4xl mx-auto text-center md:text-left px-4">
            <h2 class="text-[28px] font-normal text-black tracking-wide mb-2 uppercase">
                Our Departments
            </h2>
            <p class="text-sm md:text-base text-gray-700 leading-relaxed">
                At <span class="font-medium text-[#6C8BC9]">ACK All Saints Maseno Parish</span>, we offer a variety of departments tailored to every age and interest—designed to deepen faith, build community, and serve with love. Explore where you belong.
            </p>
        </div>

        <!-- Departments Grid -->
        <div id="departments" class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($departments as $department) : ?>
            <div class="relative group overflow-hidden rounded-2xl shadow-xl transform transition-all hover:scale-[1.03] hover:shadow-2xl bg-center bg-cover"
                style="background-image: url('<?php echo htmlspecialchars($department['bg_image']); ?>');">

                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-[#6C8BC9]/80 group-hover:bg-[#6C8BC9]/60 transition-all duration-500 backdrop-blur-sm"></div>

                <!-- Content Layer -->
                <div class="relative z-10 flex flex-col items-center text-center p-8 text-white h-full justify-between">
                    <div>
                        <h3 class="text-2xl font-semibold mb-3">
                            <?php echo htmlspecialchars($department['name']); ?>
                        </h3>
                        <p class="opacity-0 group-hover:opacity-100 transition-opacity duration-500 text-sm leading-relaxed">
                            <?php echo nl2br(htmlspecialchars($department['description'])); ?>
                        </p>
                    </div>

                    <button class="mt-6 px-5 py-2.5 bg-[#D18C7C] text-white rounded-full text-sm font-medium shadow hover:bg-white hover:text-[#D18C7C] transition duration-300 opacity-0 group-hover:opacity-100"
                        onclick="openJoinModal('<?php echo addslashes($department['name']); ?>')">
                        Join Department
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Call to Action -->
        <div class="mt-20 text-center">
            <h3 class="text-2xl md:text-3xl font-semibold text-[#6C8BC9] mb-4">
                Get Involved
            </h3>
            <p class="text-gray-700 mb-6 max-w-xl mx-auto">
                Every department plays a vital role. If you feel called to serve, choose a department and make a difference.
            </p>
            <a href="#departments" class="inline-block bg-[#D18C7C] text-white px-8 py-3 rounded-lg shadow hover:bg-[#6C8BC9] transition-transform transform hover:scale-105">
                Join a Department
            </a>
        </div>

        <!-- Response Message -->
        <div id="message-wrapper" class="fixed inset-0 z-[100000] pointer-events-none flex items-start justify-center">
            <div id="response-message" class="mt-5"></div>
        </div>
    </div>
</main>


<!-- Join Prayer Team Modal -->
<div id="joinModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-[#ffffff] rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-xl font-bold text-[#6C8BC9]"></h3>
            <button onclick="closeJoinModal()" class="text-black hover:text-[#D18C7C]">×</button>
        </div>
        <form id="joinForm" class="space-y-4">
            <input type="hidden" name="department_application" value="1">
            
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
            <!-- Department Input -->
            <div>
            <label for="departmentName" class="block text-black">Department</label>
            <input
                type="text"
                id="departmentName"
                name="departmentName"
                class="mt-1 w-full p-2 border rounded-md bg-gray-100"
                readonly
            />
            </div>

            <!-- Dropdown shown ONLY for Scheme Fellowships -->
            <div id="fellowshipDropdownWrapper" class="hidden mt-4">
            <label for="fellowshipSelect" class="block text-black">Select Scheme Fellowship</label>
            <select
                id="fellowshipSelect"
                class="mt-1 w-full p-2 border rounded-md focus:ring focus:border-blue-400"
            >
                <option value="" disabled selected>Choose Scheme</option>
                <option value="Bethlehem">Bethlehem</option>
                <option value="Zion">Zion</option>
                <option value="Jerusalem">Jerusalem</option>
                <option value="Canaan">Canaan</option>
            </select>
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

            let department = $("#departmentName").val();

            if (department === "Scheme Fellowships") {
                const selectedFellowship = $("#fellowshipSelect").val();

                if (!selectedFellowship) {
                alert("Please select your fellowship (Bethlehem, Zion, etc).");
                return;
                }

                // Append the scheme name
                department += " - " + selectedFellowship;
            }

            // Set the combined value before submission
            $("#departmentName").val(department);

            let formData = $(this).serialize();
            console.log("Final department:", department);
            console.log("Form data being sent:", formData);


        $.ajax({
            url: "includes/models.php",
            type: "POST",
            data: formData,
            dataType: "json",

            beforeSend: function() {
                console.log("✅ Submitting form to: includes/models.php");
                console.log("📝 Form data being sent:", formData);
            },

            success: function(response) {
                console.log("✅ Server response (success):", response);

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

                setTimeout(function() {
                    $("#response-message").fadeOut("slow");
                }, 5000);
            },

            error: function(xhr, status, error) {
                console.error("❌ AJAX error");
                console.error("🔴 Status:", status);
                console.error("🔴 Error:", error);
                console.error("🔴 Raw response:", xhr.responseText);

                let errorMessage = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">Something went wrong: ${xhr.responseText || error}</span>
                    </div>
                `;

                $("#response-message").html(errorMessage).fadeIn();

                setTimeout(function() {
                    $("#response-message").fadeOut("slow");
                }, 5000);
            }
        });
        });
    });
</script>