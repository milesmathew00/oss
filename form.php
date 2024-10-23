<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: auto;
}

h1, h2, h3 {
    text-align: center;
}

fieldset {
    border: 2px solid #007bff;
    border-radius: 5px;
    margin: 10px 0;
    padding: 10px;
}

legend {
    font-weight: bold;
    padding: 0 10px;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input[type="text"],
input[type="email"],
input[type="number"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>
    <title>Student Information Record</title>
</head>
<body>
    <div class="container">
        <h1>Baliuag University</h1>
        <h2>CENTER FOR CAREER AND COUNSELING</h2>
        <h3>STUDENT'S INFORMATION RECORD</h3>
        <p>Note: Please PRINT legibly all information asked for. Data contained in this form will be kept confidential. Please fill in the blanks carefully and sincerely. Write NA if not applicable.</p>
        
        <form>
            <fieldset>
                <legend>PERSONAL DATA</legend>
                <label for="student-number">Student #:</label>
                <input type="text" id="student-number" name="student_number">
                
                <label for="course-year">Course and Year:</label>
                <input type="text" id="course-year" name="course_year">
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Surname, First Name, Middle Name">
                
                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname">
                
                <label for="date-of-birth">Date of Birth:</label>
                <input type="date" id="date-of-birth" name="date_of_birth">
                
                <label for="age">Age:</label>
                <input type="number" id="age" name="age">
                
                <label for="birth-order">Birth Order among Siblings:</label>
                <input type="text" id="birth-order" name="birth_order">
                
                <label for="religion-birth">Religion from Birth:</label>
                <input type="text" id="religion-birth" name="religion_birth">
                
                <label for="current-religion">Current Religion:</label>
                <input type="text" id="current-religion" name="current_religion">
                
                <label for="home-address">Home Address:</label>
                <input type="text" id="home-address" name="home_address">
                
                <label for="tel-no">Tel. No.:</label>
                <input type="text" id="tel-no" name="tel_no">
                
                <label for="cellphone-no">Cellphone No.:</label>
                <input type="text" id="cellphone-no" name="cellphone_no">
                
                <label for="email">E-Mail Address:</label>
                <input type="email" id="email" name="email">
                
                <label for="guardian">Guardian:</label>
                <input type="text" id="guardian" name="guardian">
                
                <label for="guardian-tel">Guardian Telephone No.:</label>
                <input type="text" id="guardian-tel" name="guardian_tel">
                
                <label for="guardian-address">Guardian Address:</label>
                <input type="text" id="guardian-address" name="guardian_address">
                
                <label for="relationship-guardian">Relationship with guardian:</label>
                <input type="text" id="relationship-guardian" name="relationship_guardian">
            </fieldset>

            <fieldset>
                <legend>FAMILY DATA</legend>
                <div class="family">
                    <div class="parent">
                        <h4>Father</h4>
                        <label for="father-name">Name:</label>
                        <input type="text" id="father-name" name="father_name">
                        
                        <label for="father-dob">Date of Birth:</label>
                        <input type="date" id="father-dob" name="father_dob">
                        
                        <label for="father-age">Age:</label>
                        <input type="number" id="father-age" name="father_age">
                        
                        <label for="father-pob">Place of Birth:</label>
                        <input type="text" id="father-pob" name="father_pob">
                        
                        <label for="father-contact">Contact No.:</label>
                        <input type="text" id="father-contact" name="father_contact">
                        
                        <label for="father-education">Educational Attainment:</label>
                        <input type="text" id="father-education" name="father_education">
                        
                        <label for="father-occupation">Occupation:</label>
                        <input type="text" id="father-occupation" name="father_occupation">
                        
                        <label for="father-work">Place of Work:</label>
                        <input type="text" id="father-work" name="father_work">
                    </div>

                    <div class="parent">
                        <h4>Mother</h4>
                        <label for="mother-name">Name:</label>
                        <input type="text" id="mother-name" name="mother_name">
                        
                        <label for="mother-dob">Date of Birth:</label>
                        <input type="date" id="mother-dob" name="mother_dob">
                        
                        <label for="mother-age">Age:</label>
                        <input type="number" id="mother-age" name="mother_age">
                        
                        <label for="mother-pob">Place of Birth:</label>
                        <input type="text" id="mother-pob" name="mother_pob">
                        
                        <label for="mother-contact">Contact No.:</label>
                        <input type="text" id="mother-contact" name="mother_contact">
                        
                        <label for="mother-education">Educational Attainment:</label>
                        <input type="text" id="mother-education" name="mother_education">
                        
                        <label for="mother-occupation">Occupation:</label>
                        <input type="text" id="mother-occupation" name="mother_occupation">
                        
                        <label for="mother-work">Place of Work:</label>
                        <input type="text" id="mother-work" name="mother_work">
                    </div>
                </div>

                <label for="parents-status">Parents' Status (pls. check):</label>
                <div>
                    <label><input type="checkbox" name="parents_status" value="Single Parent"> Single Parent</label>
                    <label><input type="checkbox" name="parents_status" value="Married"> Married</label>
                    <label><input type="checkbox" name="parents_status" value="Separated"> Separated</label>
                    <label><input type="checkbox" name="parents_status" value="Widow"> Widow</label>
                    <label><input type="text" name="other_status" placeholder="Other:"></label>
                </div>

                <label for="siblings">Name of Siblings:</label>
                <input type="text" id="siblings" name="siblings" placeholder="Name, Age, School/Occupation">
            </fieldset>

            <fieldset>
                <legend>CO-CURRICULAR ACTIVITIES</legend>
                <label for="skills">Special Skills / Talents:</label>
                <input type="text" id="skills" name="skills">
                
                <label for="hobbies">Hobbies / Recreational Activities:</label>
                <input type="text" id="hobbies" name="hobbies">
                
                <label for="ambitions">Ambitions / Goals:</label>
                <input type="text" id="ambitions" name="ambitions">
                
                <label for="motto">Motto in Life:</label>
                <input type="text" id="motto" name="motto">
                
                <label for="characteristics">Characteristics that describe you best:</label>
                <input type="text" id="characteristics" name="characteristics">
            </fieldset>

            <fieldset>
                <legend>EDUCATIONAL INFORMATION</legend>
                <label for="school-year">School Year:</label>
                <input type="text" id="school-year" name="school_year" placeholder="20__ - 20__">
                
                <label for="school-type">Type of School:</label>
                <select id="school-type" name="school_type">
                    <option value="private">Private</option>
                    <option value="public">Public</option>
                </select>

                <h4>ELEMENTARY</h4>
                <input type="text" placeholder="Name of School" name="elementary_school">
                <input type="text" placeholder="Inclusive Dates" name="elementary_dates">

                <h4>SECONDARY</h4>
                <input type="text" placeholder="Grade 7" name="grade_7">
                <input type="text" placeholder="Grade 8" name="grade_8">
                <input type="text" placeholder="Grade 9" name="grade_9">
                <input type="text" placeholder="Grade 10" name="grade_10">
                <input type="text" placeholder="Grade 11" name="grade_11">
                <input type="text" placeholder="Grade 12" name="grade_12">

                <h4>COLLEGE</h4>
                <input type="text" placeholder="1st Year" name="college_year_1">
                <input type="text" placeholder="2nd Year" name="college_year_2">
                <input type="text" placeholder="3rd Year" name="college_year_3">
                <input type="text" placeholder="4th Year" name="college_year_4">
                <input type="text" placeholder="5th Year" name="college_year_5">
                
                <label for="awards">Awards/Recognition Received:</label>
                <textarea id="awards" name="awards" rows="3" placeholder="List any awards or recognition"></textarea>
            </fieldset>

            <fieldset>
                <legend>ADDITIONAL INFORMATION</legend>
                <label for="other-info">Other Information:</label>
                <textarea id="other-info" name="other_info" rows="3" placeholder="Include any other relevant information"></textarea>
            </fieldset>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>