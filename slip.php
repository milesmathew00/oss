<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Slip Form</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    width: 70%;
    margin: 50px auto;
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
}  .button-container {
            margin: 20px 0; /* Add margin to separate button from content */
            
        }

        button {

            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color:#211ACA; /* Button color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

.instructions a {
    color: #000;
    text-decoration: none;
} /* Hide the arrow link and print button during printing */
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
                background: none; /* Remove background color */
            }
            .container {
                width: 100%; /* Use full width for printing */
                box-shadow: none; /* Remove shadow */
                border: none; /* Remove border */
                margin: 0; /* Remove margin */
            }
        }
        </style>
</head>
<body>
<div class="no-print">
        <a href="admin_page.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
            <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
                <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
    <div class="container">
    
        <div class="header">
            <div class="logo">
                <img src="images/main.png" alt="University Logo">
            </div>
            <div class="university-details">
                <h2>Republic of the Philippines</h2>
                <h3>Bulacan State University</h3>
                <h4>SAN RAFAEL CAMPUS</h4>
                <h4 style="margin: 5px 0;">Guidance and Counseling Services Center Student Cumulative Record</h4>
                <p>Plaridel By-pass Road, Brgy. San Roque, San Rafael, Bulacan</p>
                <p>Tel/Fax: (044) 816-3264</p>
            </div>
            <div class="logo">
                <img src="images/logo.jpg" alt="University Logo">
            </div>
        </div>
        <h3 class="form-title">Guidance and Counseling Services Center</h3>
        <h4 class="call-slip">CALL SLIP</h4>
        <form>
            <div class="form-group">
                <label for="date">Date: </label>
                <input type="text" id="date" name="date">
            </div>
            <div class="form-group">
                <label for="name">Name: </label>
                <input type="text" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="course">Course and Section: </label>
                <input type="text" id="course" name="course">
                <label for="student-no">Student No.: </label>
                <input type="text" id="student-no" name="student-no">
            </div>
            <div class="form-group">
                <label for="dear">Dear: </label>
                <input type="text" id="dear" name="dear">
            </div>
            <p class="greeting">Peace and all good!</p>
            <p class="message">
                I am requesting you to visit the Guidance and Counseling Services Center on 
                <input type="text" name="visit-date"> at 
                <input type="text" name="time"> for (purpose) 
                <input type="text" name="purpose">.
            </p>
            <p class="instructions">
                Kindly present this call slip when you arrive at the GCSC. If you cannot attend at the specified date and time, please get in touch with us for another appointment at <a href="mailto:bulsu.src.gcsc@gmail.com">bulsu.src.gcsc@gmail.com</a>.
            </p>
            <p class="signature">
                <strong>Christian E. Jordan, RGC</strong><br>
                Guidance Counselor
            </p>
            <div class="form-group">
                <label for="received-by">Received by: </label>
                <input type="text" id="received-by" name="received-by">
            </div>
            <div class="form-group">
                <label for="received-date">Date: </label>
                <input type="text" id="received-date" name="received-date">
            </div>
           
    </div>
    <div class="button-container">
          <center>  <button type="button" onclick="window.print();">Print</button></center>
        </div>
</body>
</html>