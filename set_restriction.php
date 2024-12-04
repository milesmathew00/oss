<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restriction_date = $_POST['restriction_date'];

    include("db.php");

    // Update or insert restriction date for 'problem_checklist' service
    $stmt = $con->prepare("INSERT INTO service_restriction (service_name, restriction_date) VALUES (?, ?) 
                            ON DUPLICATE KEY UPDATE restriction_date = ?");
    $stmt->bind_param("sss", $service_name, $restriction_date, $restriction_date);

    $service_name = 'problem_checklist';
    $stmt->execute();
    $stmt->close();
    $con->close();

    echo "Restriction date has been set successfully!";
}
