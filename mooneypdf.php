<?php
require_once('TCPDF/tcpdf.php'); // Adjust the path to your TCPDF library

include 'db.php'; // Include your database connection

// Extend TCPDF to create a custom header
class CustomPDF extends TCPDF {
    public function Header() {
        // Left logo
        $left_logo = 'images/main.png'; // Path to the left logo
        if (file_exists($left_logo)) {
            $this->Image($left_logo, 10, 10, 25); // Adjust size and position
        }

        // Right logo
        $right_logo = 'images/logo.jpg'; // Path to the right logo
        if (file_exists($right_logo)) {
            $this->Image($right_logo, 175, 10, 25); // Adjust size and position
        }

        // Centered header text
        $this->SetY(15); // Set Y position for center text
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
        
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 5, 'Bulacan State University', 0, 1, 'C');
        
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 5, 'SAN RAFAEL CAMPUS', 0, 1, 'C');
        
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 5, 'Guidance and Counseling Services Center Student Cumulative Record', 0, 1, 'C');
        
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'Plaridel By-pass Road, Brgy. San Roque, San Rafael, Bulacan', 0, 1, 'C');
        $this->Cell(0, 5, 'Tel/Fax: (044) 816-3264', 0, 1, 'C');
        
        // Add a horizontal line below the header
        $this->Ln(2); // Line break
        $this->Cell(0, 0, '', 'T'); // Top border line
    }
}

// Initialize filter variables from GET request
$filter_course_section = isset($_GET['course_section']) ? $_GET['course_section'] : 'All';
$filter_year_level = isset($_GET['year_level']) ? $_GET['year_level'] : 'N/A'; // Add year level filter

// Create new PDF document
$pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name'); // Change to your name or application's name
$pdf->SetTitle('Top Concerns Report');

// Set margins to reduce unused space
$pdf->SetMargins(10, 50, 10); // Increase top margin to fit custom header
$pdf->SetAutoPageBreak(TRUE, 10);

// Set font to a smaller size for fitting content
$pdf->SetFont('helvetica', '', 9);

// Add a page
$pdf->AddPage();

// Prepare the HTML content with smaller font size and condensed tables
$html = '<h1 style="font-size:12px;">Top Concerns Report</h1>';
$html .= '<h2 style="font-size:10px;">Course Section: ' . htmlspecialchars($filter_course_section) . '</h2>';
$html .= '<h2 style="font-size:10px;">Year Level: ' . htmlspecialchars($filter_year_level) . '</h2>'; // Display year level

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

$result_top_20 = mysqli_query($con, $query_top_20);

// Check for query execution errors
if (!$result_top_20) {
    die("Query failed for Top 20 concerns: " . mysqli_error($con));
}

// Prepare HTML for Top 20 Concerns
$html .= '<h2 style="font-size:10px;">Most Common Top 20 Concerns</h2>';
$html .= '<table border="1" cellpadding="2" cellspacing="0" style="font-size:9px;">';
$html .= '<tr><th>Concern</th><th>Selection Count</th></tr>';
while ($row = mysqli_fetch_assoc($result_top_20)) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['concern']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['selection_count']) . '</td>';
    $html .= '</tr>';
}
$html .= '</table>';

// Query for Top 5 Concerns
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

$result_top_5 = mysqli_query($con, $query_top_5);

// Check for query execution errors
if (!$result_top_5) {
    die("Query failed for Top 5 concerns: " . mysqli_error($con));
}

// Prepare HTML for Top 5 Concerns
$html .= '<h2 style="font-size:10px;">Most Common Top 5 Concerns</h2>';
$html .= '<table border="1" cellpadding="2" cellspacing="0" style="font-size:9px;">';
$html .= '<tr><th>Concern</th><th>Selection Count</th></tr>';
while ($row = mysqli_fetch_assoc($result_top_5)) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['concern']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['selection_count']) . '</td>';
    $html .= '</tr>';
}
$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF as single page
$pdf->Output('top_concerns_report.pdf', 'I');

// Close the database connection
mysqli_close($con);
?>
    