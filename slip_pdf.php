<?php
require_once('tcpdf/tcpdf.php'); // Include TCPDF

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $date = $_POST['date'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $student_no = $_POST['student-no'];
    $dear = $_POST['dear'];
    $visit_date = $_POST['visit-date'];
    $time = $_POST['time'];
    $purpose = $_POST['purpose'];
    $received_by = $_POST['received-by'];
    $received_date = $_POST['received-date'];

    // Create a new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Remove default header and footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Call Slip');
    $pdf->SetSubject('Call Slip Form');
    
    // Set margins
    $pdf->SetMargins(15, 15, 15);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add content with styles
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .container {
                width: 100%;
                margin: 0 auto;
                background-color: white;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 8px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }
            .header {
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .logo img {
                height: 80px;
                margin-right: 20px;
            }
            .university-details {
                text-align: center;
            }
            .university-details h2, .university-details h3, .university-details h4, .university-details p {
                margin: 3px 0;
            }
            .form-title {
                text-align: center;
                text-decoration: underline;
                margin-top: 20px;
            }
            .call-slip {
                text-align: center;
                font-weight: bold;
            }
            .form-group {
                margin: 10px 0;
            }
            label {
                font-weight: bold;
            }
            input[type="text"] {
                border: none;
                border-bottom: 1px solid #000;
                width: 200px;
                margin-left: 10px;
                padding: 5px;
                font-size: 14px;
            }
            .greeting {
                margin: 20px 0 5px;
                font-weight: bold;
            }
            .message, .instructions, .signature {
                margin: 10px 0;
            }
            .signature {
                margin-top: 30px;
            }
            .signature strong {
                font-size: 16px;
            }
            .instructions a {
                color: #000;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo">
                    <img src="images/main.png" alt="University Logo">
                </div>
                <div class="university-details">
                    <h2>Republic of the Philippines</h2>
                    <h3>Bulacan State University</h3>
                    <h4>SAN RAFAEL CAMPUS</h4>
                    <p>Plaridel By-pass Road, Brgy. San Roque, San Rafael, Bulacan</p>
                    <p>Tel/Fax: (044) 816-3264</p>
                </div>
                <div class="logo">
                    <img src="images/logo.jpg" alt="University Logo">
                </div>
            </div>
            <h3 class="form-title">Guidance and Counseling Services Center</h3>
            <h4 class="call-slip">CALL SLIP</h4>
            <div class="form-group">
                <label>Date: </label> ' . htmlspecialchars($date) . '
            </div>
            <div class="form-group">
                <label>Name: </label> ' . htmlspecialchars($name) . '
            </div>
            <div class="form-group">
                <label>Course and Section: </label> ' . htmlspecialchars($course) . ' <label>Student No.: </label> ' . htmlspecialchars($student_no) . '
            </div>
            <div class="form-group">
                <label>Dear: </label> ' . htmlspecialchars($dear) . '
            </div>
            <p class="greeting">Peace and all good!</p>
            <p class="message">
                I am requesting you to visit the Guidance and Counseling Services Center on 
                <strong>' . htmlspecialchars($visit_date) . '</strong> at 
                <strong>' . htmlspecialchars($time) . '</strong> for <strong>' . htmlspecialchars($purpose) . '</strong>.
            </p>
            <p class="instructions">
                Kindly present this call slip when you arrive at the GCSC. If you cannot attend at the specified date and time, please get in touch with us for another appointment at <a href="mailto:bulsu.src.gcsc@gmail.com">bulsu.src.gcsc@gmail.com</a>.
            </p>
            <p class="signature">
                <strong>Christian E. Jordan, RGC</strong><br>
                Guidance Counselor
            </p>
            <div class="form-group">
                <label>Received by: </label> ' . htmlspecialchars($received_by) . '
            </div>
            <div class="form-group">
                <label>Date: </label> ' . htmlspecialchars($received_date) . '
            </div>
        </div>
    </body>
    </html>';

    // Write the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Output the PDF
    $pdf->Output('call_slip.pdf', 'I'); // 'I' sends the PDF inline to the browser
}
?>
