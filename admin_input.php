<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'db.php';

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $name_of_test = $_POST['name_of_test'];
    $date = $_POST['date']; // Get the date
    $dimension_aspect = $_POST['dimension_aspect'];
    $raw_score = $_POST['raw_score'];
    $percentile = $_POST['percentile'];
    $description = $_POST['description'];

    $query = "SELECT email FROM user_data WHERE id = '$user_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $email = $row['email'];
            $query = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($con, $query);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $user_id = $row['user_id'];
                    $sql = "INSERT INTO testing_service (user_id, name_of_test, date, dimension_aspect, raw_score, percentile, description) 
                        VALUES ('$user_id', '$name_of_test', '$date', '$dimension_aspect', '$raw_score', '$percentile', '$description')";
                    if (mysqli_query($con, $sql)) {
                        echo "Test data inserted successfully\n";  
                    } else {
                        echo "Error inserting test data: " . mysqli_error($con) . "<br>";  // Log error if insertion fails
                    }
                } else {
                    echo "Error: User not found for email: $email<br>";  // Log if no user is found with the email
                }
            } else {
                echo "Error executing query for email: $email. " . mysqli_error($con) . "<br>";  // Log error for second query
            }
        } else {
            echo "Error: No email found for user_id: $user_id<br>";  // Log if no email is found for the given user_id
        }
    } else {
        echo "Error executing query for user_id: $user_id. " . mysqli_error($con) . "<br>";  // Log error for the first query
    }
}


// Fetch distinct course sections
$course_query = "SELECT DISTINCT course_section FROM user_data";
$course_result = mysqli_query($con, $course_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Input Test Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        input[type=text],
        input[type=number],
        input[type=date],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #211ACA;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #211A91;
        }
    </style>
    <script>
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        // Function to filter users based on course selection
        function filterUsers() {
            const courseSection = document.getElementById('course_section').value;
            const userSelect = document.getElementById('user_id');

            // Clear current options
            userSelect.innerHTML = '<option value="">--Select User--</option>';

            // Fetch users via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_users.php?course_section=' + courseSection, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    const users = JSON.parse(this.responseText);
                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.user_id;
                        option.textContent = user.full_name + " (" + user.course_section + ")";
                        userSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    </script>
</head>

<body>
    <a href="admin_page.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    <center>
        <h2>Input Test Data for Users</h2>
    </center>

    <div class="form-container">
        <form action="admin_input.php" method="post">
            <label for="course_section">Select Course Section:</label>
            <select id="course_section" name="course_section" onchange="filterUsers()" required>
                <option value="">--Select Course Section--</option>
                <?php while ($course_row = mysqli_fetch_assoc($course_result)): ?>
                    <option value="<?php echo htmlspecialchars($course_row['course_section']); ?>"><?php echo htmlspecialchars($course_row['course_section']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="user_id">Select User:</label>
            <select id="user_id" name="user_id" required>
                <option value="">--Select Student--</option>
            </select>

            <label for="name_of_test">Test Name:</label>
            <input type="text" id="name_of_test" name="name_of_test" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="dimension_aspect">Dimension/Aspect:</label>
            <input type="text" id="dimension_aspect" name="dimension_aspect" required>

            <label for="raw_score">Raw Score:</label>
            <input type="number" id="raw_score" name="raw_score" required>

            <label for="percentile">Percentile:</label>
            <input type="number" id="percentile" name="percentile" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

</body>

</html>