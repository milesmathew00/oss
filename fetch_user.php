<?php
// Database connection parameters
$servername = "localhost"; // Change if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "student_db"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data based on a specific student ID
$student_id = 1; // Change this to the actual student ID you want to fetch
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id); // Bind the student ID as an integer
$stmt->execute();
$result = $stmt->get_result();

// Check if a user was found and fetch the data
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    $userData = null; // No user found
}

// Clean up
$stmt->close();
$conn->close();

// Store user data in a session or directly output it
session_start();
$_SESSION['userData'] = $userData; // Store in session if needed
?>
