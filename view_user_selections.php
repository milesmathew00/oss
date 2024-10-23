<!-- view_user_selections.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Selections</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f9f9f9; /* Light background color */
            color: #333; /* Dark text color */
        }

        h1, h3 {
            color: black; /* Green color for headings */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0; /* Space between table and headings */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        table, th, td {
            border: 1px solid #ddd; /* Light border for the table */
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #211ACA; /* Header background */
            color: white; /* Header text color */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        tr:hover {
            background-color: #ddd; /* Hover effect */
        }

        a.back-button {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: black;
            margin-bottom: 20px; /* Space below the back button */
            font-size: 16px; /* Font size for back button */
        }

        a.back-button svg {
            margin-right: 8px; /* Space between icon and text */
        }

        button {
            background-color: #211ACA; /* Button background */
            color: white; /* Button text color */
            padding: 10px 20px; /* Button padding */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Font size */
            transition: background-color 0.3s ease; /* Transition effect */
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <a href="admin_display_selections.php" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to Admin Display Selections
    </a>

    <?php
    include 'db.php';

    // Get the user_id from the query string
    $user_id = $_GET['user_id'];

    // Fetch the user's selections from the database
    $query = "SELECT user.first_name, user.last_name, selections.top_20, selections.top_5
              FROM user
              JOIN selections ON user.user_id = selections.user_id
              WHERE user.user_id = '$user_id'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "<p>Debug: Error in query: " . mysqli_error($con) . "</p>";
    }

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        echo "<h1>Selections for " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</h1>";

        // Display top 20 concerns
        echo "<h3>Top 20 Concerns</h3>";
        echo "<table>";
        echo "<tr><th>Concern</th></tr>";
        $top_20 = explode(",", $row['top_20']);
        foreach ($top_20 as $concern) {
            echo "<tr><td>" . htmlspecialchars($concern) . "</td></tr>";
        }
        echo "</table>";

        // Display top 5 concerns
        echo "<h3>Top 5 Concerns</h3>";
        echo "<table>";
        echo "<tr><th>Concern</th></tr>";
        $top_5 = explode(",", $row['top_5']);
        foreach ($top_5 as $concern) {
            echo "<tr><td>" . htmlspecialchars($concern) . "</td></tr>";
        }
        echo "</table>";

        // Button to generate PDF
        echo '<form method="POST" action="generate_pdf.php" style="margin-top: 20px;">';
        echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">';
        echo '<button type="submit" name="generate_pdf">Generate PDF</button>';
        echo '</form>';
    } else {
        echo "<p>No selections found for this user.</p>";
    }
    ?>
</body>
</html>
