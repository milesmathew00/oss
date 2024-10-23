<?php
require_once('tcpdf/tcpdf.php');
include 'db.php';

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
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Filtered Responses Report');
$pdf->SetHeaderData('', 0, 'Filtered Responses Report', 'Filters Applied');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

// Add content to PDF
$html = '<h1>Filtered Form Responses</h1>';
$html .= '<table border="1" cellpadding="4"><thead><tr>';
$html .= '<th>ID</th><th>Email</th><th>Date & Time</th>';
$html .= '<th>Student Number</th><th>Name</th><th>Course & Section</th>';
$html .= '<th>Birth Order</th><th>Family Income</th>';
$html .= '<th>Religion</th><th>No of Siblings</th>';
$html .= '<th>Marriage Status</th></tr></thead><tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['datetime']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['student_number']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['course_section']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['birth_order']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['family_income']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['religion']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['number_of_siblings']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['marriage_status']) . '</td>';
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
