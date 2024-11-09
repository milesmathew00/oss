<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
include 'db.php';

// Fetch user data
$query = "SELECT * FROM user_data WHERE user_id = $userId";
$result = mysqli_query($con, $query);
$userData = mysqli_fetch_assoc($result);

if (!$userData) {
    echo "No data found.";
    exit();
}

mysqli_close($con);

// Define fields to hide
$hiddenFields = ['id', 'user_id']; // Fields you want to hide
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submitted Data</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: black;
            text-align: center;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* 5 tables per row */
            gap: 20px;
            padding: 20px;
        }

        .data-table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #2219A8;
            color: white;
        }

        .back-btn {
            text-decoration: none;
            color: black;
            font-size: 20px;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <a href="homepage.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer circle -->
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
            <!-- Inner arrow shape -->
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    <h1>Submitted Data</h1>

    <div class="grid-container">
        <?php
        $count = 0;
        $tableCount = 0;

        // Begin a new table every 7 items, up to 10 tables
        echo '<div class="data-table-container"><table><tr><th>Field</th><th>Value</th></tr>';

        foreach ($userData as $key => $value) {
            if (in_array($key, $hiddenFields)) continue; // Skip hidden fields

            // Close the current table and open a new one every 7 items or when a new table is needed
            if ($count > 0 && $count % 7 == 0) {
                echo '</table></div>';
                $tableCount++;

                // Stop creating tables after 10 tables
                if ($tableCount >= 10) break;

                // Open a new table container
                echo '<div class="data-table-container"><table><tr><th>Field</th><th>Value</th></tr>';
            }

            // Display each data row
            echo '<tr>';
            echo '<td>' . ucfirst(str_replace('_', ' ', htmlspecialchars($key))) . '</td>';
            echo '<td>' . htmlspecialchars($value) . '</td>';
            echo '</tr>';

            $count++;
        }

        echo '</table></div>'; // Close the last table
        ?>
    </div>
</body>

</html>