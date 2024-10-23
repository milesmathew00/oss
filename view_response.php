<?php
session_start();

include 'db.php';

// Fetch individual response data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the query
    $query = "SELECT * FROM user_data WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("No record found with ID: " . htmlspecialchars($id));
    }

    $row = $result->fetch_assoc();
} else {
    die("No ID provided.");
}
$id = $_GET['id']; // Assuming you're getting the id from the previous page
$result = $con->query("SELECT * FROM user_data WHERE id = " . intval($id));

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "No user found.";
}
// Close the connection after all queries are done
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Response</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #211ACA;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>View Response</h1>
    </header>
    <a href="cumulative_records.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Outer circle -->
        <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
        <!-- Inner arrow shape -->
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>
        

    <div class="container">
    <a href="pdf.php?id=<?php echo htmlspecialchars($user_data['id']); ?>">View Record To Print</a>
        <h1>Response Details</h1>

        
        <div class="form-group">
            <label for="email">Email:</label>
            <p><?php echo htmlspecialchars($row['email']); ?></p>
        </div>
        <div class="form-group">
            <label for="datetime">Date & Time Accomplished:</label>
            <p><?php echo htmlspecialchars($row['datetime']); ?></p>
        </div>
        <div class="form-group">
            <label for="student_number">Student Number:</label>
            <p><?php echo htmlspecialchars($row['student_number']); ?></p>
        </div>
        <div class="form-group">
            <label for="name">Name (Surname, Given Name, MI):</label>
            <p><?php echo htmlspecialchars($row['name']); ?></p>
        </div>
        <div class="form-group">
            <label for="nickname">Nickname:</label>
            <p><?php echo htmlspecialchars($row['nickname']); ?></p>
        </div>
        <div class="form-group">
            <label for="course_section">Course & Section:</label>
            <p><?php echo htmlspecialchars($row['course_section']); ?></p>
        </div>
        <div class="form-group">
            <label for="mobile_number">Mobile Number:</label>
            <p><?php echo htmlspecialchars($row['mobile_number']); ?></p>
        </div>
        <div class="form-group">
            <label for="sex_at_birth">Sex at Birth :</label>
            <p><?php echo htmlspecialchars($row['sex_at_birth']); ?></p>
        </div>
        <div class="form-group">
            <label for="gender_identity">To which gender identity do you most identify :</label>
            <p><?php echo htmlspecialchars($row['gender_identity']); ?></p>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <p><?php echo htmlspecialchars($row['dob']); ?></p>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <p><?php echo htmlspecialchars($row['age']); ?></p>
        </div>
        <div class="form-group">
            <label for="place_of_birth">Place of Birth:</label>
            <p><?php echo htmlspecialchars($row['place_of_birth']); ?></p>
        </div>
        <div class="form-group">
            <label for="religion">Religion:</label>
            <p><?php echo htmlspecialchars($row['religion']); ?></p>
        </div>
        <div class="form-group">
            <label for="civil_status">Civil Status :</label>
            <p><?php echo htmlspecialchars($row['civil_status']); ?></p>
        </div>
        <div class="form-group">
            <label for="permanent_address">Permanent Address:</label>
            <p><?php echo htmlspecialchars($row['permanent_address']); ?></p>
        </div>
        <div class="form-group">
            <label for="present_address">Present Address:</label>
            <p><?php echo htmlspecialchars($row['present_address']); ?></p>
        </div>
        <div class="form-group">
            <label for="living_status">In your present address, your living:</label>
            <p><?php echo htmlspecialchars($row['living_status']); ?></p>
        </div>
        <div class="form-group">
    <label for="employed">Employed or Working (Yes, No):</label>
    <p><?php echo htmlspecialchars($row['employed']); ?></p>
</div>
        <div class="form-group">
            <label for="company_name">If yes, what is the name of your company?</label>
            <p><?php echo htmlspecialchars($row['company_name']); ?></p>
        </div>
        <div class="form-group">
            <label for="job_title">Job Title/Position:</label>
            <p><?php echo htmlspecialchars($row['job_title']); ?></p>
        </div>
        <div class="form-group">
    <label for="handicapped">Any Common Handicapped, Ailment, or Problem:</label>
    <p><?php echo htmlspecialchars($row['handicapped']); ?></p>
