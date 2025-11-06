<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ?page=admin-login");
    exit();
}

// Prevent back button access
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Wed, 11 Jan 1984 05:00:00 GMT");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="flex h-screen bg-gray-100">

    <!-- Mobile Toggle Button -->
    <button id="sidebar-toggle"
        class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-[#660000] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-white">
        <!-- Hamburger Icon -->
        <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Dark overlay (for mobile only) -->
    <div id="sidebar-overlay"   class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-[#660000] text-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        
        <!-- Close Button (mobile only) -->
        <button id="sidebar-close"
            class="absolute top-4 right-4 lg:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <?php include_once "public/admin/components/sidebar.php"; ?>
    </aside>


    <!-- Main Content -->
    <main id="main-content"
        class="flex-1 lg:ml-64 p-6 transition-all duration-300">

        <div class="mb-6 mt-12 lg:mt-0"> <!-- top margin on mobile so it clears the hamburger -->
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-700">
                Welcome, <span class="text-[#660000]"><?= $_SESSION['admin_name'] ?? "Admin"; ?></span>!
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">
                Manage your dashboard and stay up to date.
            </p>
        </div>

        <div id="admin-content" class="w-full h-full">
            <?php include "public/admin/components/dashboard.php"; ?>  
        </div>
    </main>


<script>



    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebarClose = document.getElementById("sidebar-close");
    const sidebarOverlay = document.getElementById("sidebar-overlay");

    // Function to open sidebar
    function openSidebar() {
        sidebar.classList.remove("-translate-x-full");
        sidebarOverlay.classList.remove("hidden");
        sidebarToggle.classList.add("hidden"); // hide hamburger
    }

    // Function to close sidebar
    function closeSidebar() {
        sidebar.classList.add("-translate-x-full");
        sidebarOverlay.classList.add("hidden");
        sidebarToggle.classList.remove("hidden"); // show hamburger again
    }

    // Open sidebar on toggle click
    sidebarToggle.addEventListener("click", openSidebar);

    // Close sidebar on close button
    sidebarClose.addEventListener("click", closeSidebar);

    // Close sidebar when clicking overlay
    sidebarOverlay.addEventListener("click", closeSidebar);

    // Close sidebar when clicking any sidebar menu item (mobile only)
    document.querySelectorAll("#sidebar .menu-item").forEach(item => {
        item.addEventListener("click", () => {
            if (window.innerWidth < 1024) { // lg breakpoint
                closeSidebar();
            }
        });
    });




    async function fetchDashboardData() {
        try {
            const response = await fetch("/public/admin/models/dashboard_data.php", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                }
            });

            const data = await response.json();

            if (!data) {
                console.error("No data received.");
                return;
            }

            document.getElementById("totalAdmins").textContent = data.totalAdmins;
            document.getElementById("totalMinistries").textContent = data.totalMinistries;
            document.getElementById("totalMembers").textContent = data.totalMembers;
            document.getElementById("totalPrayerRequests").textContent = data.totalPrayerRequests;

            document.getElementById("unreadMessages").textContent = data.unreadMessages;
            document.getElementById("upcomingEvents").textContent = data.upcomingEvents;
            document.getElementById("pendingAnnouncements").textContent = data.pendingAnnouncements;

            document.getElementById("totalMinistryApplications").textContent = data.totalMinistryApplications;
            document.getElementById("newMinistryApplications").textContent = data.newMinistryApplications;

            document.getElementById("totalSermons").textContent = data.totalSermons;
            document.getElementById("totalAudioSermons").textContent = data.totalAudioSermons;
            document.getElementById("totalImageSets").textContent = data.totalImageSets;

            // Display most recent sermon
            if (data.recentSermon) {
                document.getElementById("recentSermonTitle").textContent = data.recentSermon.title;
                document.getElementById("recentSermonSpeaker").textContent = data.recentSermon.speaker;
                document.getElementById("recentSermonDate").textContent = data.recentSermon.date;
            }

            // Display Top 3 Ministries
            const topMinistriesContainer = document.getElementById("topMinistries");
            topMinistriesContainer.innerHTML = "";
            data.topMinistries.forEach((ministry) => {
                const listItem = document.createElement("li");
                listItem.textContent = `${ministry.ministry_name} - Applications: ${ministry.count}`;
                topMinistriesContainer.appendChild(listItem);
            });

        } catch (error) {
            console.error("Error fetching dashboard data:", error);
        }
    }

    $(document).ready(function() {
        let lastPage = localStorage.getItem("admin_last_page") || "dashboard";

        $("#admin-content").html('<div class="text-gray-500 text-center mt-4">Loading...</div>');

        $("#admin-content").load("/public/admin/components/" + lastPage + ".php", function() {
            if (lastPage === "dashboard") {
                fetchDashboardData();
            }
        });

        $(".menu-item").click(function(event) {
            event.preventDefault();

            let page = $(this).data("page"); 
            localStorage.setItem("admin_last_page", page);

            $("#admin-content").fadeOut(200, function() {
                $("#admin-content").load("/public/admin/components/" + page + ".php", function() {
                    $("#admin-content").fadeIn(200);

                    if (page === "dashboard") {
                        fetchDashboardData();
                    }
                });
            });
        });

        // **Handle clicking the logo to load dashboard without reload**
        $("#dashboard-logo").click(function(event) {
            event.preventDefault(); // Prevent full page reload

            let page = "dashboard";
            localStorage.setItem("admin_last_page", page);

            $("#admin-content").fadeOut(200, function() {
                $("#admin-content").load("/public/admin/components/" + page + ".php", function() {
                    $("#admin-content").fadeIn(200);
                    fetchDashboardData();
                });
            });
        });
    });
</script>

</body>
</html>