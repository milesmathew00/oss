<?php
session_start(); // Start session to access user data

// Database connection
include 'db.php';

// Handle form submission securely using prepared statements
if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $name_of_test = $_POST['name_of_test'];
    $date = $_POST['date'];
    $dimension_aspect = $_POST['dimension_aspect'];
    $raw_score = $_POST['raw_score'];
    $percentile = $_POST['percentile'];
    $description = $_POST['description'];

    // Prepared statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO testing_service (user_id, name_of_test, date, dimension_aspect, raw_score, percentile, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdds", $user_id, $name_of_test, $date, $dimension_aspect, $raw_score, $percentile, $description);

    if ($stmt->execute()) {
        echo "Test data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
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
        /* Style content for form container */
        /* Keep styles as provided */
    </style>
    <script>
        // Function to filter users based on course selection
        function filterUsers() {
            const courseSection = document.getElementById('course_section').value;
            const userSelect = document.getElementById('user_id');

            // Clear current options
            userSelect.innerHTML = '<option value="">--Select User--</option>';

            // Fetch users via AJAX with error handling
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_users.php?course_section=' + courseSection, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    try {
                        const users = JSON.parse(this.responseText);
                        users.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.user_id;
                            option.textContent = user.full_name + " (" + user.course_section + ")";
                            userSelect.appendChild(option);
                        });
                    } catch (e) {
                        alert("Error parsing user data");
                    }
                } else {
                    alert("Failed to load users. Please try again.");
                }
            };
            xhr.onerror = function() {
                alert("Request error. Please check your connection.");
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