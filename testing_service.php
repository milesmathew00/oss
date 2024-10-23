<?php
session_start();  // Start the session to access session variables



// Include database connection
include 'db.php';
// Fetch user details if not already set in session
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login
    $query = "SELECT first_name, course_section, email FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['course_section'] = $row['course_section'];
        $email = $row['email']; 
        $query2 = "SELECT course_section FROM user_data WHERE email = '$email'";
        $result2 = mysqli_query($con, $query2);
        if ($row2 = mysqli_fetch_assoc($result2)) {
            $course_section = $row2['course_section'];
        }else{
         $course_section = "Not set yet.";
        }

    } else {
      
    }

$first_name = $_SESSION['first_name'];

// Store session variables for easier access
// Handle form submission to add testing service data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_of_test = mysqli_real_escape_string($con, $_POST['name_of_test']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $dimension_aspect = mysqli_real_escape_string($con, $_POST['dimension_aspect']);
    $raw_score = mysqli_real_escape_string($con, $_POST['raw_score']);
    $percentile = mysqli_real_escape_string($con, $_POST['percentile']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Insert into testing_service table
    $query = "INSERT INTO testing_service (name_of_test, dimension_aspect, raw_score, percentile, description) 
              VALUES ('$name_of_test','$date', '$dimension_aspect', '$raw_score', '$percentile', '$description')";
    mysqli_query($con, $query) or die(mysqli_error($con)); // Check for SQL errors
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #211ACA;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
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

<center>
    <h1>Testing Service</h1>
    <h3>Existing Test Results</h3>
</center>
<h3>Student Name: <?php echo htmlspecialchars($first_name); ?> | Section: <?php echo htmlspecialchars($course_section); ?></h3>
   
    <table>
        <tr>
            <th>Name of Test</th>
            <th>Date</th>
            <th>Dimension/Aspect</th>
            <th>Raw Score</th>
            <th>Percentile</th>
            <th>Description</th>
        </tr>
        <?php
        // Fetch existing test results
        $query = "SELECT * FROM testing_service";
        $result = mysqli_query($con, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name_of_test']) . "</td>";
            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dimension_aspect']) . "</td>";
            echo "<td>" . htmlspecialchars($row['raw_score']) . "</td>";
            echo "<td>" . htmlspecialchars($row['percentile']) . "</td>";
            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
