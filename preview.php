<?php
// preview.php

// Include necessary files (e.g., db_connection.php and any other required files)
include 'db.php';



// Get the selected report type from the query parameters
$reportType = $_GET['reportType'];

// Generate preview content based on the selected report type
$previewContent = '<link rel="stylesheet" href="style.css">'; // Include your CSS file

if ($reportType == 'problem') {
    // Add the print button after the table
    $previewContent .= '<button id="printButton" style="margin-top: 20px; padding: 10px 20px; cursor: pointer;">Print</button>';
    // Fetch data from the database and sort by selection_count in descending order
    $result = mysqli_query($con, "SELECT concern, selection_count FROM aggregated_concerns ORDER BY selection_count DESC");

    // Initialize content for display
    $previewContent = '<h1>Concerns and Selection Counts</h1>';
    $previewContent .= '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    $previewContent .= '<thead>';
    $previewContent .= '<tr>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Concern</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Selection Count</th>';
    $previewContent .= '</tr>';
    $previewContent .= '</thead>';
    $previewContent .= '<tbody>';

    // Loop through the fetched data and populate table rows
    while ($row = mysqli_fetch_assoc($result)) {
        $previewContent .= '<tr>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px;">' . htmlspecialchars($row['concern']) . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . $row['selection_count'] . '</td>';
        $previewContent .= '</tr>';
    }

    $previewContent .= '</tbody>';
    $previewContent .= '</table>';
} elseif ($reportType == 'by_product') {



    // Fetch total count of records
    $totalResult = mysqli_query($con, "SELECT COUNT(religion) AS total FROM user_data");
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalCount = $totalRow['total'];

    // Fetch unique handicapped values and their counts
    $result = mysqli_query($con, "SELECT religion, COUNT(religion) AS count FROM user_data GROUP BY religion");

    // Initialize content for display
    $previewContent = '<h1>Religion Records and Percentages</h1>';
    $previewContent .= '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    $previewContent .= '<thead>';
    $previewContent .= '<tr>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Religion</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Count</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Percentage</th>';
    $previewContent .= '</tr>';
    $previewContent .= '</thead>';
    $previewContent .= '<tbody>';

    // Loop through fetched data
    while ($row = mysqli_fetch_assoc($result)) {
        $handicap = htmlspecialchars($row['religion']);
        $count = $row['count'];
        $percentage = ($totalCount > 0) ? ($count / $totalCount) * 100 : 0;

        $previewContent .= '<tr>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px;">' . $handicap . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . $count . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . number_format($percentage, 2) . '%</td>';
        $previewContent .= '</tr>';
    }

    $previewContent .= '</tbody>';
    $previewContent .= '</table>';
} elseif ($reportType == 'product_inventory') {
    // Fetch total count of records
    $totalResult = mysqli_query($con, "SELECT COUNT(handicapped) AS total FROM user_data");
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalCount = $totalRow['total'];

    // Fetch unique handicapped values and their counts
    $result = mysqli_query($con, "SELECT handicapped, COUNT(handicapped) AS count FROM user_data GROUP BY handicapped");

    // Initialize content for display
    $previewContent = '<h1>Handicapped Records and Percentages</h1>';
    $previewContent .= '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    $previewContent .= '<thead>';
    $previewContent .= '<tr>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Handicap</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Count</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Percentage</th>';
    $previewContent .= '</tr>';
    $previewContent .= '</thead>';
    $previewContent .= '<tbody>';

    // Loop through fetched data
    while ($row = mysqli_fetch_assoc($result)) {
        $handicap = htmlspecialchars($row['handicapped']);
        $count = $row['count'];
        $percentage = ($totalCount > 0) ? ($count / $totalCount) * 100 : 0;

        $previewContent .= '<tr>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px;">' . $handicap . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . $count . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . number_format($percentage, 2) . '%</td>';
        $previewContent .= '</tr>';
    }

    $previewContent .= '</tbody>';
    $previewContent .= '</table>';


    $previewContent .= '</table>';
} elseif ($reportType == 'registered_customers') {

    $totalResult = mysqli_query($con, "SELECT COUNT(parents_marital_status) AS total FROM user_data");
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalCount = $totalRow['total'];

    // Fetch unique handicapped values and their counts
    $result = mysqli_query($con, "SELECT parents_marital_status, COUNT(parents_marital_status) AS count FROM user_data GROUP BY parents_marital_status");

    // Initialize content for display
    $previewContent = '<h1>Parents marital Status Records and Percentages</h1>';
    $previewContent .= '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    $previewContent .= '<thead>';
    $previewContent .= '<tr>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Handicap</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Count</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Percentage</th>';
    $previewContent .= '</tr>';
    $previewContent .= '</thead>';
    $previewContent .= '<tbody>';

    // Loop through fetched data
    while ($row = mysqli_fetch_assoc($result)) {
        $handicap = htmlspecialchars($row['parents_marital_status']);
        $count = $row['count'];
        $percentage = ($totalCount > 0) ? ($count / $totalCount) * 100 : 0;

        $previewContent .= '<tr>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px;">' . $handicap . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . $count . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . number_format($percentage, 2) . '%</td>';
        $previewContent .= '</tr>';
    }

    $previewContent .= '</tbody>';
    $previewContent .= '</table>';


    $previewContent .= '</table>';
} elseif ($reportType == 'all_orders') {

    $totalResult = mysqli_query($con, "SELECT COUNT(birth_order) AS total FROM user_data");
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalCount = $totalRow['total'];

    // Fetch unique handicapped values and their counts
    $result = mysqli_query($con, "SELECT birth_order, COUNT(birth_order) AS count FROM user_data GROUP BY birth_order");

    // Initialize content for display
    $previewContent = '<h1>Birth Of Order Records and Percentages</h1>';
    $previewContent .= '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    $previewContent .= '<thead>';
    $previewContent .= '<tr>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Birth of Order</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Count</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Percentage</th>';
    $previewContent .= '</tr>';
    $previewContent .= '</thead>';
    $previewContent .= '<tbody>';

    // Loop through fetched data
    while ($row = mysqli_fetch_assoc($result)) {
        $handicap = htmlspecialchars($row['birth_order']);
        $count = $row['count'];
        $percentage = ($totalCount > 0) ? ($count / $totalCount) * 100 : 0;

        $previewContent .= '<tr>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px;">' . $handicap . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . $count . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . number_format($percentage, 2) . '%</td>';
        $previewContent .= '</tr>';
    }

    $previewContent .= '</tbody>';
    $previewContent .= '</table>';


    $previewContent .= '</table>';
} elseif ($reportType == 'income') {

    $totalResult = mysqli_query($con, "SELECT COUNT(family_income) AS total FROM user_data");
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalCount = $totalRow['total'];

    // Fetch unique handicapped values and their counts
    $result = mysqli_query($con, "SELECT family_income, COUNT(family_income) AS count FROM user_data GROUP BY family_income");

    // Initialize content for display
    $previewContent = '<h1>Family Income Records and Percentages</h1>';
    $previewContent .= '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    $previewContent .= '<thead>';
    $previewContent .= '<tr>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Birth of Order</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Count</th>';
    $previewContent .= '<th style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;">Percentage</th>';
    $previewContent .= '</tr>';
    $previewContent .= '</thead>';
    $previewContent .= '<tbody>';

    // Loop through fetched data
    while ($row = mysqli_fetch_assoc($result)) {
        $handicap = htmlspecialchars($row['family_income']);
        $count = $row['count'];
        $percentage = ($totalCount > 0) ? ($count / $totalCount) * 100 : 0;

        $previewContent .= '<tr>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px;">' . $handicap . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . $count . '</td>';
        $previewContent .= '<td style="border: 1px solid #ccc; padding: 10px; text-align: center;">' . number_format($percentage, 2) . '%</td>';
        $previewContent .= '</tr>';
    }

    $previewContent .= '</tbody>';
    $previewContent .= '</table>';


    $previewContent .= '</table>';
}

























// Output the preview content
echo $previewContent;

// Close the database connection
mysqli_close($con);
