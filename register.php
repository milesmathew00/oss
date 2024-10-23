<?php
// Connect to the database
require 'db.php'; // Include your database connection file
// Retrieve user data based on the stored customer ID
$userId = $_SESSION['user_id'];
// Ensure this code runs when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain text password

    // Insert user into the database
    $stmt = $con->prepare("INSERT INTO user (email, password, role) VALUES (?, ?, ?)");
    $role = 'user'; // Set default role as 'user'
    $stmt->bind_param("sss", $email, $password, $role);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "User registered successfully.";
    } else {
        echo "Error registering user.";
    }

    $stmt->close();
    $con->close();
}
?>
