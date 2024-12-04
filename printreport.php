<?php
ob_start();

require_once('tcpdf/tcpdf.php');
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected report type from the form
    $reportType = $_POST['reportType'];

    // Initialize TCPDF
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->AddPage();

    // Add a title to the report
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Guidance Report', 0, 1, 'C');

    // Handle each report type
    if ($reportType == 'problem') {
        // Problem Checklist Report
        $pdf->Cell(0, 10, 'Problem Checklist Report', 0, 1, 'C');
        $reportQuery = "SELECT concern, selection_count FROM aggregated_concerns ORDER BY selection_count DESC";

        $result = mysqli_query($con, $reportQuery);
        if (!$result) {
            die('Error fetching data: ' . mysqli_error($con));
        }

        // Table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(10, 10, '#', 1, 0, 'C', 1);
        $pdf->Cell(140, 10, 'Concern', 1, 0, 'L', 1);
        $pdf->Cell(40, 10, 'Selection Count', 1, 1, 'C', 1);

        // Table data
        $pdf->SetFont('helvetica', '', 12);
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(10, 10, $counter++, 1, 0, 'C');
            $pdf->Cell(140, 10, $row['concern'], 1, 0, 'L');
            $pdf->Cell(40, 10, $row['selection_count'], 1, 1, 'C');
        }
    } elseif ($reportType == 'by_product') {
        // Religion Report
        $pdf->Cell(0, 10, 'Religion Report', 0, 1, 'C');
        $reportQuery = "SELECT religion, COUNT(*) AS total FROM user_data GROUP BY religion";

        $result = mysqli_query($con, $reportQuery);
        if (!$result) {
            die('Error fetching data: ' . mysqli_error($con));
        }

        // Table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(120, 10, 'Religion', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Total', 1, 1, 'C', 1);

        // Table data
        $pdf->SetFont('helvetica', '', 12);
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(120, 10, $row['religion'], 1, 0, 'L');
            $pdf->Cell(60, 10, $row['total'], 1, 1, 'C');
        }
    } elseif ($reportType == 'product_inventory') {
        // Handicapped Report
        $pdf->Cell(0, 10, 'Handicapped Report', 0, 1, 'C');
        $reportQuery = "SELECT handicapped, COUNT(*) AS total FROM users GROUP BY handicapped";

        $result = mysqli_query($con, $reportQuery);
        if (!$result) {
            die('Error fetching data: ' . mysqli_error($con));
        }

        // Table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(120, 10, 'Handicapped Type', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Total', 1, 1, 'C', 1);

        // Table data
        $pdf->SetFont('helvetica', '', 12);
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(120, 10, $row['handicapped'], 1, 0, 'L');
            $pdf->Cell(60, 10, $row['total'], 1, 1, 'C');
        }
    } elseif ($reportType == 'registered_customers') {
        // Parent Marriage Status Report
        $pdf->Cell(0, 10, 'Parent Marriage Status Report', 0, 1, 'C');
        $reportQuery = "SELECT marriage_status, COUNT(*) AS total FROM users GROUP BY marriage_status";

        $result = mysqli_query($con, $reportQuery);
        if (!$result) {
            die('Error fetching data: ' . mysqli_error($con));
        }

        // Table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(120, 10, 'Marriage Status', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Total', 1, 1, 'C', 1);

        // Table data
        $pdf->SetFont('helvetica', '', 12);
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(120, 10, $row['marriage_status'], 1, 0, 'L');
            $pdf->Cell(60, 10, $row['total'], 1, 1, 'C');
        }
    } elseif ($reportType == 'all_orders') {
        // Birth Order Report
        $pdf->Cell(0, 10, 'Birth Order Report', 0, 1, 'C');
        $reportQuery = "SELECT birth_order, COUNT(*) AS total FROM users GROUP BY birth_order";

        $result = mysqli_query($con, $reportQuery);
        if (!$result) {
            die('Error fetching data: ' . mysqli_error($con));
        }

        // Table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(120, 10, 'Birth Order', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Total', 1, 1, 'C', 1);

        // Table data
        $pdf->SetFont('helvetica', '', 12);
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(120, 10, $row['birth_order'], 1, 0, 'L');
            $pdf->Cell(60, 10, $row['total'], 1, 1, 'C');
        }
    }

    // Output the PDF
    $pdf->Output('guidance_report.pdf', 'D');
}


ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sales Report</title>
    <link rel="stylesheet" href="stylez.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .report-container {
            width: 80%;
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
            margin-top: 20px;
            transition: border-color 0.3s;
        }

        .report-container:hover {
            border-color: #3498db;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            margin-right: 10px;
            font-weight: bold;
        }

        .form-group select {
            padding: 8px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .form-group select:hover,
        .form-group select:focus {
            border-color: #3498db;
            background-color: #f8f8f8;
        }


        .generate-report-button,
        .preview-report-button {
            display: inline-block;
            margin-right: 12px;
            /* Adjust the margin as needed */
        }


        .generate-report-button button,
        .preview-report-button button {
            border: none;
            width: 450px;
            cursor: pointer;
            padding: 15px;
            border: solid black 1px;
            border-radius: 10px;
            font-size: 46px;
            transition: background-color 0.3s;
            margin-right: 35px;
        }

        .generate-report-button button:hover,
        .preview-report-button button:hover {
            background-color: yellowgreen;
            color: darkgreen;
            border: solid darkgreen 2px;
        }

        #fic {
            width: 100px;
            height: 100px;
            margin-left: 5px;
            transition: transform 0.3s ease-in-out;
        }

        .generate-report-button button:hover #fic,
        .preview-report-button button:hover #fic {
            transform: rotate(360deg);
        }

        /* Arrow Link to Homepage */
        a {
            position: absolute;
            top: 10px;
            left: 50px;
            text-decoration: none;
            color: black;
            transition: color 0.3s;
        }

        a:hover {
            color: #3498db;
        }

        /* Navigation Bar */
        .navigationbar {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #logo {
            width: 170px;
            height: 170px;
            margin: 40px 0 0 140px;
        }

        /* Dropdown Styles */
        select {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #3498db;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
            transition: border-color 0.3s, background-color 0.3s, color 0.3s;
        }

        select:hover,
        select:focus {
            border-color: #2980b9;
            background-color: #f2f2f2;
            color: #000;
            outline: none;
        }

        /* Styling the Options */
        option {
            background-color: #fff;
            color: #333;
        }

        /* Hover and Focus Effect on Options */
        option:hover,
        option:focus {
            background-color: #3498db;
            color: #fff;
        }



        /* Button Styling */
        .print-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        /* Content Structure */
        .page {
            page-break-after: always;
            /* Forces a page break after each page section */
        }

        .page:first-of-type {
            display: none;
            /* Hide the first page when printing */
        }

        /* Print-Specific Styling */
        @media print {
            .print-button {
                display: none;
                /* Hide the print button in the print output */
            }
        }
    </style>
