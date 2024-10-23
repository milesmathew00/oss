<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

include 'db.php';


// Collect and escape form data
$email = mysqli_real_escape_string($con, $_POST['email']);
$datetime = mysqli_real_escape_string($con, $_POST['datetime']);
$student_number = mysqli_real_escape_string($con, $_POST['student_number']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$nickname = mysqli_real_escape_string($con, $_POST['nickname']);
$course_section = mysqli_real_escape_string($con, $_POST['course_section']);
$mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
$sex_at_birth = mysqli_real_escape_string($con, $_POST['sex_at_birth']);
$gender_identity = mysqli_real_escape_string($con, $_POST['gender_identity']);
$dob = mysqli_real_escape_string($con, $_POST['dob']);
$age = mysqli_real_escape_string($con, $_POST['age']);
$place_of_birth = mysqli_real_escape_string($con, $_POST['place_of_birth']);
$religion = mysqli_real_escape_string($con, $_POST['religion']);
$civil_status = mysqli_real_escape_string($con, $_POST['civil_status']);
$permanent_address = mysqli_real_escape_string($con, $_POST['permanent_address']);
$present_address = mysqli_real_escape_string($con, $_POST['present_address']);
$living_status = mysqli_real_escape_string($con, $_POST['living_status']);
$employed = mysqli_real_escape_string($con, $_POST['employed']);
$company_name = mysqli_real_escape_string($con, $_POST['company_name']);
$job_title = mysqli_real_escape_string($con, $_POST['job_title']);
$handicapped = mysqli_real_escape_string($con, $_POST['handicapped']);
$emergency_contact = mysqli_real_escape_string($con, $_POST['emergency_contact']);
$relation_to_emergency_contact = mysqli_real_escape_string($con, $_POST['relation_to_emergency_contact']);
$emergency_contact_number = mysqli_real_escape_string($con, $_POST['emergency_contact_number']);
$birth_order = mysqli_real_escape_string($con, $_POST['birth_order']);
$number_of_siblings = mysqli_real_escape_string($con, $_POST['number_of_siblings']);
$parents_marital_status = mysqli_real_escape_string($con, $_POST['parents_marital_status']);
$fathers_name = mysqli_real_escape_string($con, $_POST['fathers_name']);
$fathers_dob = mysqli_real_escape_string($con, $_POST['fathers_dob']);
$fathers_age = mysqli_real_escape_string($con, $_POST['fathers_age']);
$fathers_education = mysqli_real_escape_string($con, $_POST['fathers_education']);
$fathers_occupation = mysqli_real_escape_string($con, $_POST['fathers_occupation']);
$fathers_company = mysqli_real_escape_string($con, $_POST['fathers_company']);
$mothers_maiden_name = mysqli_real_escape_string($con, $_POST['mothers_maiden_name']);
$mothers_dob = mysqli_real_escape_string($con, $_POST['mothers_dob']);
$mothers_age = mysqli_real_escape_string($con, $_POST['mothers_age']);
$mothers_education = mysqli_real_escape_string($con, $_POST['mothers_education']);
$mothers_occupation = mysqli_real_escape_string($con, $_POST['mothers_occupation']);
$mothers_company = mysqli_real_escape_string($con, $_POST['mothers_company']);
$family_income = mysqli_real_escape_string($con, $_POST['family_income']);
$marriage_status = mysqli_real_escape_string($con, $_POST['marriage_status']);
$spouse_name = mysqli_real_escape_string($con, $_POST['spouse_name']);
$spouse_dob = mysqli_real_escape_string($con, $_POST['spouse_dob']);
$spouse_education = mysqli_real_escape_string($con, $_POST['spouse_education']);
$spouse_occupation = mysqli_real_escape_string($con, $_POST['spouse_occupation']);
$spouse_company = mysqli_real_escape_string($con, $_POST['spouse_company']);
$spouse_contact = mysqli_real_escape_string($con, $_POST['spouse_contact']);
$elem_school = mysqli_real_escape_string($con, $_POST['elem_school']);
$elem_type = mysqli_real_escape_string($con, $_POST['elem_type']);
$elem_years = mysqli_real_escape_string($con, $_POST['elem_years']);
$elem_awards = mysqli_real_escape_string($con, $_POST['elem_awards']);
$junior_high_school = mysqli_real_escape_string($con, $_POST['junior_high_school']);
$junior_type = mysqli_real_escape_string($con, $_POST['junior_type']);
$junior_years = mysqli_real_escape_string($con, $_POST['junior_years']);
$junior_awards = mysqli_real_escape_string($con, $_POST['junior_awards']);
$senior_high_school = mysqli_real_escape_string($con, $_POST['senior_high_school']);
$senior_type = mysqli_real_escape_string($con, $_POST['senior_type']);
$senior_years = mysqli_real_escape_string($con, $_POST['senior_years']);
$senior_awards = mysqli_real_escape_string($con, $_POST['senior_awards']);
$college_course = mysqli_real_escape_string($con, $_POST['college_course']);
$college_type = mysqli_real_escape_string($con, $_POST['college_type']);
$college_years = mysqli_real_escape_string($con, $_POST['college_years']);
$college_awards = mysqli_real_escape_string($con, $_POST['college_awards']);
$special_skills = mysqli_real_escape_string($con, $_POST['special_skills']);
$hobbies = mysqli_real_escape_string($con, $_POST['hobbies']);
$ambition = mysqli_real_escape_string($con, $_POST['ambition']);
$motto = mysqli_real_escape_string($con, $_POST['motto']);
$characteristics = mysqli_real_escape_string($con, $_POST['characteristics']);
$influence = mysqli_real_escape_string($con, $_POST['influence']);
$concern = mysqli_real_escape_string($con, $_POST['concern']);

// Insert data into database
$sql = "INSERT INTO user_data ( 
    user_id, email, datetime, student_number, name, nickname, course_section, mobile_number, sex_at_birth, gender_identity,
    dob, age, place_of_birth, religion, civil_status, permanent_address, present_address, living_status, employed,
    company_name, job_title, handicapped, emergency_contact, relation_to_emergency_contact, emergency_contact_number,
    birth_order, number_of_siblings, parents_marital_status, fathers_name, fathers_dob, fathers_age, fathers_education,
    fathers_occupation, fathers_company, mothers_maiden_name, mothers_dob, mothers_age, mothers_education, mothers_occupation,
    mothers_company, family_income, marriage_status, spouse_name, spouse_dob, spouse_education, spouse_occupation,
    spouse_company, spouse_contact, elem_school, elem_type, elem_years, elem_awards, junior_high_school, junior_type,
    junior_years, junior_awards, senior_high_school, senior_type, senior_years, senior_awards, college_course, college_type,
    college_years, college_awards, special_skills, hobbies, ambition, motto, characteristics, influence, concern
) VALUES (
    '$userId', '$email', '$datetime', '$student_number', '$name', '$nickname', '$course_section', '$mobile_number', '$sex_at_birth',
    '$gender_identity', '$dob', '$age', '$place_of_birth', '$religion', '$civil_status', '$permanent_address', '$present_address',
    '$living_status', '$employed', '$company_name', '$job_title', '$handicapped', '$emergency_contact',
    '$relation_to_emergency_contact', '$emergency_contact_number', '$birth_order', '$number_of_siblings',
    '$parents_marital_status', '$fathers_name', '$fathers_dob', '$fathers_age', '$fathers_education', '$fathers_occupation',
    '$fathers_company', '$mothers_maiden_name', '$mothers_dob', '$mothers_age', '$mothers_education', '$mothers_occupation',
    '$mothers_company', '$family_income', '$marriage_status', '$spouse_name', '$spouse_dob', '$spouse_education', '$spouse_occupation',
    '$spouse_company', '$spouse_contact', '$elem_school', '$elem_type', '$elem_years', '$elem_awards', '$junior_high_school',
    '$junior_type', '$junior_years', '$junior_awards', '$senior_high_school', '$senior_type', '$senior_years', '$senior_awards',
    '$college_course', '$college_type', '$college_years', '$college_awards', '$special_skills', '$hobbies', '$ambition',
    '$motto', '$characteristics', '$influence', '$concern'
)";

if ($con->query($sql) === TRUE) {
    echo "<script>
        alert('Submit Successfully');
        window.location.href = 'homepage.php';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}





// Close the connection after all queries are done
mysqli_close($con);
?>
