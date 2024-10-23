<?php
require_once('TCPDF/tcpdf.php');
include 'db.php';

// Create a custom PDF class to include header
class CustomPDF extends TCPDF {
    public function Header() {
        // Set a Y position to create space above the header
        $this->SetY(100); // Adjust this value to add space before the header

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
        $this->SetFont('helvetica', 'B', 10); // Smaller font
        $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
        
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 5, 'Bulacan State University', 0, 1, 'C');
        
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 5, 'SAN RAFAEL CAMPUS', 0, 1, 'C');
        
        $this->SetFont('helvetica', 'I', 9);
        $this->Cell(0, 5, 'Guidance and Counseling Services Center Student Cumulative Record', 0, 1, 'C');
        
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Plaridel By-pass Road, Brgy. San Roque, San Rafael, Bulacan', 0, 1, 'C');
        $this->Cell(0, 5, 'Tel/Fax: (044) 816-3264', 0, 1, 'C');
        
        // Add a horizontal line below the header
        $this->Ln(2); // Line break
        $this->Cell(0, 0, '', 'T'); // Top border line
    }
}

// Get filter variables from the query parameters
$filter_course_section = isset($_GET['course_section']) ? mysqli_real_escape_string($con, $_GET['course_section']) : '';
$filter_birth_order = isset($_GET['birth_order']) ? mysqli_real_escape_string($con, $_GET['birth_order']) : '';
$filter_monthly_income = isset($_GET['monthly_income']) ? mysqli_real_escape_string($con, $_GET['monthly_income']) : '';
$filter_religion = isset($_GET['religion']) ? mysqli_real_escape_string($con, $_GET['religion']) : '';
$filter_number_of_siblings = isset($_GET['number_of_siblings']) ? mysqli_real_escape_string($con, $_GET['number_of_siblings']) : '';
$filter_marriage_status = isset($_GET['marriage_status']) ? mysqli_real_escape_string($con, $_GET['marriage_status']) : '';

// Create the base query
$query = "SELECT * FROM user_data WHERE 1";

if ($filter_course_section && $filter_course_section != 'All') {
    $query .= " AND course_section = '$filter_course_section'";
}
if ($filter_birth_order && $filter_birth_order != 'All') {
    $query .= " AND birth_order = '$filter_birth_order'";
}
if ($filter_monthly_income && $filter_monthly_income != 'All') {
    $query .= " AND family_income = '$filter_monthly_income'";
}
if ($filter_religion && $filter_religion != 'All') {
    $query .= " AND religion = '$filter_religion'";
}
if ($filter_number_of_siblings && $filter_number_of_siblings != 'All') {
    $query .= " AND number_of_siblings = '$filter_number_of_siblings'";
}
if ($filter_marriage_status && $filter_marriage_status != 'All') {
    $query .= " AND marriage_status = '$filter_marriage_status'";
}

$result = mysqli_query($con, $query);
if (!$result) {
    die("Error fetching user data: " . mysqli_error($con));
}

// Create new PDF document
$pdf = new CustomPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Filtered Responses Report');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$top_margin = 50; // Adjust this value for top margin
$pdf->SetMargins(PDF_MARGIN_LEFT, $top_margin, PDF_MARGIN_RIGHT); // Set the margins
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

// Add content to PDF
$html = '<h1 style="font-size: 14px;">Filtered Form Responses</h1>'; // Optional: Reduce the title font size
$html .= '<table border="1" cellpadding="4" style="font-size: 8px; text-align: left;">'; // Set a smaller font size for the entire table
$html .= '<thead style="background-color: #f2f2f2;"><tr>'; // Optional: Set a background color for the header
$html .= '<th style="padding: 4px;">Email</th>';
$html .= '<th style="padding: 4px;">Date & Time</th>';
$html .= '<th style="padding: 4px;">Student Number</th>';
$html .= '<th style="padding: 4px;">Name</th>';
$html .= '<th style="padding: 4px;">Course & Section</th>';
$html .= '<th style="padding: 4px;">Birth Order</th>';
$html .= '<th style="padding: 4px;">Family Income</th>';
$html .= '<th style="padding: 4px;">Religion</th>';
$html .= '<th style="padding: 4px;">No of Siblings</th>';
$html .= '<th style="padding: 4px;">Marriage Status</th>';
$html .= '</tr></thead><tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['email']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['datetime']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['student_number']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['name']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['course_section']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['birth_order']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['family_income']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['religion']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['number_of_siblings']) . '</td>';
    $html .= '<td style="padding: 4px;">' . htmlspecialchars($row['marriage_status']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Add filters below the table
$html .= '<h2>Applied Filters:</h2><ul>';
if ($filter_course_section) {
    $html .= '<li>Course & Section: ' . htmlspecialchars($filter_course_section) . '</li>';
}
if ($filter_birth_order) {
    $html .= '<li>Birth Order: ' . htmlspecialchars($filter_birth_order) . '</li>';
}
if ($filter_monthly_income) {
    $html .= '<li>Monthly Income: ' . htmlspecialchars($filter_monthly_income) . '</li>';
}
if ($filter_religion) {
    $html .= '<li>Religion: ' . htmlspecialchars($filter_religion) . '</li>';
}
if ($filter_number_of_siblings) {
    $html .= '<li>Number of Siblings: ' . htmlspecialchars($filter_number_of_siblings) . '</li>';
}
if ($filter_marriage_status) {
    $html .= '<li>Marriage Status: ' . htmlspecialchars($filter_marriage_status) . '</li>';
}
$html .= '</ul>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF for download
$pdf->Output('filtered_responses_report.pdf', 'D'); // Use 'D' to force download

// Close the database connection
mysqli_close($con);
?>
