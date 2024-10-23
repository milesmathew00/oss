<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php'; // Ensure this file contains your DB connection setup

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view your submitted concerns.");
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if the connection was successful
if (!$con) {
    die("Database connection failed.");
}

// Query to fetch submitted concerns from the database
$query = $con->prepare("SELECT top_20, top_5 FROM selections WHERE user_id = ?");
$query->bind_param('i', $user_id);
$query->execute();
$query->bind_result($top_20_concerns, $top_5_concerns);
$query->fetch();
$query->close();

// Check if the user has already submitted concerns
if (empty($top_20_concerns) && empty($top_5_concerns)) {
    echo "<p>You haven't submitted your Top 20 and Top 5 concerns yet.</p>";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Submitted Concerns</title>
        <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS for better styling -->
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            h1, h2 {
                color: #333;
            }
            ul {
                list-style-type: none;
                padding: 0;
            }
            li {
                background: #f4f4f4;
                margin: 5px 0;
                padding: 10px;
                border-radius: 5px;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                text-decoration: none;
                color: #007BFF;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <h1>Youve Already Submitted Your Concerns</h1>

        <h2>Top 20 Concerns</h2>
        <ul>
            <?php
            // Display the Top 20 concerns
            if (!empty($top_20_concerns)) {
                $top_20_array = explode(',', $top_20_concerns); // Assuming concerns are stored as a comma-separated string
                foreach ($top_20_array as $concern) {
                    echo "<li>" . htmlspecialchars(trim($concern)) . "</li>"; // trim to remove extra spaces
                }
            } else {
                echo "<li>No Top 20 concerns submitted.</li>";
            }
            ?>
        </ul>

        <h2>Top 5 Concerns</h2>
        <ul>
            <?php
            // Display the Top 5 concerns
            if (!empty($top_5_concerns)) {
                $top_5_array = explode(',', $top_5_concerns); // Assuming concerns are stored as a comma-separated string
                foreach ($top_5_array as $concern) {
                    echo "<li>" . htmlspecialchars(trim($concern)) . "</li>"; // trim to remove extra spaces
                }
            } else {
                echo "<li>No Top 5 concerns submitted.</li>";
            }
            ?>
        </ul>

        <a href="homepage.php">Go Back to Homepage</a>
    </body>
    </html>
    <?php
}

// Close the database connection only if it's been created
if (isset($con) && $con instanceof mysqli) {
    $con->close();
}
?>
