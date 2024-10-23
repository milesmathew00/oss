<?php
session_start();  // Start the session to access session variables

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in."); // Handle not logged in case
}

$user_id = $_SESSION['user_id'];  // Get the user ID from session
include 'db.php';  // Include your database connection

// Initialize a flag to track submission status
$isSubmitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_top_20'])) {
        $concerns = implode(",", $_POST['concerns']);

        // Insert or update the user's top 20 concerns in the database
        $query = "INSERT INTO selections (user_id, top_20) VALUES ('$user_id', '$concerns') 
                  ON DUPLICATE KEY UPDATE top_20='$concerns'";
        mysqli_query($con, $query) or die(mysqli_error($con));  // Check for SQL errors
        $isSubmitted = true;  // Set the submission flag
    }

    if (isset($_POST['submit_top_5'])) {
        // Use the correct key to get top 5 concerns
        $top_5_concerns = isset($_POST['concerns_top_5']) ? implode(",", $_POST['concerns_top_5']) : '';

        // Update the user's top 5 concerns in the database
        $query = "UPDATE selections SET top_5='$top_5_concerns' WHERE user_id='$user_id'";
        mysqli_query($con, $query) or die(mysqli_error($con));  // Check for SQL errors
        $isSubmitted = true;  // Set the submission flag
    }

    // Redirect to the view response page after submission
    if ($isSubmitted) {
        header('Location: view_concern_form.php'); 
        exit();  // Ensure the script stops executing after redirection
    }
}
?>
