<?php
require_once('TCPDF/tcpdf.php'); // Ensure you have the TCPDF library

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

// Create a new PDF document
$pdf = new CustomPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('User Selections PDF');
$pdf->SetMargins(15, 40, 15); // Set margins
$pdf->SetAutoPageBreak(TRUE, 15); // Enable auto page breaks
$pdf->AddPage(); // Add a page

// Database connection
include 'db.php';

// Get the user_id from POST data
$user_id = $_POST['user_id'];

// Fetch the user's selections from the database
$query = "SELECT user.first_name, user.last_name, selections.top_20, selections.top_5
          FROM user
          JOIN selections ON user.user_id = selections.user_id
          WHERE user.user_id = '$user_id'";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "<p>Error in query: " . mysqli_error($con) . "</p>";
    exit;
}

$row = mysqli_fetch_assoc($result);

if ($row) {
    // Add content to the PDF
    $pdf->SetFont('helvetica', 'B', 12);
    
    // Add vertical space before the selections title
    $pdf->Ln(10); // Add vertical space (10 units)
    
    $pdf->Cell(0, 10, 'Selections for ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']), 0, 1, 'C');
    
    // Set column widths
    $col1_width = 95; // Width for Top 20 Concerns
    $col2_width = 95; // Width for Top 5 Concerns

    // Top 20 Concerns
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell($col1_width, 10, 'Top 20 Concerns', 0, 0);
    $pdf->Cell($col2_width, 10, 'Top 5 Concerns', 0, 1);

    // Top 20 Concerns
    $pdf->SetFont('helvetica', '', 9);
    $top_20 = explode(",", $row['top_20']);
    $top_5 = explode(",", $row['top_5']);

    // Calculate the maximum number of lines to display
    $max_lines = max(count($top_20), count($top_5));

    // Create cells for Top 20 and Top 5 Concerns
    for ($i = 0; $i < $max_lines; $i++) {
        // Top 20 Concern
        $concern_20 = isset($top_20[$i]) ? htmlspecialchars($top_20[$i]) : '';
        $pdf->Cell($col1_width, 10, $concern_20, 0, 0);

        // Top 5 Concern
        $concern_5 = isset($top_5[$i]) ? htmlspecialchars($top_5[$i]) : '';
        $pdf->Cell($col2_width, 10, $concern_5, 0, 1);
    }

    // Output the PDF document
    $pdf->Output('user_selections.pdf', 'D'); // D for download
} else {
    echo "<p>No selections found for this user.</p>";
}
?>
