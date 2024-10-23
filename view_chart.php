<?php
session_start();
include 'db.php';

// Fetch the count of each course section
$query = "SELECT course_section, COUNT(*) as count FROM user_data GROUP BY course_section";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error fetching course data: " . mysqli_error($con));
}

$labels = [];
$data = [];

// Prepare data for the chart
while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['course_section'];
    $data[] = (int)$row['count'];
}

// Close the connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Distribution Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .chart-container {
            width: 30%;
            margin: auto;
        }
    </style>
</head>
<body>
<a href="cumulative_records.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Outer circle -->
        <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
        <!-- Inner arrow shape -->
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>
    <div class="chart-container">
        <h1>Course Distribution Chart</h1>
        <canvas id="myPieChart"></canvas>
        <script>
            const ctx = document.getElementById('myPieChart').getContext('2d');
            const myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        label: 'Number of Students',
                        data: <?php echo json_encode($data); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Distribution of Students by Course Section'
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>
