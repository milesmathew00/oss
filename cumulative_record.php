<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
include 'db.php'; // Include your database connection

// Check if the user has already submitted the form
$formSubmittedQuery = "SELECT * FROM user_data WHERE user_id = $userId";
$formSubmittedResult = mysqli_query($con, $formSubmittedQuery);

// Redirect to the view page if the form is already submitted
if (mysqli_num_rows($formSubmittedResult) > 0) {
    header("Location: view.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_form'])) {
    // Collect form data with proper escaping
    $formData = [
        'user_id' => $userId, // Include user ID
        'email' => mysqli_real_escape_string($con, $_POST['email']),
        'datetime' => mysqli_real_escape_string($con, $_POST['datetime']),
        'student_number' => mysqli_real_escape_string($con, $_POST['student_number']),
        'name' => mysqli_real_escape_string($con, $_POST['name']),
        'nickname' => mysqli_real_escape_string($con, $_POST['nickname']),
        'course_section' => mysqli_real_escape_string($con, $_POST['course_section']),
        'mobile_number' => mysqli_real_escape_string($con, $_POST['mobile_number']),
        'sex_at_birth' => mysqli_real_escape_string($con, $_POST['sex_at_birth']),
        'gender_identity' => mysqli_real_escape_string($con, $_POST['gender_identity']),
        'dob' => mysqli_real_escape_string($con, $_POST['dob']),
        'age' => mysqli_real_escape_string($con, $_POST['age']),
        'place_of_birth' => mysqli_real_escape_string($con, $_POST['place_of_birth']),
        'religion' => mysqli_real_escape_string($con, $_POST['religion']),
        'civil_status' => mysqli_real_escape_string($con, $_POST['civil_status']),
        'permanent_address' => mysqli_real_escape_string($con, $_POST['permanent_address']),
        'present_address' => mysqli_real_escape_string($con, $_POST['present_address']),
        'living_status' => mysqli_real_escape_string($con, $_POST['living_status']),
        'employed' => mysqli_real_escape_string($con, $_POST['employed']),
        'company_name' => mysqli_real_escape_string($con, $_POST['company_name']),
        'job_title' => mysqli_real_escape_string($con, $_POST['job_title']),
        'handicapped' => mysqli_real_escape_string($con, $_POST['handicapped']),
        'emergency_contact' => mysqli_real_escape_string($con, $_POST['emergency_contact']),
        'relation_to_emergency_contact' => mysqli_real_escape_string($con, $_POST['relation_to_emergency_contact']),
        'emergency_contact_number' => mysqli_real_escape_string($con, $_POST['emergency_contact_number']),
        'birth_order' => mysqli_real_escape_string($con, $_POST['birth_order']),
        'number_of_siblings' => mysqli_real_escape_string($con, $_POST['number_of_siblings']),
        'parents_marital_status' => mysqli_real_escape_string($con, $_POST['parents_marital_status']),
        'fathers_name' => mysqli_real_escape_string($con, $_POST['fathers_name']),
        'fathers_dob' => mysqli_real_escape_string($con, $_POST['fathers_dob']),
        'fathers_age' => mysqli_real_escape_string($con, $_POST['fathers_age']),
        'fathers_education' => mysqli_real_escape_string($con, $_POST['fathers_education']),
        'fathers_occupation' => mysqli_real_escape_string($con, $_POST['fathers_occupation']),
        'fathers_company' => mysqli_real_escape_string($con, $_POST['fathers_company']),
        'mothers_maiden_name' => mysqli_real_escape_string($con, $_POST['mothers_maiden_name']),
        'mothers_dob' => mysqli_real_escape_string($con, $_POST['mothers_dob']),
        'mothers_age' => mysqli_real_escape_string($con, $_POST['mothers_age']),
        'mothers_education' => mysqli_real_escape_string($con, $_POST['mothers_education']),
        'mothers_occupation' => mysqli_real_escape_string($con, $_POST['mothers_occupation']),
        'mothers_company' => mysqli_real_escape_string($con, $_POST['mothers_company']),
        'family_income' => mysqli_real_escape_string($con, $_POST['family_income']),
        'marriage_status' => mysqli_real_escape_string($con, $_POST['marriage_status']),
        'spouse_name' => mysqli_real_escape_string($con, $_POST['spouse_name']),
        'spouse_dob' => mysqli_real_escape_string($con, $_POST['spouse_dob']),
        'spouse_education' => mysqli_real_escape_string($con, $_POST['spouse_education']),
        'spouse_occupation' => mysqli_real_escape_string($con, $_POST['spouse_occupation']),
        'spouse_company' => mysqli_real_escape_string($con, $_POST['spouse_company']),
        'spouse_contact' => mysqli_real_escape_string($con, $_POST['spouse_contact']),
        'elem_school' => mysqli_real_escape_string($con, $_POST['elem_school']),
        'elem_type' => mysqli_real_escape_string($con, $_POST['elem_type']),
        'elem_years' => mysqli_real_escape_string($con, $_POST['elem_years']),
        'elem_awards' => mysqli_real_escape_string($con, $_POST['elem_awards']),
        'junior_high_school' => mysqli_real_escape_string($con, $_POST['junior_high_school']),
        'junior_type' => mysqli_real_escape_string($con, $_POST['junior_type']),
        'junior_years' => mysqli_real_escape_string($con, $_POST['junior_years']),
        'junior_awards' => mysqli_real_escape_string($con, $_POST['junior_awards']),
        'senior_high_school' => mysqli_real_escape_string($con, $_POST['senior_high_school']),
        'senior_type' => mysqli_real_escape_string($con, $_POST['senior_type']),
        'senior_years' => mysqli_real_escape_string($con, $_POST['senior_years']),
        'senior_awards' => mysqli_real_escape_string($con, $_POST['senior_awards']),
        'college_course' => mysqli_real_escape_string($con, $_POST['college_course']),
        'college_type' => mysqli_real_escape_string($con, $_POST['college_type']),
        'college_years' => mysqli_real_escape_string($con, $_POST['college_years']),
        'college_awards' => mysqli_real_escape_string($con, $_POST['college_awards']),
        'special_skills' => mysqli_real_escape_string($con, $_POST['special_skills']),
        'hobbies' => mysqli_real_escape_string($con, $_POST['hobbies']),
        'ambition' => mysqli_real_escape_string($con, $_POST['ambition']),
        'motto' => mysqli_real_escape_string($con, $_POST['motto']),
        'characteristics' => mysqli_real_escape_string($con, $_POST['characteristics']),
        'influence' => mysqli_real_escape_string($con, $_POST['influence']),
        'concern' => mysqli_real_escape_string($con, $_POST['concern']),
        'confidentiality' => isset($_POST['confidentiality']) ? 1 : 0,
    ];
    $columns = implode(", ", array_keys($formData));
    $values = "'" . implode("', '", array_map('mysqli_real_escape_string', array_values($formData))) . "'";
    $query = "INSERT INTO user_data ($columns) VALUES ($values)";

    if (mysqli_query($con, $query)) {
        // Redirect to the view page after successful submission
        header("Location: view.php");
        exit(); 
    } else {
        echo "Error submitting form: " . mysqli_error($con);
    }
}

// Fetch user data for display (optional if you want to show user info on the form)
$query = "SELECT * FROM user WHERE user_id = $userId";
$result = mysqli_query($con, $query);

if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    die("Error fetching user data: " . mysqli_error($con));
}

