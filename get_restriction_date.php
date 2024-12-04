<?php
header('Content-Type: application/json');
include("db.php");

$sql = "SELECT restriction_date FROM service_restriction WHERE service_name = 'problem_checklist'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['restriction_date' => $row['restriction_date']]);
} else {
    echo json_encode(['restriction_date' => null]);
}

$con->close();
