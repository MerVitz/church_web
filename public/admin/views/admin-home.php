<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: /?page=admin-login");
    exit();
}

// Prevent back button access
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Wed, 11 Jan 1984 05:00:00 GMT");
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="h-full bg-gray-100">

<!-- Wrapper: Sidebar + Main -->
<div class="flex h-screen w-screen overflow-hidden">

    <!-- Mobile Toggle Button -->
    <button id="sidebar-toggle"
        class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-[#660000] text-white rounded-md focus:outline-none focus:ring-2 focus:ring-white">
        <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Dark overlay (for mobile only) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>

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
        class="flex flex-col flex-1 lg:ml-64 p-6 transition-all duration-300 overflow-y-auto">

        <!-- Top Bar -->
        <div class="w-full flex justify-end items-center mb-6 mt-4 lg:mt-0">
            <div class="text-right">
                <p class="text-sm text-gray-500">Welcome back</p>
                <h2 class="text-base font-medium text-gray-700">
                    <?= $_SESSION['admin_name'] ?? "Admin"; ?>
                </h2>
            </div>
        </div>


        <!-- Dynamic Component Loader -->
        <div id="admin-content" class="flex-1 flex flex-col w-full">
            <?php include "public/admin/components/dashboard.php"; ?>  
        </div>
    </main>
</div>

<script>
    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebarClose = document.getElementById("sidebar-close");
    const sidebarOverlay = document.getElementById("sidebar-overlay");

    function openSidebar() {
        sidebar.classList.remove("-translate-x-full");
        sidebarOverlay.classList.remove("hidden");
        sidebarToggle.classList.add("hidden");
    }

    function closeSidebar() {
        sidebar.classList.add("-translate-x-full");
        sidebarOverlay.classList.add("hidden");
        sidebarToggle.classList.remove("hidden");
    }

    sidebarToggle.addEventListener("click", openSidebar);
    sidebarClose.addEventListener("click", closeSidebar);
    sidebarOverlay.addEventListener("click", closeSidebar);

    document.querySelectorAll("#sidebar .menu-item").forEach(item => {
        item.addEventListener("click", () => {
            if (window.innerWidth < 1024) closeSidebar();
        });
    });

    // ---------------------------
    // Dashboard Data Handling
    // ---------------------------
    let dashboardCache = null; // cache variable

    function updateElement(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value ?? "0";
    }

    function renderDashboardData(data) {
        if (!data) return;

        updateElement("totalAdmins", data.totalAdmins);
        updateElement("totalDepartments", data.totalDepartments);
        updateElement("totalMembers", data.totalMembers);
        updateElement("totalPrayerRequests", data.totalPrayerRequests);
        updateElement("unreadMessages", data.unreadMessages);
        updateElement("upcomingEvents", data.upcomingEvents);
        updateElement("pendingAnnouncements", data.pendingAnnouncements);
        updateElement("totalDepartmentApplications", data.totalDepartmentApplications);
        updateElement("newDepartmentApplications", data.newDepartmentApplications);
        updateElement("totalSermons", data.totalSermons);
        updateElement("totalAudioSermons", data.totalAudioSermons);
        updateElement("totalImageSets", data.totalImageSets);

        if (data.recentSermon) {
            updateElement("recentSermonTitle", data.recentSermon.title);
            updateElement("recentSermonSpeaker", data.recentSermon.speaker);
            updateElement("recentSermonDate", data.recentSermon.date);
        }

        const topDepartmentsContainer = document.getElementById("topDepartments");
        if (topDepartmentsContainer) {
            topDepartmentsContainer.innerHTML = "";
            data.topDepartments.forEach(department => {
                const li = document.createElement("li");
                li.textContent = `${department.department_name} - Applications: ${department.count}`;
                topDepartmentsContainer.appendChild(li);
            });
        }
    }

    async function fetchDashboardData(force = false) {
        try {
            // Use cache unless forced
            if (dashboardCache && !force) {
                renderDashboardData(dashboardCache);
                return;
            }

            const response = await fetch("/public/admin/models/dashboard_data.php", {
                cache: "no-store"
            });
            const data = await response.json();

            if (data) {
                dashboardCache = data; // store in cache
                renderDashboardData(data);
            }
        } catch (error) {
            console.error("Error fetching dashboard data:", error);
        }
    }

    // ---------------------------
    // Page Loading
    // ---------------------------
    $(document).ready(function() {
        let lastPage = localStorage.getItem("admin_last_page") || "dashboard";
        $("#admin-content").html('<div class="text-gray-500 text-center mt-4">Loading...</div>');

        function loadPage(page) {
            $("#admin-content").fadeOut(200, function() {
                $("#admin-content").load("/public/admin/components/" + page + ".php", function() {
                    $("#admin-content").fadeIn(200, function() {
                        if (page === "dashboard") fetchDashboardData();
                    });
                });
            });
        }

        loadPage(lastPage);

        $(".menu-item").click(function(e) {
            e.preventDefault();
            let page = $(this).data("page");
            localStorage.setItem("admin_last_page", page);
            loadPage(page);
        });

        $("#dashboard-logo").click(function(e) {
            e.preventDefault();
            localStorage.setItem("admin_last_page", "dashboard");
            loadPage("dashboard");
        });
    });
</script>


</body>
</html>
