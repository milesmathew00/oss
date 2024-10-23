<?php
session_start();

// Get the alert message
$alert_message = isset($_SESSION['alert_message']) ? $_SESSION['alert_message'] : '';
unset($_SESSION['alert_message']); // Unset the message after retrieval
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alert</title>
    <script>
        // Display the alert message
        window.onload = function() {
            alert("<?= addslashes($alert_message) ?>"); // Show the alert

            // Redirect to homepage after the alert is dismissed
            window.location.href = "homepage.php"; // Replace 'home.php' with your actual homepage URL
        };
    </script>
</head>
<body>
    <!-- Optional content can go here -->
</body>
</html>
