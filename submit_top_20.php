<?php
session_start();
include 'db.php';  // Include your database connection

// Ensure user_id is stored in session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the Top 20 concerns are submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['concerns'])) {
    $selected_concerns = $_POST['concerns'];

    // Ensure the user selects exactly 20 concerns
    if (count($selected_concerns) === 20) {
        $top_20_concerns_str = implode(",", $selected_concerns);

        // Update or insert Top 20 concerns
        $stmt = $con->prepare("UPDATE selections SET top_20=?, submitted=0 WHERE user_id=?");
        $stmt->bind_param("ss", $top_20_concerns_str, $user_id);

        if ($stmt->execute()) {
            // Update aggregated concerns count for Top 20
            foreach ($selected_concerns as $concern) {
                updateAggregatedConcerns($con, mysqli_real_escape_string($con, $concern));
            }

            // Fetch available concerns for Top 5 selection
            $query_top_5 = "SELECT concern FROM aggregated_concerns"; // Update this to your actual table
            $result_top_5 = mysqli_query($con, $query_top_5);
            $top_5_concerns = [];
            while ($row_top_5 = mysqli_fetch_assoc($result_top_5)) {
                $top_5_concerns[] = $row_top_5['concern'];
            }

            // Prepare the Top 5 form HTML dynamically
            $top5FormHtml = '<h3>Select Your Top 5 Immediate Concerns</h3>';
            foreach ($top_5_concerns as $concern) {
                $top5FormHtml .= '<label><input type="checkbox" name="concerns_top_5[]" value="' . htmlspecialchars($concern) . '">' . htmlspecialchars($concern) . '</label><br>';
            }
            $top5FormHtml .= '<button type="submit" name="submit_top_5">Submit Top 5</button>';

            // Send response back to the frontend
            echo json_encode([
                'success' => true,
                'top5FormHtml' => $top5FormHtml
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating Top 20 concerns.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'You must select exactly 20 concerns.']);
    }
}
