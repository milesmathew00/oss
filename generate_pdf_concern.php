<?php
require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF(TCPDF_UNIT_MM, TCPDF_PAGE_FORMAT_A4, TCPDF_ORIENTATION_PORTRAIT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Top Concerns Report');
$pdf->SetSubject('Top Concerns');

// Set default header data
$pdf->SetHeaderData('', 0, 'Top Concerns Report', 'Generated on: ' . date('Y-m-d'));

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(10, 10, 10); // Adjust margins to fit content on one page
$pdf->SetAutoPageBreak(TRUE, 10); // Allow automatic page breaks
$pdf->AddPage();

// Fetch data from the database
include 'db.php'; // Include your database connection file

// Get the course section from the GET parameters
$filter_course_section = isset($_GET['course_section']) ? $_GET['course_section'] : 'All';

// Query for Top 20 Concerns
$query_top_20 = "SELECT ac.concern, COUNT(DISTINCT s.user_id) AS selection_count 
                 FROM aggregated_concerns ac 
                 JOIN selections s ON FIND_IN_SET(ac.concern, s.top_20) > 0
                 WHERE 1=1";

if ($filter_course_section != 'All') {
    $query_top_20 .= " AND s.course_section = '" . mysqli_real_escape_string($con, $filter_course_section) . "'";
}

$query_top_20 .= " GROUP BY ac.concern 
                   ORDER BY selection_count DESC 
                   LIMIT 20";

// Execute the Top 20 query
$result_top_20 = mysqli_query($con, $query_top_20);

// Prepare HTML content for the PDF
$html = '<h2>Most Common Top 20 Concerns for Course Section: ' . htmlspecialchars($filter_course_section) . '</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Concern</th><th>Selection Count</th></tr>';

while ($row = mysqli_fetch_assoc($result_top_20)) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['concern']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['selection_count']) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Add content for Top 5 Concerns
$query_top_5 = "SELECT ac.concern, COUNT(DISTINCT s.user_id) AS selection_count 
                FROM aggregated_concerns ac 
                JOIN selections s ON FIND_IN_SET(ac.concern, s.top_5) > 0
                WHERE 1=1";

if ($filter_course_section != 'All') {
    $query_top_5 .= " AND s.course_section = '" . mysqli_real_escape_string($con, $filter_course_section) . "'";
}

$query_top_5 .= " GROUP BY ac.concern 
                  ORDER BY selection_count DESC 
                  LIMIT 5";

// Execute the Top 5 query
$result_top_5 = mysqli_query($con, $query_top_5);

// Add content for Top 5 Concerns to PDF
$html .= '<h2>Most Common Top 5 Concerns for Course Section: ' . htmlspecialchars($filter_course_section) . '</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Concern</th><th>Selection Count</th></tr>';

while ($row = mysqli_fetch_assoc($result_top_5)) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['concern']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['selection_count']) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF as a downloadable file
$pdf->Output('top_concerns_report.pdf', 'D');

// Close the database connection
mysqli_close($con);
?>
