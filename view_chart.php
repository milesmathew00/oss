<?php
session_start();
include 'db.php';

// Fetch the count of each course section for pie and bar chart
$query = "SELECT course_section, COUNT(*) as count FROM user_data GROUP BY course_section";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error fetching course data: " . mysqli_error($con));
}

$labels = [];
$data = [];

// Prepare data for the charts
while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['course_section'];
    $data[] = (int)$row['count'];
}

// Fetch religion data for another pie or bar chart
$query_religion = "SELECT religion, COUNT(*) as count FROM user_data GROUP BY religion";
$result_religion = mysqli_query($con, $query_religion);

if (!$result_religion) {
    die("Error fetching religion data: " . mysqli_error($con));
}

$religion_labels = [];
$religion_data = [];

// Prepare data for religion chart
while ($row_religion = mysqli_fetch_assoc($result_religion)) {
    $religion_labels[] = $row_religion['religion'];
    $religion_data[] = (int)$row_religion['count'];
}

// Close the connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course & Religion Distribution Charts</title>
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
            width: 40%;
            margin: auto;
        }
    </style>
</head>

<body>
    <a href="cumulative_records.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    <div class="chart-container">
        <h1>Course Distribution Pie Chart</h1>
        <canvas id="myPieChart"></canvas>
        <h1>Religion Distribution Pie Chart</h1>
        <canvas id="myReligionChart"></canvas>
        <h1>Religion Distribution Bar Chart</h1>
        <canvas id="myReligionBarChart"></canvas>
    </div>

    <script>
        const labels = <?php echo json_encode($labels); ?>;
        const dataCounts = <?php echo json_encode($data); ?>;

        const religionLabels = <?php echo json_encode($religion_labels); ?>;
        const religionData = <?php echo json_encode($religion_data); ?>;

        // Pie Chart for Course Distribution
        const pieCtx = document.getElementById('myPieChart').getContext('2d');
        const myPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Students',
                    data: dataCounts,
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
                    title: {
                        display: true,
                        text: 'Distribution of Students by Course Section'
                    }
                }
            }
        });

        // Pie Chart for Religion Distribution
        const religionPieCtx = document.getElementById('myReligionChart').getContext('2d');
        const myReligionPieChart = new Chart(religionPieCtx, {
            type: 'pie',
            data: {
                labels: religionLabels,
                datasets: [{
                    label: 'Number of Students',
                    data: religionData,
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
                    title: {
                        display: true,
                        text: 'Distribution of Students by Religion'
                    }
                }
            }
        });

        // Bar Chart for Religion Distribution
        const religionBarCtx = document.getElementById('myReligionBarChart').getContext('2d');
        const myReligionBarChart = new Chart(religionBarCtx, {
            type: 'bar',
            data: {
                labels: religionLabels,
                datasets: [{
                    label: 'Number of Students',
                    data: religionData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribution of Students by Religion (Bar Chart)'
                    }
                }
            }
        });
    </script>

</body>

</html>