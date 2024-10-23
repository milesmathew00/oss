<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miles";
$port = 3306;

$con = new mysqli($servername, $username, $password, $dbname, $port);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Update SQL query to join user table and get profile_picture
    $stmt = $con->prepare("SELECT ud.*, u.profile_picture FROM user_data ud JOIN user u ON ud.user_id = u.user_id WHERE ud.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Extract data
        $profile_picture = htmlspecialchars($row['profile_picture']);
        $student_number = htmlspecialchars($row['student_number']);
        $name = htmlspecialchars($row['name']);
        // Add other fields as needed

        // Output the HTML
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Student Profile</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    font-size: 10px; /* Reduce font size */
                    background-color: #f9f9f9;
                }
                h1, h2 {
                    color: #333;
                }
                .container {
                    max-width: 800px;
                    margin: auto;
                    padding: 20px;
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    


                }
                .data-grid {    
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                }
                .data-item {
                    padding: 8px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }
                 img.profile-picture {
    width: 80px; /* Decreased size */
    height: auto; 
    border-radius: 50%; /* Makes the image circular */
    margin: 10px; /* Adds space around the image */
}
                .profile-header {
                    display: flex;
                    align-items: center; /* Center items vertically */
                    justify-content: flex-start; /* Align to the start */
                    margin-bottom: 20px; /* Space below the header */
                    
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                    
         @media print {
    body {
        margin: 0; /* Remove body margin */
    }
    .container {
        border: 2px solid black; /* New border for printed pages */
        border-radius: 8px; /* Keep rounded corners */
        page-break-after: always; /* Force a page break after each container */
        padding: 20px; /* Keep padding inside the container */
    }
    button {
        display: none; /* Hide buttons during print */
    }
}

            </style>
    
        </head>
        <body>
            <div class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                <div class="logo" style="flex: 1; text-align: center;">
                    <img src="images/main.png" alt="University Logo" style="max-width: 100px; height: auto;"> <!-- First Logo -->
                </div>
                <div class="university-details" style="flex: 2; text-align: center;">
                    <h2 style="margin: 5px 0;">Republic of the Philippines</h2>
                    <h3 style="margin: 5px 0;">Bulacan State University</h3>
                    <h4 style="margin: 5px 0;">SAN RAFAEL CAMPUS</h4>
                    <h4 style="margin: 5px 0;">Guidance and Counseling Services Center Student Cumulative Record</h4>
                    <p style="margin: 5px 0;">Plaridel By-pass Road, Brgy. San Roque, San Rafael, Bulacan</p>
                    <p style="margin: 5px 0;">Tel/Fax: (044) 816-3264</p>
                </div>
                <div class="logo" style="flex: 1; text-align: center;">
                    <img src="images/logo.jpg" alt="University Logo" style="max-width: 100px; height: auto;"> <!-- Second Logo -->
                </div>
            </div>
            <hr>

            <!-- Existing content -->
                  <div class="container">
                <div class="profile-header">
                    <!-- Display Profile Picture -->
                    <img src="images/' . $profile_picture . '" alt="Profile Picture" class="profile-picture">
                    <h1 style="margin-left: 20px;">Student Profile</h1> <!-- Adjust margin for spacing -->
                </div>
                
                <div class="data-grid">
                    <div class="data-item"><strong>Student #:</strong></div>
                    <div class="data-item">' . $student_number . '</div>
                    <div class="data-item"><strong>Name:</strong></div>
                    <div class="data-item">' . $name . '</div>
                    <div class="data-item"><strong>Nickname:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['nickname']) . '</div>
                    <div class="data-item"><strong>Contact Number:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['mobile_number']) . '</div>
                    <div class="data-item"><strong>Birth Date:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['dob']) . '</div>
                    <div class="data-item"><strong>Sex At Birth:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['sex_at_birth']) . '</div>
                    <div class="data-item"><strong>Gender Identity:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['gender_identity']) . '</div>
                    <div class="data-item"><strong>Age:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['age']) . '</div>
                    <div class="data-item"><strong>Place Of Birth:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['place_of_birth']) . '</div>
                    <div class="data-item"><strong>Religion:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['religion']) . '</div>
                    <div class="data-item"><strong>Civil Status:</strong></div>
                    <div class="data-item">' . htmlspecialchars($row['civil_status']) . '</div>
                </div>

                <!-- Other Information Partition -->
                <div class="partition">
                    <h4>Other Information</h4>
                    <div class="data-grid">
                        <div class="data-item"><strong>Handicapped Status:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['handicapped']) . '</div>
                        <div class="data-item"><strong>Emergency Contact:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['emergency_contact']) . '</div>
                        <div class="data-item"><strong>Relation:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['relation_to_emergency_contact']) . '</div>
                        <div class="data-item"><strong>Emergency Contact Number:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['emergency_contact_number']) . '</div>
                        <div class="data-item"><strong>Special Skills:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['special_skills']) . '</div>
                        <div class="data-item"><strong>Hobbies:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['hobbies']) . '</div>
                        <div class="data-item"><strong>Ambition:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['ambition']) . '</div>
                        <div class="data-item"><strong>Motto:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['motto']) . '</div>
                        <div class="data-item"><strong>Characteristics:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['characteristics']) . '</div>
                        <div class="data-item"><strong>Influence:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['influence']) . '</div>
                        <div class="data-item"><strong>Concern:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['concern']) . '</div>
                    </div>
                </div>

                <!-- Family Background Partition -->
                <div class="partition">
                    <h4>Family Background</h4>
                    <table class="family-table">
                        <tr>
                            <th>Relation</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Education</th>
                            <th>Occupation</th>
                            <th>Company</th>
                        </tr>
                        <tr>
                            <td>Father</td>
                            <td>' . htmlspecialchars($row['fathers_name']) . '</td>
                            <td>' . htmlspecialchars($row['fathers_dob']) . '</td>
                            <td>' . htmlspecialchars($row['fathers_education']) . '</td>
                            <td>' . htmlspecialchars($row['fathers_occupation']) . '</td>
                            <td>' . htmlspecialchars($row['fathers_company']) . '</td>
                        </tr>
                        <tr>
                            <td>Mother</td>
                            <td>' . htmlspecialchars($row['mothers_maiden_name']) . '</td>
                            <td>' . htmlspecialchars($row['mothers_dob']) . '</td>
                            <td>' . htmlspecialchars($row['mothers_education']) . '</td>
                            <td>' . htmlspecialchars($row['mothers_occupation']) . '</td>
                            <td>' . htmlspecialchars($row['mothers_company']) . '</td>
                        </tr>
                    </table>
                </div>
                 </table>
                    <div class="data-grid">
                        <div class="data-item"><strong>Family Income:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['family_income']) . '</div>
                        <div class="data-item"><strong>Marital Status:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['parents_marital_status']) . '</div>
                        <div class="data-item"><strong>Spouse Name:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['spouse_name']) . '</div>
                        <div class="data-item"><strong>Spouse DOB:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['spouse_dob']) . '</div>
                        <div class="data-item"><strong>Spouse Education:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['spouse_education']) . '</div>
                        <div class="data-item"><strong>Spouse Occupation:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['spouse_occupation']) . '</div>
                        <div class="data-item"><strong>Spouse Company:</strong></div>
                        <div class="data-item">' . htmlspecialchars($row['spouse_company']) . '</div>
                    </div>
                 <!-- Educational Background Partition -->
                <div class="partition">
                    <h4>Educational Background</h4>
