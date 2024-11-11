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

        .chart-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 500px;
            width: 600px;
            margin-bottom: 20px;
        }

        .dropdown {
            margin-bottom: 20px;
        }
    </style>

</head>

<body>
    <a href="javascript:history.back()" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black; transition: all 0.3s ease;">
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Go to Previous Page">
            <!-- Outer circle -->
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
            <!-- Inner arrow shape -->
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
    <h1>Demographic Dashboard</h1>

    <div class="dropdown">
        <label for="chartSelect">Select a Chart:</label>
        <select id="chartSelect" onchange="showChart()">
            <option value="courseChart">Course Distribution</option>
            <option value="religionChart">Religion Distribution</option>
            <option value="gender_identityChart">Gender Identity Distribution</option>
            <option value="ageChart">Age Distribution</option>
            <option value="civil_statusChart">Civil Status Distribution</option>
            <option value="handicappedChart">Handicapped Status Distribution</option>
            <option value="birth_orderChart">Birth Order Distribution</option>
            <option value="number_of_siblingsChart">Number of Siblings Distribution</option>
            <option value="parents_marital_statusChart">Parents' Marital Status Distribution</option>
            <option value="family_incomeChart">Family Income Distribution</option>
            <option value="marriage_statusChart">Marriage Status Distribution</option>
        </select>
    </div>

    <div class="chart-container" id="courseChartContainer">
        <h2>Course Distribution</h2>
        <canvas id="courseChart"></canvas>
    </div>
    <div class="chart-container" id="religionChartContainer" style="display: none;">
        <h2>Religion Distribution</h2>
        <canvas id="religionChart"></canvas>
    </div>
    <div class="chart-container" id="gender_identityChartContainer" style="display: none;">
        <h2>Gender Identity Distribution</h2>
        <canvas id="gender_identityChart"></canvas>
    </div>
    <div class="chart-container" id="ageChartContainer" style="display: none;">
        <h2>Age Distribution</h2>
        <canvas id="ageChart"></canvas>
    </div>
    <div class="chart-container" id="civil_statusChartContainer" style="display: none;">
        <h2>Civil Status Distribution</h2>
        <canvas id="civil_statusChart"></canvas>
    </div>
    <div class="chart-container" id="handicappedChartContainer" style="display: none;">
        <h2>Handicapped Status Distribution</h2>
        <canvas id="handicappedChart"></canvas>
    </div>
    <div class="chart-container" id="birth_orderChartContainer" style="display: none;">
        <h2>Birth Order Distribution</h2>
        <canvas id="birth_orderChart"></canvas>
    </div>
    <div class="chart-container" id="number_of_siblingsChartContainer" style="display: none;">
        <h2>Number of Siblings Distribution</h2>
        <canvas id="number_of_siblingsChart"></canvas>
    </div>
    <div class="chart-container" id="parents_marital_statusChartContainer" style="display: none;">
        <h2>Parents' Marital Status Distribution</h2>
        <canvas id="parents_marital_statusChart"></canvas>
    </div>
    <div class="chart-container" id="family_incomeChartContainer" style="display: none;">
        <h2>Family Income Distribution</h2>
        <canvas id="family_incomeChart"></canvas>
    </div>
    <div class="chart-container" id="marriage_statusChartContainer" style="display: none;">
        <h2>Marriage Status Distribution</h2>
        <canvas id="marriage_statusChart"></canvas>
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
                        display: true
                    }
                },
                x: {
                    ticks: {
                        display: true
                    }
                }
            }
        };

        const chartData = {
            courseChart: {
                labels: <?php echo json_encode($course_labels); ?>,
                data: <?php echo json_encode($course_data); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)'
            },
            religionChart: {
                labels: <?php echo json_encode($religion_labels); ?>,
                data: <?php echo json_encode($religion_data); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)'
            },
            gender_identityChart: {
                labels: <?php echo json_encode($demographic_data['gender_identity']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['gender_identity']['data']); ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)'
            },
            ageChart: {
                labels: <?php echo json_encode($demographic_data['age']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['age']['data']); ?>,
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)'
            },
            civil_statusChart: {
                labels: <?php echo json_encode($demographic_data['civil_status']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['civil_status']['data']); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)'
            },
            handicappedChart: {
                labels: <?php echo json_encode($demographic_data['handicapped']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['handicapped']['data']); ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)'
            },
            birth_orderChart: {
                labels: <?php echo json_encode($demographic_data['birth_order']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['birth_order']['data']); ?>,
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)'
            },
            number_of_siblingsChart: {
                labels: <?php echo json_encode($demographic_data['number_of_siblings']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['number_of_siblings']['data']); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)'
            },
            parents_marital_statusChart: {
                labels: <?php echo json_encode($demographic_data['parents_marital_status']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['parents_marital_status']['data']); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)'
            },
            family_incomeChart: {
                labels: <?php echo json_encode($demographic_data['family_income']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['family_income']['data']); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)'
            },
            marriage_statusChart: {
                labels: <?php echo json_encode($demographic_data['marriage_status']['labels']); ?>,
                data: <?php echo json_encode($demographic_data['marriage_status']['data']); ?>,
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)'
            }
        };

        let charts = {};

        function showChart() {
            const selectedChart = document.getElementById("chartSelect").value;

            // Hide all charts
            Object.keys(charts).forEach(chart => {
                document.getElementById(chart + 'Container').style.display = 'none';
            });

            // Show the selected chart
            document.getElementById(selectedChart + 'Container').style.display = 'block';

            // Create chart if not already created
            if (!charts[selectedChart]) {
                const ctx = document.getElementById(selectedChart).getContext('2d');
                charts[selectedChart] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData[selectedChart].labels,
                        datasets: [{
                            label: 'Count',
                            data: chartData[selectedChart].data,
                            backgroundColor: chartData[selectedChart].backgroundColor,
                            borderColor: chartData[selectedChart].borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: chartOptions
                });
            }
        }

        showChart(); // Show default chart
    </script>
</body>

</html>