<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: /public/admin/views/login.php");
    exit();
}
?>

<div class="h-full w-full flex flex-col space-y-6 p-6 bg-gray-100 overflow-y-auto">

    <!-- Top Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="p-6 bg-white shadow-md rounded-lg text-center border-l-4 border-blue-600">
            <h3 class="text-lg font-semibold text-gray-700">Total Admins</h3>
            <p class="text-3xl font-bold text-blue-600" id="totalAdmins">0</p>
        </div>
        <div class="p-6 bg-white shadow-md rounded-lg text-center border-l-4 border-green-600">
            <h3 class="text-lg font-semibold text-gray-700">Total Departments</h3>
            <p class="text-3xl font-bold text-green-600" id="totalDepartments">0</p>
        </div>
        <div class="p-6 bg-white shadow-md rounded-lg text-center border-l-4 border-yellow-500">
            <h3 class="text-lg font-semibold text-gray-700">Total Members</h3>
            <p class="text-3xl font-bold text-yellow-500" id="totalMembers">0</p>
        </div>
        <div class="p-6 bg-white shadow-md rounded-lg text-center border-l-4 border-red-500">
            <h3 class="text-lg font-semibold text-gray-700">Total Prayer Requests</h3>
            <p class="text-3xl font-bold text-red-500" id="totalPrayerRequests">0</p>
        </div>
    </div>

    <!-- Church Engagement & Communication -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Church Engagement</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-purple-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-purple-600">Unread Messages</h3>
                <p class="text-2xl font-bold text-purple-600" id="unreadMessages">0</p>
            </div>
            <div class="p-4 bg-indigo-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-indigo-600">Upcoming Events</h3>
                <p class="text-2xl font-bold text-indigo-600" id="upcomingEvents">0</p>
            </div>
            <div class="p-4 bg-orange-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-orange-600">Pending Announcements</h3>
                <p class="text-2xl font-bold text-orange-600" id="pendingAnnouncements">0</p>
            </div>
        </div>
    </div>

    <!-- Departments Applications Trends -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Departments Trends</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-gray-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-gray-700">Total Applications</h3>
                <p class="text-2xl font-bold text-gray-700" id="totalDepartmentApplications">0</p>
            </div>
            <div class="p-4 bg-pink-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-pink-600">New Applications This Month</h3>
                <p class="text-2xl font-bold text-pink-600" id="newDepartmentApplications">0</p>
            </div>
            <div class="p-4 bg-white border border-gray-300 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700">Top Requested Departments</h3>
                <ul id="topDepartments" class="list-disc list-inside text-gray-600"></ul>
            </div>
        </div>
    </div>

    <!-- Media & Content -->
    <div class="bg-white shadow-md rounded-lg p-6 flex-1">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Media & Content</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-teal-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-teal-600">Total Sermons</h3>
                <p class="text-2xl font-bold text-teal-600" id="totalSermons">0</p>
            </div>
            <div class="p-4 bg-cyan-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-cyan-600">Total Audio Sermons</h3>
                <p class="text-2xl font-bold text-cyan-600" id="totalAudioSermons">0</p>
            </div>
            <div class="p-4 bg-rose-100 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-rose-600">Total Set of Pictures</h3>
                <p class="text-2xl font-bold text-rose-600" id="totalImageSets">0</p>
            </div>
            <div class="p-4 bg-white border border-gray-300 rounded-lg col-span-1 md:col-span-3">
                <h3 class="text-lg font-semibold text-gray-700">Recent Sermon</h3>
                <p>Title: <span id="recentSermonTitle" class="font-bold"></span></p>
                <p>Speaker: <span id="recentSermonSpeaker" class="font-bold"></span></p>
                <p>Date: <span id="recentSermonDate" class="font-bold"></span></p>
            </div>
        </div>
    </div>

</div>