// Close the connection after all queries are done
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4; /* Light background */
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        h1 {
            color: #046c2d; /* Green heading */
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="datetime-local"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }
        button {
            background-color: #046c2d; /* Green button */
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #044a1c; /* Darker green on hover */
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        .error {
            border: 2px solid red;
        }
    </style>
</head>
<body>
<a href="homepage.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Outer circle -->
        <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
        <!-- Inner arrow shape -->
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>
    <br><br>
    <div class="container">
        
        <form id="multiStepForm" action="submit_form.php" method="post">
     <!-- Step 1: Personal Details -->
     <div class="step active">
    <div class="form-group">
    <h1>Personal DATA</h1>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="datetime">Date & Time Accomplished:</label>
        <input type="datetime-local" name="datetime" id="datetime" required>
    </div>
    <div class="form-group">
        <label for="student_number">Student Number:</label>
        <input type="text" name="student_number" id="student_number" required>
    </div>
    <div class="form-group">
        <label for="name">Name (Surname, Given Name, MI):</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="form-group">
        <label for="nickname">Nickname:</label>
        <input type="text" name="nickname" id="nickname">
    </div>
    <div class="form-group">
        <label for="course_section">Course & Section:</label>
        <input type="text" name="course_section" id="course_section" required>
    </div>
    <div class="form-group">
        <label for="mobile_number">Mobile Number:</label>
        <input type="tel" name="mobile_number" id="mobile_number" required>
    </div>
    <div class="form-group">
        <label for="sex_at_birth">Sex at Birth:</label>
        <select name="sex_at_birth" id="sex_at_birth" required>
            <option value="Boy">Boy</option>
            <option value="Girl">Girl</option>
            <option value="Prefer not to say">Prefer not to say</option>
        </select>
    </div> <button type="button" onclick="nextStep()">Next</button>
    </div>
     <!-- Step 2: More Personal Details -->
     <div class="step">
    <div class="form-group">
        <label for="gender_identity">Gender Identity:</label>
        <select name="gender_identity" id="gender_identity" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Transgender">Transgender</option>
            <option value="Non-binary/non-conforming">Non-binary/non-conforming</option>
            <option value="Prefer not to respond">Prefer not to respond</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" id="dob" required>
    </div>
    <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required>
    </div>
    <div class="form-group">
        <label for="place_of_birth">Place of Birth:</label>
        <input type="text" name="place_of_birth" id="place_of_birth" required>
    </div>
    <div class="form-group">
        <label for="religion">Religion:</label>
        <input type="text" name="religion" id="religion">
    </div>
    <div class="form-group">
        <label for="civil_status">Civil Status:</label>
        <select name="civil_status" id="civil_status">
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
            <option value="Widowed">Widowed</option>
            <option value="Separated">Separated</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <div class="form-group">
        <label for="permanent_address">Permanent Address:</label>
        <textarea name="permanent_address" id="permanent_address" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="present_address">Present Address:</label>
        <textarea name="present_address" id="present_address" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="living_status">Living Situation:</label>
        <select name="living_status" id="living_status" required>
            <option value="With parents">With parents</option>
            <option value="With mother">With mother</option>
            <option value="With guardian">With guardian</option>
            <option value="Renting a boarding house/apartment">Renting a boarding house/apartment</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <div class="form-group">
        <label for="employed">Employed or Working:</label>
        <select name="employed" id="employed">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
    </div>
    <div class="form-group">
        <label for="company_name">Name of Company:</label>
        <input type="text" name="company_name" id="company_name">
    </div>
    <div class="form-group">
        <label for="job_title">Job Title/Position:</label>
        <input type="text" name="job_title" id="job_title">
    </div> <button type="button" onclick="prevStep()">Previous</button>
                <button type="button" onclick="nextStep()">Next</button>
            </div>
    <div class="step">
    <div class="form-group">
        <label for="handicapped">Any Common Handicapped, Ailment, or Problem:</label>
        <input type="text" name="handicapped" id="handicapped">
    </div>
    <div class="form-group">
        <label for="emergency_contact">Emergency Contact:</label>
        <input type="text" name="emergency_contact" id="emergency_contact" required>
    </div>
    <div class="form-group">
        <label for="relation_to_emergency_contact">Relation to Emergency Contact:</label>
        <input type="text" name="relation_to_emergency_contact" id="relation_to_emergency_contact" required>
    </div>
    <div class="form-group">
        <label for="emergency_contact_number">Emergency Contact Number:</label>
        <input type="tel" name="emergency_contact_number" id="emergency_contact_number" required>
    </div>
    <div class="form-group">
        <label for="birth_order">Birth Order:</label>
        <select name="birth_order" id="birth_order" required>
            <option value="Only Child">Only Child</option>
            <option value="First Born">First Born</option>
            <option value="Second Born">Second Born</option>
            <option value="Middle Born">Middle Born</option>
            <option value="Youngest">Youngest</option>
            <option value="Other">Other</option>
        </select>
    </div>

   

            <!-- Step 3: Contact Information -->
            
    <div class="form-group">
        <label for="number_of_siblings">Number of Siblings:</label>
        <input type="number" name="number_of_siblings" id="number_of_siblings" required>
    </div>
    <div class="form-group">
        <label for="parents_marital_status">Marital Status of Parents:</label>
        <select name="parents_marital_status" id="parents_marital_status" required>
            <option value="Married">Married</option>
            <option value="Not Married">Not Married</option>
            <option value="Separated">Separated</option>
            <option value="Widowed">Widowed</option>
            <option value="Single Parent">Single Parent</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <h1>Father's DATA</h1>
    <div class="form-group">
        <label for="fathers_name">Father's Name:</label>
        <input type="text" name="fathers_name" id="fathers_name" required>
    </div>
    <div class="form-group">
        <label for="fathers_dob">Father's Date of Birth:</label>
        <input type="date" name="fathers_dob" id="fathers_dob" required>
    </div>
    <div class="form-group">
        <label for="fathers_age">Father's Age:</label>
        <input type="number" name="fathers_age" id="fathers_age" required>
    </div>
    <div class="form-group">
        <label for="fathers_education">Father's Highest Educational Attainment:</label>
        <select name="fathers_education" id="fathers_education">
            <option value="Graduate School Graduate MAPhD">Graduate School Graduate MAPhD</option>
            <option value="Graduate School Undergraduate MAPhD">Graduate School Undergraduate MAPhD</option>
            <option value="College Graduate">College Graduate</option>
            <option value="College Undergraduate">College Undergraduate</option>
            <option value="Vocational Graduate">Vocational Graduate</option>
            <option value="Vocational Undergraduate">Vocational Undergraduate</option>
            <option value="High School Graduate">High School Graduate</option>
            <option value="High School Undergraduate">High School Undergraduate</option>
            <option value="Elementary Graduate">Elementary Graduate</option>
            <option value="Elementary Undergraduate">Elementary Undergraduate</option>
            <option value="None">None</option>
        </select>
    </div> <button type="button" onclick="prevStep()">Previous</button>
                <button type="button" onclick="nextStep()">Next</button>
            </div>

            <div class="step">
            <div class="form-group">
                <label for="fathers_occupation">Father's Occupation:</label>
                <input type="text" name="fathers_occupation" id="fathers_occupation">
            </div>
            <div class="form-group">
<label for="fathers_company">Name of Father's Company:</label> 
<input type="text" name="fathers_company" id="fathers_company"> </div>
<h1>Mother's DATA</h1>

<div class="form-group"> <label for="mothers_maiden_name">Mother's Maiden Name:</label>
 <input type="text" name="mothers_maiden_name" id="mothers_maiden_name" required> </div> 

 <div class="form-group"> <label for="mothers_dob">Mother's Date of Birth:</label>
  <input type="date" name="mothers_dob" id="mothers_dob" required> </div> 

  <div class="form-group"> <label for="mothers_age">Mother's Age:</label> 
  <input type="number" name="mothers_age" id="mothers_age" required> </div> 

  <div><label for="mothers_education">Mother's Highest Educational Attainment:</label><br>
        <select name="mothers_education" id="mothers_education">
            <option value="Graduate School Graduate MAPhD">Graduate School Graduate MAPhD</option>
            <option value="Graduate School Undergraduate MAPhD">Graduate School Undergraduate MAPhD</option>
            <option value="College Graduate">College Graduate</option>
            <option value="College Undergraduate">College Undergraduate</option>
            <option value="Vocational Graduate">Vocational Graduate</option>
            <option value="Vocational Undergraduate">Vocational Undergraduate</option>
            <option value="High School Graduate">High School Graduate</option>
            <option value="High School Undergraduate">High School Undergraduate</option>
            <option value="Elementary Graduate">Elementary Graduate</option>
            <option value="Elementary Undergraduate">Elementary Undergraduate</option>
            <option value="None">None</option>
        </select>
    </div>
    <br>
   <div class="form-group"> <label for="mothers_occupation">Mother's Occupation:</label>
    <input type="text" name="mothers_occupation" id="mothers_occupation"> </div> 

    <div class="form-group"> <label for="mothers_company">Name of Mother's Company:</label> 
    <input type="text" name="mothers_company" id="mothers_company"> </div> 
    <button type="button" onclick="prevStep()">Previous</button>
                <button type="button" onclick="nextStep()">Next</button>
            </div>
    <div class="step">
    <div class="form-group"> <label for="family_income">Family Monthly Income:</label> 
    <select name="family_income" id="family_income" required> </div>
    <option value="Less Than 11,6990.00PHP">Poor Income Less Than 11,6990.00PHP</option>
            <option value="23,381-46,761.00PHP">Lower Middle Income Between 23,381-46,761.00PHP</option>
            <option value="46,761-81,832.00PHP">Middle Class Income 46,761-81,832..00PHP</option>
            <option value="81,832-140,284.00PHP">Upper Middle Income 81,832-140,284.00PHP</option>
            <option value="140,284-233,806..00PHP">Upper Income 140,284-233,806..00PHP</option>
            <option value="233,807.00PHP">Rich Income Atleast 233,807..00PHP</option>
            </select>
    </div>
     <!-- Questions for Married Individuals --> 
      <div class="form-group"> <label for="marriage_status">Marriage Status:</label>
      <select name="marriage_status" id="marriage_status"> 
          <option value="Married">Married</option>
          <option value="Separated">Separated</option>
          <option value="Widowed">Widowed</option> 
          <option value="Living-in">Living-in</option> 
          <option value="Annulled">Annulled</option> 
          <option value="Other">Other</option> 
          </select>
        </div>
       

        <h1>Spouse DATA</h1>
       <div class="form-group"> <label for="spouse_name">Name of Spouse:</label> 
       <input type="text" name="spouse_name" id="spouse_name"> </div> 

       <div class="form-group"> <label for="spouse_dob">Date of Birth of Spouse:</label> 
       <input type="date" name="spouse_dob" id="spouse_dob"> </div> 

       <div class="form-group"> <label for="spouse_education">Highest Educational Attainment of Spouse:</label> 
       <select name="spouse_education" id="spouse_education">
            <option value="Graduate School Graduate MAPhD">Graduate School Graduate MAPhD</option>
            <option value="Graduate School Undergraduate MAPhD">Graduate School Undergraduate MAPhD</option>
            <option value="College Graduate">College Graduate</option>
            <option value="College Undergraduate">College Undergraduate</option>
            <option value="Vocational Graduate">Vocational Graduate</option>
            <option value="Vocational Undergraduate">Vocational Undergraduate</option>
            <option value="High School Graduate">High School Graduate</option>
            <option value="High School Undergraduate">High School Undergraduate</option>
            <option value="Elementary Graduate">Elementary Graduate</option>
            <option value="Elementary Undergraduate">Elementary Undergraduate</option>
            <option value="None">None</option>
        </select> </div> 

       <div class="form-group"> <label for="spouse_occupation">Occupation of Spouse:</label> 
       <input type="text" name="spouse_occupation" id="spouse_occupation"> </div> 

       <div class="form-group"> <label for="spouse_company">Name of Spouse's Company:</label> 
       <input type="text" name="spouse_company" id="spouse_company"> </div> 

       <div class="form-group"> <label for="spouse_contact">Contact Number of Spouse:</label> 
       <input type="tel" name="spouse_contact" id="spouse_contact"> </div>
       <button type="button" onclick="prevStep()">Previous</button>
                <button type="button" onclick="nextStep()">Next</button>
            </div>
            <div class="step">
        <!-- Educational Background --> <h2>Educational Background</h2> <!-- Elementary --> 
         <div class="form-group"> <label for="elem_school">Elementary School:</label> 
         <input type="text" name="elem_school" id="elem_school"> </div>

          <div class="form-group"> <label for="elem_type">Type of School:</label> 
          <select name="elem_type" id="elem_type"> 
          <option value="Private">Private</option>
          <option value="Public/Govermment">Public/Govermment</option>
          <option value="Other">Other</option></select>
          </div> 

          <div class="form-group"> <label for="elem_years">Inclusive Years(ex. 2010-2016):</label> 
          <input type="text" name="elem_years" id="elem_years"> </div>

          <div class="form-group"> <label for="elem_awards">Honor/Awards:</label> 
          <input type="text" name="elem_awards" id="elem_awards"> </div> 
          <!-- Junior High School --> 
           <div class="form-group"> <label for="junior_high_school">Junior High School:</label> 
           <input type="text" name="junior_high_school" id="junior_high_school"> </div>

           <div class="form-group"> <label for="junior_type">Type of School:</label> 
           <select name="junior_type" id="junior_type"> 
          <option value="Private">Private</option>
          <option value="Public/Govermment">Public/Govermment</option>
          <option value="Other">Other</option></select> </div> 

           <br>
           
           <div class="form-group"> <label for="junior_years"><br>Inclusive Years(ex. 2016-2020):</label> 
           <input type="text" name="junior_years" id="junior_years"> </div> 

           <div class="form-group"> <label for="junior_awards">Honor/Awards:</label> 
           <input type="text" name="junior_awards" id="junior_awards"> </div> 
           <!-- Senior High School --> 
            <div class="form-group"> <label for="senior_high_school">Senior High School:</label> 
            <input type="text" name="senior_high_school" id="senior_high_school"> </div>

            <div class="form-group"> <label for="senior_type">Type of School:</label> 
            <select name="senior_type" id="senior_type"> 
          <option value="Private">Private</option>
          <option value="Public/Govermment">Public/Govermment</option>
          <option value="Other">Other</option></select></div> 

            <div class="form-group"> <label for="senior_years">Inclusive Years(ex. 2020-2022):</label> 
            <input type="text" name="senior_years" id="senior_years"> </div> 

            <div class="form-group"> <label for="senior_awards">Honor/Awards:</label> 
            <input type="text" name="senior_awards" id="senior_awards"> </div>  
             <!-- College --> 
              <div class="form-group"> <label for="college_course">College Level:</label> 
              <input type="text" name="college_course" id="college_course"> </div> 

              <div class="form-group"> <label for="college_type">Type of School:</label> 
              <select name="college_type" id="college_type"> 
          <option value="Private">Private</option>
          <option value="Public/Govermment">Public/Govermment</option>
          <option value="Other">Other</option></select> </div> 

              <div class="form-group"> <label for="college_years">Inclusive Years(ex. 2022-2026):</label> 
              <input type="text" name="college_years" id="college_years"> </div> 

              <div class="form-group"> <label for="college_awards">Honor/Awards:</label> 
              <input type="text" name="college_awards" id="college_awards"> </div>
              
              <button type="button" onclick="prevStep()">Previous</button>
                <button type="button" onclick="nextStep()">Next</button>
            </div> 
              <div class="step">
              <!-- Additional Information --> 
               <h2>CO-CURICULAR ACTIVITIES</h2> 
               <div class="form-group"> <label for="special_skills">Special Skills/Talent:</label> 
               <input type="text" name="special_skills" id="special_skills"> </div>

               <div class="form-group"> <label for="hobbies">Hobbies/Recreational Activities:</label> 
               <input type="text" name="hobbies" id="hobbies"> </div> 

               <div class="form-group"> <label for="ambition">Ambition/Goals:</label>
                <input type="text" name="ambition" id="ambition"> </div> 

                <div class="form-group"> <label for="motto">Motto in Life:</label> 
                <input type="text" name="motto" id="motto"> </div> 

                <div class="form-group"> <label for="characteristics">Characteristics that Best Describe You:</label> 
                <input type="text" name="characteristics" id="characteristics"> </div>

                <div class="form-group"> <label for="influence">Person/s Who Greatly Influenced Your Life (State Briefly Why):</label> 
                <input type="text" name="influence" id="influence"> </div> 

                <div class="form-group"> <label for="concern">Briefly Write What is Your Particular Concern in Any Area of Your Life Mentioned (Frankly Any Difficulty, Confusion, Obstacle, or Worry that is Disturbing You Right Now):</label> 
                <textarea name="concern" id="concern" rows="4"></textarea> </div>

                 <!-- Confidentiality Statement --> 
                  <div class="form-group"> <h3>STATEMENT OF CONFIDENTIALITY:</h3> <p>Any information that you provide shall be kept confidential except in the following situations:</p> 
                  <p>(a) when disclosure is required to prevent clear and imminent danger to you or others;</p> 
                  <p>(b) when legal requirements demand that confidential matters be revealed; and</p> 
                  <p>(c) when you allow us to provide any information from you to another agency or person who is expected to help you. In this case, your written authorization is required from you. Thank you!</p> 
                  <br><label> <input type="checkbox" name="confidentiality" required> Yes, I know my personal and sensitive
                  
<div class="form-group btn-container"> <button type="submit" name="submit_form">Submit</button> </div> </form> </div>
<button type="button" onclick="prevStep()">Previous</button></div>


    


<script>
       let currentStep = 0;
        const steps = document.querySelectorAll('.step');

        function showStep(step) {
            steps.forEach((element, index) => {
                element.classList.toggle('active', index === step);
            });

            // Show/hide the submit button based on the current step
            const submitButton = document.querySelector('button[type="submit"]');
            if (step === steps.length - 1) {
                submitButton.style.display = 'block'; // Show the submit button on the last step
            } else {
                submitButton.style.display = 'none'; // Hide the submit button on other steps
            }
        }

        function nextStep() {
            var currentStepElement = steps[currentStep];
            var inputs = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
            var valid = true;

            // Check if all required inputs in the current step are filled
            inputs.forEach(function(input) {
                if (!input.value) {
                    input.classList.add('error');
                    valid = false;
                } else {
                    input.classList.remove('error');
                }
            });

            if (valid) {
                // Move to the next step if all fields are filled
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            } else {
                alert('Please fill all required fields before proceeding.');
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }
    </script>
</body>
</html>