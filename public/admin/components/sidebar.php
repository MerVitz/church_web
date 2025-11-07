<?php
/**
 * Admin Sidebar Component
 * ---------------------------------------
 * Purpose:
 * - Provides navigation for the admin dashboard.
 * - Contains links to key sections: Dashboard, Page Management, Analytics.
 * - Displays parish logo and name.
 * - Provides a logout action at the bottom.
 *
 * Features:
 * - Highlights active menu item via `data-page` attribute (used by JS).
 * - Responsive utility classes from TailwindCSS.
 * - Easy to extend by adding new `<li>` blocks.
 *
 * Dependencies:
 * - Requires TailwindCSS for styling.
 * - Optional: JS script that toggles `.active` class based on current `data-page`.
 *
 * Security:
 * - Should only be included on admin-protected pages (session validation handled elsewhere).
 */
?>

<aside class="w-64 bg-[#660000] text-white h-screen flex flex-col py-6 px-4 shadow-lg">
    <!-- Church Logo & Name -->
    <div class="flex items-center space-x-3 mb-6">
        <a href="#" id="dashboard-logo" class="flex items-center">
            <img src="/public/images/ack_logo.png" alt="Church Logo" class="h-16 w-auto object-contain">
        </a>
        <span class="text-xl font-semibold">All Saints ACK Maseno Parish</span>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-grow">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="#" data-page="dashboard"
                   class="menu-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-[#b37d2a]">
                    <img src="/public/images/dashboard.svg" alt="Dashboard" class="w-6 h-6">
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Manage Pages -->
            <li>
                <a href="#" data-page="pages"
                   class="menu-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-[#b37d2a]">
                    <img src="/public/images/manage.svg" alt="Manage Pages" class="w-6 h-6">
                    <span>Manage Pages</span>
                </a>
            </li>

            <!-- Analytics -->
            <li>
                <a href="#" data-page="analytics"
                   class="menu-item flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-[#b37d2a]">
                    <img src="/public/images/analyse.svg" alt="View Analytics" class="w-6 h-6">
                    <span>View Analytics</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout Button -->
    <a href="?page=logout"
       class="flex items-center justify-center space-x-3 p-3 rounded-lg bg-red-500 hover:bg-red-600 transition-all duration-200 ease-in-out">
        <img src="/public/images/bx-log-out.svg" alt="Logout" class="w-6 h-6">
        <span>Logout</span>
    </a>
</aside>

<script>
/**
 * Sidebar Active State Handler
 * --------------------------------
 * Highlights the currently active page in the sidebar
 * by comparing `data-page` with a global `currentPage` variable.
 */
document.addEventListener("DOMContentLoaded", () => {
    const currentPage = window.currentPage || ""; // set this in each PHP view
    document.querySelectorAll(".menu-item").forEach(item => {
        if (item.dataset.page === currentPage) {
            item.classList.add("bg-[#b37d2a]");
        }
    });
});
</script>

