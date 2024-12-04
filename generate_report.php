<?php
// Include TCPDF for PDF generation
//require_once('tcpdf.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;

        }

        .form-group {
            margin-bottom: 20px;
        }

        #report-output {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            width: 300px;
            height: 100px;
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Generate Report</h1>
        <div class="form-group">
            <label for="report-type">Select Report Type:</label>
            <select id="report-type">
                <option value="top20">Top 20 Concerns</option>
                <option value="top5">Top 5 Concerns</option>
                <option value="student_summary">Student Summary</option>
            </select>
        </div>
        <div class="form-group">
            <button id="generate-btn">Generate Report</button>
            <button id="download-btn">Download Report</button>
        </div>
        <div id="report-output">
            <p>Report will be displayed here...</p>
        </div>
    </div>

    <script>
        document.getElementById('generate-btn').addEventListener('click', function() {
            const reportType = document.getElementById('report-type').value;
            fetch(`fetch_report.php?type=${reportType}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('report-output').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById('download-btn').addEventListener('click', function() {
            const reportType = document.getElementById('report-type').value;
            window.location.href = `download_report.php?type=${reportType}`;
        });
    </script>

</body>

</html>