</head>

<body>

    <a href="admin_page.php"> <!-- Arrow Link to Homepage -->
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 12H4" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M10 18L4 12L10 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    <div class="navigationbar">
        <img src="images/logo.jpg" alt="Logo" id="logo">
    </div>



    <div class="report-container">
        <form method="post" action="">
            <div class="form-group">
                <label for="reportType">Select Report Type:</label>
                <select name="reportType" id="reportType" required>
                    <option value="problem">Problem Checklist</option>
                    <option value="by_product">Religion</option>
                    <option value="product_inventory">Handicapped</option>
                    <option value="registered_customers">Parent Marriage Status</option>
                    <option value="all_orders">Birth of Order</option>
                    <option value="income">Family Income</option>
                </select>
            </div>
            <div class="generate-report-button">
                <button type="button" onclick="generateReport()">
                    Generate Report <br> <br> <img src="images/download.png" id="fic">
                </button>
            </div>
            <div class="preview-report-button">
                <button type="button" onclick="previewReport()">
                    Preview Report <br> <br> <img src="images/downloads.png" id="fic">
                </button>
            </div>
        </form>
        <div id="preview-container"></div>

        <script>
            function previewReport() {
                // Get the selected report type
                var reportType = document.getElementById('reportType').value;

                // Fetch the preview content
                var previewContainer = document.getElementById('preview-container');
                previewContainer.innerHTML = "Loading...";

                // Use AJAX to fetch the preview content from the server
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Update the preview container with the fetched HTML
                            previewContainer.innerHTML = xhr.responseText;
                        } else {
                            previewContainer.innerHTML = "Error loading preview.";
                        }
                    }
                };
                xhr.open('GET', 'preview.php?reportType=' + reportType, true);
                xhr.send();
            }



            function generateReport() {
                // Ensure the preview container has content before printing
                var previewContainer = document.getElementById('preview-container');
                if (previewContainer.innerHTML.trim() === "" || previewContainer.innerHTML === "Loading...") {
                    alert("Please preview the report before generating it.");
                    return;
                }

                // Open the print dialog for the preview content
                var printWindow = window.open('', '_blank', 'width=800,height=600');
                printWindow.document.write('<html><head><title>Print Report</title></head><body>');
                printWindow.document.write(previewContainer.innerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            }
        </script>
    </div>
</body>

</html>