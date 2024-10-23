<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miles";
$port = 3306;

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from user_data
$sql = "SELECT * FROM user_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Store the results in an array
    $userData = [];
    while ($row = $result->fetch_assoc()) {
        $userData[] = $row;
    }
} else {
    $userData = []; // Initialize to an empty array if no records found
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student's Information Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            font-size: 10px; /* Adjusted font size for better fit */
        }
        .container {
            width: 100%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 5px; /* Reduced padding to maximize space */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 5px;
        }
        .header img {
            width: 80px; /* Reduced logo size */
        }
        .header h1, .header h2 {
            color: #006633;
            margin: 0;
            font-size: 14px; /* Adjusted font size */
        }
        .section-title {
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: 12px; /* Adjusted font size */
        }
        .form-group {
            margin-bottom: 3px; /* Reduced margin */
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 2px; /* Adjusted padding */
            border: 1px solid #000;
            font-size: 10px; /* Font size for input fields */
        }
        .form-group-inline {
            display: flex;
            justify-content: space-between;
        }
        .form-group-inline .form-group {
            flex: 1;
            margin-right: 3px; /* Reduced margin */
        }
        .form-group-inline .form-group:last-child {
            margin-right: 0;
        }
        .photo {
            width: 150px;
            height: 200px;
            border: 1px solid #000;
            margin: 5px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px; /* Adjusted font size for photo placeholder */
        }
        .semester {
            text-align: center;
            margin-bottom: 5px;
            font-size: 12px; /* Adjusted font size for semester info */
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 2px; /* Adjusted padding */
            text-align: left;
            font-size: 10px; /* Font size for table */
        }
        .table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 5px;
            font-size: 8px; /* Smaller footer text */
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img alt="Baliuag University Logo" height="100" src="https://storage.googleapis.com/a1aa/image/feyBd5yzHJmlP0czRuNRPjhkWvisS0JIdTOD6jbwr2XFaxmTA.jpg" width="80"/>
            <h1>BALIUAG UNIVERSITY</h1>
            <h2>CENTER FOR CAREER AND COUNSELING</h2>
            <p>CCC Form 1A</p>
        </div>
        
        <h2 class="section-title">STUDENT'S INFORMATION RECORD</h2>
        <p>Note: Please PRINT legibly all information asked for. Data contained in this form will be kept confidential. Please fill in the blanks carefully and sincerely. Write NA if not applicable.</p>
        
        <h3 class="section-title">PERSONAL DATA</h3>
        <div class="form-group-inline">
            <div class="form-group">
                <label for="student-number">Student #:</label>
                <input id="student-number" name="student-number" type="text" />
            </div>
            <div class="form-group">
                <label for="course-year">Course and Year:</label>
                <input id="course-year" name="course-year" type="text" />
            </div>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input id="name" name="name" placeholder="Surname First Name Middle Name" type="text" />
        </div>
        <div class="form-group-inline">
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input id="nickname" name="nickname" type="text" />
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input id="dob" name="dob" type="date" />
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input id="age" name="age" type="number" />
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input id="gender" name="gender" type="text" />
            </div>
        </div>
        <div class="form-group-inline">
            <div class="form-group">
                <label for="birth-order">Birth Order among Siblings:</label>
                <input id="birth-order" name="birth-order" type="text" />
            </div>
            <div class="form-group">
                <label for="religion-birth">Religion from Birth:</label>
                <input id="religion-birth" name="religion-birth" type="text" />
            </div>
            <div class="form-group">
                <label for="current-religion">Current Religion:</label>
                <input id="current-religion" name="current-religion" type="text" />
            </div>
        </div>
        <div class="form-group">
            <label for="home-address">Home Address:</label>
            <input id="home-address" name="home-address" type="text" />
        </div>
        <div class="form-group-inline">
            <div class="form-group">
                <label for="tel-no">Tel. No.:</label>
                <input id="tel-no" name="tel-no" type="text" />
            </div>
        </div>

        <div class="photo">PHOTO</div>

        <div class="semester">
            <p>School Year 20 _ - 20 ___</p>
            <p>1<sup>st</sup> Semester / 2<sup>nd</sup> Semester / Summer</p>
        </div>
        
        <h2 class="section-title">CO-CURRICULAR ACTIVITIES</h2>
        <div class="form-group">
            <label>Special Skills / Talents:</label>
            <input type="text" />
        </div>
        <div class="form-group">
            <label>Hobbies / Recreational Activities:</label>
            <input type="text" />
        </div>
        <div class="form-group">
            <label>Ambitions / Goals:</label>
            <input type="text" />
        </div>
        <div class="form-group">
            <label>Motto in Life:</label>
            <input type="text" />
        </div>
        <div class="form-group">
            <label>Characteristics that describe you best:</label>
            <input type="text" />
        </div>
        
        <h2 class="section-title">EDUCATIONAL INFORMATION</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name of School</th>
                    <th>Inclusive Dates</th>
                    <th>Honors/Awards Received</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Elementary School:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Junior High School:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Senior High School:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>College:</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <h2 class="section-title">FAMILY INFORMATION</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Relation</th>
                    <th>Name</th>
                    <th>Occupation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Father:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Mother:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Guardian:</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <h2 class="section-title">ADDITIONAL INFORMATION</h2>
        <div class="form-group">
            <label>How did you learn about this program?</label>
            <input type="text" />
        </div>

        <div class="footer">
            <p>To the best of my knowledge, the information given in this form is true and correct.</p>
            <p>__________________________</p>
            <p>Signature over Printed Name</p>
            <p>Date: _______________</p>
        </div>
    </div>
</body>
</html>
