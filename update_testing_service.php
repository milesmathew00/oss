<?php
include 'db.php'; // Include database connection

if (isset($_POST['id']) && isset($_POST['field']) && isset($_POST['value'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $field = mysqli_real_escape_string($con, $_POST['field']);
    $value = mysqli_real_escape_string($con, $_POST['value']);

    // Update the specific field
    $update_query = "UPDATE testing_service SET $field = '$value' WHERE id = $id";

    if (mysqli_query($con, $update_query)) {
        echo "Field updated successfully.";
    } else {
        echo "Error updating field: " . mysqli_error($con);
    }
}
