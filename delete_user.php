<?php
session_start();
include 'db.php'; // Ensure you have the database connection file

// Check if the ID is provided via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input

    // Delete the user from the user_data table
    $query = "DELETE FROM user_data WHERE id = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("i", $id); // Bind the ID parameter
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect back to admin page after successful deletion
            header("Location: admin_page.php");
            exit();
        } else {
            echo "Error: Could not delete the user.";
        }
    } else {
        echo "Database query error.";
    }

    // Close the statement and connection
    $stmt->close();
} else {
    echo "No ID provided.";
}
?>