</div>
        <div class="form-group">
            <label for="emergency_contact">In case of emergency, please notify:</label>
            <p><?php echo htmlspecialchars($row['emergency_contact']); ?></p>
        </div>
        <div class="form-group">
            <label for="relation_to_emergency_contact">How is he/she related to you?</label>
            <p><?php echo htmlspecialchars($row['relation_to_emergency_contact']); ?></p>
        </div>
        <div class="form-group">
            <label for="emergency_contact_number">His/Her Contact Number:</label>
            <p><?php echo htmlspecialchars($row['emergency_contact_number']); ?></p>
        </div>
        <div class="form-group">
    <label for="birth_order">Birth Order:</label>
    <p><?php echo htmlspecialchars($row['birth_order']); ?></p>
</div>
        <div class="form-group">
            <label for="number_of_siblings">Number of Siblings:</label>
            <p><?php echo htmlspecialchars($row['number_of_siblings']); ?></p>
        </div>
        <div class="form-group">
            <label for="parents_marital_status">Marital Status of Parents :</label>
            <p><?php echo htmlspecialchars($row['parents_marital_status']); ?></p>
        </div>
        <div class="form-group">
            <label for="fathers_name">Father's Name:</label>
            <p><?php echo htmlspecialchars($row['fathers_name']); ?></p>
        </div>
        <div class="form-group">
            <label for="fathers_dob">Father's Date of Birth:</label>
            <p><?php echo htmlspecialchars($row['fathers_dob']); ?></p>
        </div>
        <div class="form-group">
            <label for="fathers_age">Father's Age:</label>
            <p><?php echo htmlspecialchars($row['fathers_age']); ?></p>
        </div>
        <div class="form-group">
            <label for="fathers_education">Father's Highest Educational Attainment :</label>
            <p><?php echo htmlspecialchars($row['fathers_education']); ?></p>
        </div>
        <div class="form-group"> <label for="fathers_occupation">Father's Occupation:</label> 
        <p><?php echo htmlspecialchars($row['fathers_occupation']); ?></p> </div>

        <div class="form-group"> <label for="fathers_company">Father's Company:</label> 
        <p><?php echo htmlspecialchars($row['fathers_company']); ?></p> </div>

 

 <div class="form-group"> <label for="mothers_maiden_name">Mother's Name:</label> 
 <p><?php echo htmlspecialchars($row['mothers_maiden_name']); ?></p> </div> 

 <div class="form-group"> <label for="mothers_dob">Mother's Date of Birth:</label> 
 <p><?php echo htmlspecialchars($row['mothers_dob']); ?></p> </div> 

 <div class="form-group"> <label for="mothers_age">Mother's Age:</label> 
 <p><?php echo htmlspecialchars($row['mothers_age']); ?></p> </div> 

 <div class="form-group"> <label for="mothers_education">Mother's Highest Educational Attainment :</label> 
 <p><?php echo htmlspecialchars($row['mothers_education']); ?></p> </div> 

 <div class="form-group"> <label for="mothers_occupation">Mother's Occupation:</label> 
 <p><?php echo htmlspecialchars($row['mothers_occupation']); ?></p> </div>
 
 <div class="form-group"> <label for="mothers_company">Mother's Company:</label> 
        <p><?php echo htmlspecialchars($row['mothers_company']); ?></p> </div>

        <div class="form-group">
    <label for="family_income">Family Monthly Income:</label>
    <p><?php echo htmlspecialchars($row['family_income']); ?></p>
