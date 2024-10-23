<?php
include 'db.php';

$course_section = $_GET['course_section'];

// Fetch users for the selected course section
$query = "SELECT id AS user_id, name, course_section FROM user_data WHERE course_section = '$course_section'";
$result = mysqli_query($con, $query);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = array(
        'user_id' => $row['user_id'],
        'full_name' => $row['name'],
        'course_section' => $row['course_section']
    );
}

// Return the users as JSON
echo json_encode($users);
?>
