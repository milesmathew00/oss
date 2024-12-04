<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get form data
$announcement_text = $_POST['announcement_text'];
$scheduled_at = $_POST['scheduled_at'] ?? null;

// Handle file upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
    }
    $image_name = basename($_FILES['image']['name']);
    $image_path = $upload_dir . uniqid() . "_" . $image_name; // Unique file name
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
}

// Insert data into the database
$stmt = $con->prepare("INSERT INTO announcements (announcement_text, created_at, username, image_path, scheduled_at) VALUES (?, NOW(), 'admin', ?, ?)");
$stmt->bind_param("sss", $announcement_text, $image_path, $scheduled_at);

if ($stmt->execute()) {
    echo "<script>alert('Announcement successfully submitted!'); window.location.href='announce.php';</script>";
} else {
    echo "<script>alert('An error occurred while submitting the announcement.'); window.location.href='announce.php';</script>";
}

$stmt->close();
$con->close();
