<?php
$servername = "localhost"; // or your database server address
$username = "your_username"; // your database username
$password = "your_password"; // your database password
$dbname = "your_database"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!";
}

$conn->close();
?>
