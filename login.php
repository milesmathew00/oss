<?php
session_start(); // Start the session

include 'db.php'; // Include your database connection file
// Retrieve user data based on the stored customer ID
$userId = $_SESSION['user_id'];
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email, password, and role from the form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Role selected in the form

    // Check if email and password are not empty
    if (!empty($email) && !empty($password)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT user_id, password, role, confirmation_status FROM user WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $stored_password, $user_role, $confirmation_status);
            $stmt->fetch();

            // Check if the password matches
            if ($password === $stored_password) {
                // Check if the account is confirmed
                if ($confirmation_status === 'confirmed') {
                    // Check if the user role matches
                    if ($role === $user_role) {
                        // Set session variables
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['logged_in'] = true;

                        // Redirect based on role
                        if ($role === 'user') {
                            header("Location: homepage.php");
                        } else if ($role === 'admin') {
                            header("Location: admin_page.php");
                        }
                        exit();
                    } else {
                        echo '<script>alert("Invalid role selected.");window.location.href = "signin.html";</script>';
                    }
                } else {
                    echo '<script>alert("Account not confirmed.");window.location.href = "signin.html";</script>';
                }
            } else {
                echo '<script>alert("Invalid password.");window.location.href = "signin.html";</script>';
            }
        } else {
            echo '<script>alert("Email not found. Please register.");window.location.href = "signin.html";</script>';
        }
        
        $stmt->close();
    } else {
        echo '<script>alert("Please enter both email and password.");window.location.href = "signin.html";</script>';
    }

    // Close the database connection
    $con->close();
}
?>
