<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Delete announcement
    $stmt = $con->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Announcement deleted successfully.'); window.location.href = 'announce.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the announcement.'); window.location.href = 'announce.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'announce.php';</script>";
}

$con->close();