<table class="education-table" style="width: 100%; table-layout: auto;">
    <tr>
        <th>Educational Level/School Name</th>
        <th>Type</th>
        <th>Years Attended</th>
        <th>Awards</th>
    </tr>
    <tr>
        <td>Elementary: ' . htmlspecialchars($row['elem_school']) . '</td>
        <td>' . htmlspecialchars($row['elem_type']) . '</td>
        <td>' . htmlspecialchars($row['elem_years']) . '</td>
        <td>' . htmlspecialchars($row['elem_awards']) . '</td>
    </tr>
    <tr>
        <td>Junior High: ' . htmlspecialchars($row['junior_high_school']) . '</td>
        <td>' . htmlspecialchars($row['junior_type']) . '</td>
        <td>' . htmlspecialchars($row['junior_years']) . '</td>
        <td>' . htmlspecialchars($row['junior_awards']) . '</td>
    </tr>
    <tr>
        <td>Senior High: ' . htmlspecialchars($row['senior_high_school']) . '</td>
        <td>' . htmlspecialchars($row['senior_type']) . '</td>
        <td>' . htmlspecialchars($row['senior_years']) . '</td>
        <td>' . htmlspecialchars($row['senior_awards']) . '</td>
    </tr>
    <tr>
        <td>College: ' . htmlspecialchars($row['college_course']) . '</td>
        <td>' . htmlspecialchars($row['college_type']) . '</td>
        <td>' . htmlspecialchars($row['college_years']) . '</td>
        <td>' . htmlspecialchars($row['college_awards']) . '</td>
    </tr>
</table>
 <!-- Print and Back Buttons -->
   <div style="margin-top: 20px;">
    <button 
        onclick="window.print();" 
        style="padding: 10px 15px; cursor: pointer; margin-top: 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; transition: background-color 0.3s;">
        Print Profile
    </button>
    <button 
        onclick="window.history.back()" 
        style="padding: 10px 15px; cursor: pointer; background-color: #6c757d; color: white; border: none; border-radius: 5px; transition: background-color 0.3s; margin-left: 10px;">
        Back
    </button>
</div>

            </div>
            
        </body>
        </html>';
    } else {
        echo "No record found.";
    }
    $stmt->close();
} else {
    echo "No ID specified.";
}
$con->close();
?>