</div>

 <div class="form-group"> <label for="marriage_status">Marriage Status:</label> 
 <p><?php echo htmlspecialchars($row['marriage_status']); ?></p> </div> 


 <div class="form-group"> <label for="spouse_name">Name of Spouse:</label> 
 <p><?php echo htmlspecialchars($row['spouse_name']); ?></p> </div>

 <div class="form-group"> <label for="spouse_dob">Date of Birth of Spouse:</label> 
 <p><?php echo htmlspecialchars($row['spouse_dob']); ?></p> </div>

 <div class="form-group"> <label for="spouse_education">Highest Educational Attainment of Spouse:</label> 
 <p><?php echo htmlspecialchars($row['spouse_education']); ?></p> </div>

 <div class="form-group"> <label for="spouse_occupation">Occupation of Spouse:</label> 
 <p><?php echo htmlspecialchars($row['spouse_occupation']); ?></p> </div>

 <div class="form-group"> <label for="spouse_company">Name of Spouse's Company:</label> 
 <p><?php echo htmlspecialchars($row['spouse_company']); ?></p> </div>

 <div class="form-group"> <label for="spouse_contact">Contact Number of Spouse:</label> 
 <p><?php echo htmlspecialchars($row['spouse_contact']); ?></p> </div>

 <div class="form-group"> <label for="elem_school">Elementary Level:</label> 
 <p><?php echo htmlspecialchars($row['elem_school']); ?></p> </div>

 <div class="form-group"> <label for="elem_type">Type of School:</label> 
 <p><?php echo htmlspecialchars($row['elem_type']); ?></p> </div>

 <div class="form-group"> <label for="elem_years">Inclusive Years:</label> 
 <p><?php echo htmlspecialchars($row['elem_years']); ?></p> </div>

 <div class="form-group"> <label for="elem_awards">Honor/Awards:</label> 
 <p><?php echo htmlspecialchars($row['elem_awards']); ?></p> </div>

 <div class="form-group"> <label for="junior_high_school">Junior High School Level:</label> 
 <p><?php echo htmlspecialchars($row['junior_high_school']); ?></p> </div>

 <div class="form-group"> <label for="junior_type">Type of School:</label> 
 <p><?php echo htmlspecialchars($row['junior_type']); ?></p> </div>

 <div class="form-group"> <label for="junior_years">Inclusive Years</label> 
 <p><?php echo htmlspecialchars($row['junior_years']); ?></p> </div>

 <div class="form-group"> <label for="junior_awards">Honor/Awards:</label> 
 <p><?php echo htmlspecialchars($row['junior_awards']); ?></p> </div>

 <div class="form-group"> <label for="senior_high_school">Senior High School Level:</label> 
 <p><?php echo htmlspecialchars($row['senior_high_school']); ?></p> </div>

 <div class="form-group"> <label for="senior_type">Type of School:</label> 
 <p><?php echo htmlspecialchars($row['senior_type']); ?></p> </div>

 <div class="form-group"> <label for="senior_years">Inclusive Years</label> 
 <p><?php echo htmlspecialchars($row['senior_years']); ?></p> </div>

 <div class="form-group"> <label for="junior_awards">Honor/Awards:</label> 
 <p><?php echo htmlspecialchars($row['senior_awards']); ?></p> </div>

 <div class="form-group"> <label for="college_course">College Level:</label> 
 <p><?php echo htmlspecialchars($row['college_course']); ?></p> </div>

 <div class="form-group"> <label for="college_type">Type of School:</label> 
 <p><?php echo htmlspecialchars($row['college_type']); ?></p> </div>

 <div class="form-group"> <label for="college_years">Inclusive Years</label> 
 <p><?php echo htmlspecialchars($row['college_years']); ?></p> </div>

 <div class="form-group"> <label for="college_awards">Honor/Awards:</label> 
 <p><?php echo htmlspecialchars($row['college_awards']); ?></p> </div>

 <div class="form-group"> <label for="special_skills">Special Skills/Talent:</label> 
 <p><?php echo htmlspecialchars($row['special_skills']); ?></p> </div>

 <div class="form-group"> <label for="hobbies">Hobbies/Recreational Activities:</label> 
 <p><?php echo htmlspecialchars($row['hobbies']); ?></p> </div>

 <div class="form-group"> <label for="ambition">Ambition/Goals:</label> 
 <p><?php echo htmlspecialchars($row['ambition']); ?></p> </div>

 <div class="form-group"> <label for="motto">Motto in Life:</label> 
 <p><?php echo htmlspecialchars($row['motto']); ?></p> </div>

 <div class="form-group"> <label for="characteristics">Characteristics that Best Describe You:</label> 
 <p><?php echo htmlspecialchars($row['characteristics']); ?></p> </div>

 <div class="form-group"> <label for="influence">Person/s Who Greatly Influenced Your Life (State Briefly Why):</label> 
 <p><?php echo htmlspecialchars($row['influence']); ?></p> </div>

 <div class="form-group"> <label for="concern">Briefly Write What is Your Particular Concern in Any Area of Your Life Mentioned (Frankly Any Difficulty, Confusion, Obstacle, or Worry that is Disturbing You Right Now):</label> 
 <p><?php echo htmlspecialchars($row['concern']); ?></p> </div>

<div class='form-group'>
            <h3>STATEMENT OF CONFIDENTIALITY:</h3>
            <p>Any information that you provide shall be kept confidential except in the following situations:</p>
            <p>(a) when disclosure is required to prevent clear and imminent danger to you or others;</p>
            <p>(b) when legal requirements demand that confidential matters be revealed; and</p>
            <p>(c) when you allow us to provide any information from you to another agency or person who is expected to help you. In this case, your written authorization is required from you. Thank you!</p>
            <br>
            <label>
                <input type='checkbox' name='confidentiality' disabled checked>
                Yes, I know my personal and sensitive information will be handled confidentially.
            </label>
          </div>

    

</body> </html>