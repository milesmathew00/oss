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

// Check if data exists
if (!$userData) {
    echo "No data found.";
    exit();
}

mysqli_close($con);
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
        }
        .data-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .data-item {
            margin-bottom: 10px;
        }
        button {
            background-color: #2219A8; /* Green button */
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #89C8FD; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="data-container">
        <h1>Submitted Data</h1>
        <?php foreach ($userData as $key => $value): ?>
            <div class="data-item"><strong><?php echo htmlspecialchars($key); ?>:</strong> <?php echo htmlspecialchars($value); ?></div>
        <?php endforeach; ?>
        <button onclick="window.location.href='homepage.php'">Back</button>
    </div>
</body>
</html>
