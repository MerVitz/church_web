<?php
include_once __DIR__ . "/../../../includes/db.php";

try {
    //  Ensure the analytics table exists
    $conn->query("SELECT 1 FROM analytics LIMIT 1");

    //  Fetch analytics data
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

<div class="bg-white p-6 rounded-lg shadow-md relative">
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
    <canvas id="analyticsChart" class="mt-4"></canvas>
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
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } else {
        document.getElementById('analyticsChart').innerHTML = "<p class='text-gray-600 text-center'>No analytics data available yet.</p>";
    }
</script>
