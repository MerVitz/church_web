<?php
include_once __DIR__ . "/../../../includes/db.php";
/**
 * Analytics Component
 * -------------------
 * Displays page view analytics with a bar chart.
 * - Fetches data from the `analytics` table.
 * - If table does not exist, prompts the user to create it.
 * - Shows total views and per-page breakdown.
 */

try {
<<<<<<< HEAD
    //  Ensure the analytics table exists
    $conn->query("SELECT 1 FROM analytics LIMIT 1");

    //  Fetch analytics data
=======
    // Ensure the analytics table exists
    $conn->query("SELECT 1 FROM analytics LIMIT 1");

    // Fetch analytics data
>>>>>>> 8a6943cfc470f8b96b150cf9b48ca6f491758639
    $views = $conn->query("SELECT page_name, views FROM analytics ORDER BY views DESC")->fetchAll();
    $totalViews = $conn->query("SELECT SUM(views) AS total FROM analytics")->fetchColumn();
} catch (PDOException $e) {
    $errorMessage = "Analytics table is missing! <a href='?create_table=true' class='text-blue-600 underline'>Click here to create it</a>.";
}

// Create Table if Not Exists (When User Clicks)
if (isset($_GET['create_table'])) {
    try {
        $conn->exec("CREATE TABLE analytics (
            id INT AUTO_INCREMENT PRIMARY KEY,
            page_name VARCHAR(255) UNIQUE NOT NULL,
            views INT DEFAULT 0
        )");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        $errorMessage = "Failed to create analytics table.";
    }
}
?>

<!-- Wrapper ensures full height + consistent padding -->
<div class="h-full w-full flex flex-col space-y-6 p-6 bg-gray-100">

    <div class="bg-white p-6 rounded-lg shadow-md relative flex-1">
        <div class="flex justify-between items-start">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-800">Views Per Page</h3>

            <!-- Total Views on the Top Right -->
            <div class="text-right">
                <p class="text-3xl font-bold text-[#660000]"><?= $totalViews ?? 0 ?></p>
                <p class="text-sm text-gray-600">Total Page Views</p>
            </div>
        </div>

        <!-- Chart -->
        <canvas id="analyticsChart" class="mt-4 w-full h-[400px]"></canvas>
    </div>

</div>

<script>
    const pageNames = <?= isset($views) ? json_encode(array_column($views, 'page_name')) : "[]" ?>;
    const pageViews = <?= isset($views) ? json_encode(array_column($views, 'views')) : "[]" ?>;

    if (pageNames.length > 0) {
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: pageNames,
                datasets: [{
                    label: 'Views',
                    data: pageViews,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // chart fills container height
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } else {
        document.getElementById('analyticsChart').outerHTML =
            "<p class='text-gray-600 text-center mt-6'>No analytics data available yet.</p>";
    }
</script>
