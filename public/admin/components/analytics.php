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
    // Attempt to query the analytics table
    $conn->query("SELECT 1 FROM analytics LIMIT 1");

    // Fetch analytics data
    $views = $conn->query("SELECT page_name, views FROM analytics ORDER BY views DESC")->fetchAll(PDO::FETCH_ASSOC);
    $totalViews = $conn->query("SELECT SUM(views) AS total FROM analytics")->fetchColumn();

} catch (PDOException $e) {
    // Table missing
    $errorMessage = "Analytics table is missing! <a href='?create_table=true' class='text-blue-600 underline'>Click here to create it</a>.";
}

// Create analytics table if user clicked "create_table"
if (isset($_GET['create_table'])) {
    try {
        $conn->exec("
            CREATE TABLE IF NOT EXISTS analytics (
                id INT AUTO_INCREMENT PRIMARY KEY,
                page_name VARCHAR(255) UNIQUE NOT NULL,
                views INT DEFAULT 0
            )
        ");

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    } catch (PDOException $e) {
        $errorMessage = "Failed to create analytics table.";
    }
}
?>

<div class="bg-white p-6 rounded-lg shadow-md relative">
    <div class="flex justify-between items-start">

        <h3 class="text-lg font-semibold text-gray-800">Views Per Page</h3>

        <div class="text-right">
            <p class="text-3xl font-bold text-[#660000]"><?= $totalViews ?? 0 ?></p>
            <p class="text-sm text-gray-600">Total Page Views</p>
        </div>

    </div>

    <canvas id="analyticsChart" class="mt-4"></canvas>
</div>

<script>
    const pageNames = <?= json_encode(array_column($views ?? [], 'page_name')); ?>;
    const pageViews = <?= json_encode(array_column($views ?? [], 'views')); ?>;

    if (pageNames.length > 0) {
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: pageNames,
                datasets: [{
                    label: 'Views',
                    data: pageViews,
                    borderWidth: 1
                }]
            },
            options: {responsive: true, scales: {y: {beginAtZero: true}}}
        });
    } else {
        document.getElementById('analyticsChart').innerHTML =
            "<p class='text-gray-600 text-center'>No analytics data available yet.</p>";
    }
</script>
