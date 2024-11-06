<?php
session_start();
include 'db.php';

// Fetch primary course distribution data
$query_course = "SELECT course_section, COUNT(*) as count FROM user_data GROUP BY course_section";
$result_course = mysqli_query($con, $query_course);

$course_labels = [];
$course_data = [];
while ($row = mysqli_fetch_assoc($result_course)) {
    $course_labels[] = $row['course_section'];
    $course_data[] = (int)$row['count'];
}

// Fetch religion distribution
$query_religion = "SELECT religion, COUNT(*) as count FROM user_data GROUP BY religion";
$result_religion = mysqli_query($con, $query_religion);

$religion_labels = [];
$religion_data = [];
while ($row = mysqli_fetch_assoc($result_religion)) {
    $religion_labels[] = $row['religion'];
    $religion_data[] = (int)$row['count'];
}

// Fetch additional demographics
$demographic_data = [];
$attributes = [
    "gender_identity",
    "age",
    "civil_status",
    "handicapped",
    "birth_order",
    "number_of_siblings",
    "parents_marital_status",
    "family_income",
    "marriage_status"
];

foreach ($attributes as $attribute) {
    $query = "SELECT $attribute, COUNT(*) as count FROM user_data GROUP BY $attribute";
    $result = mysqli_query($con, $query);

    if ($result) {
        $demographic_data[$attribute] = ["labels" => [], "data" => []];
        while ($row = mysqli_fetch_assoc($result)) {
            $demographic_data[$attribute]["labels"][] = $row[$attribute];
            $demographic_data[$attribute]["data"][] = (int)$row['count'];
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demographic Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #courseChart {
            height: 500px;
            width: 300px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .back-button {
            margin-bottom: 20px;
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* Set to 5 columns */
            gap: 20px;
            width: 100%;
            /* Use full width */
            max-width: none;
            /* Remove maximum width */
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* Space between charts */
            justify-content: center;
        }



        .chart-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 800px;
            width: 600px;
            margin-bottom: 20px;
            /* Space between rows */
            /* Ensures two charts per row */
            flex: 0 1 calc(50% - 20px);
        }

        .chart-container h2 {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: repeat(2, 1fr);
                /* 2 columns on small screens */
            }
        }

        @media (max-width: 480px) {
            .dashboard {
                grid-template-columns: 1fr;
                /* 1 column on very small screens */
            }
        }
    </style>

</head>

<body>
    <a href="cumulative_records.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer circle -->
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
            <!-- Inner arrow shape -->
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
    <h1>Demographic Dashboard</h1>
    <div class="dashboard">
        <!-- Primary Data -->
        <div class="chart-container">
            <h2>Course Distribution</h2>
            <canvas id="courseChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Religion Distribution</h2>
            <canvas id="religionChart"></canvas>
        </div>

        <!-- Additional Demographics -->
        <div class="chart-container">
            <h2>Gender Identity Distribution</h2>
            <canvas id="gender_identityChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Age Distribution</h2>
            <canvas id="ageChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Civil Status Distribution</h2>
            <canvas id="civil_statusChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Handicapped Distribution</h2>
            <canvas id="handicappedChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Birth Order Distribution</h2>
            <canvas id="birth_orderChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Number of Siblings Distribution</h2>
            <canvas id="number_of_siblingsChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Parents' Marital Status Distribution</h2>
            <canvas id="parents_marital_statusChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Family Income Distribution</h2>
            <canvas id="family_incomeChart"></canvas>
        </div>

        <div class="chart-container">
            <h2>Marriage Status Distribution</h2>
            <canvas id="marriage_statusChart"></canvas>
        </div>
    </div>

    <script>
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        display: true // Show y-axis ticks
                    }
                },
                x: {
                    ticks: {
                        display: true // Show x-axis ticks
                    }
                }
            }
        };

        // Course Distribution
        new Chart(document.getElementById('courseChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($course_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($course_data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: chartOptions
        });

        // Religion Distribution
        new Chart(document.getElementById('religionChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($religion_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($religion_data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)'
                }]
            },
            options: chartOptions
        });

        // Demographic Charts
        <?php foreach ($demographic_data as $attribute => $data): ?>
            new Chart(document.getElementById('<?php echo $attribute; ?>Chart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($data["labels"]); ?>,
                    datasets: [{
                        data: <?php echo json_encode($data["data"]); ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)'
                    }]
                },
                options: chartOptions
            });
        <?php endforeach; ?>
    </script>
</body>

</html>