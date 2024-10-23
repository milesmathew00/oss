<?php
session_start(); // Start the session
$userId = $_SESSION['user_id'];
// Database connection
include 'db.php';

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM testing_service WHERE id = '$delete_id'";

    if (mysqli_query($con, $delete_query)) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

// Search functionality
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$records_query = "SELECT ts.id, ts.name_of_test, ts.user_id, ts.date, ts.dimension_aspect, ts.raw_score, ts.percentile, ts.description
                  FROM testing_service ts
                  JOIN user_data ud ON ts.user_id = ud.user_id";

if (!empty($searchTerm)) {
    $searchTerm = mysqli_real_escape_string($con, $searchTerm); // Sanitize the input
    $records_query .= " WHERE ud.name LIKE '%$searchTerm%' ";
}

$records_result = mysqli_query($con, $records_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Service Options</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: blue;
        }

        .edit-button,
        .delete-button {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            margin-right: 5px;
        }

        .edit-button {
            background-color: #4CAF50;
            /* Green */
        }

        .delete-button {
            background-color: #f44336;
            /* Red */
        }

        .suggestions {
            border: 1px solid #ccc;
            background-color: white;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 1000;
            width: calc(100% - 20px);
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        let timeout = null;

        function showSuggestions(input) {
            const suggestionsContainer = document.getElementById('suggestions');
            if (input.length === 0) {
                suggestionsContainer.innerHTML = '';
                return;
            }

            clearTimeout(timeout);
            timeout = setTimeout(() => {
                fetch('search_suggestions.php?query=' + encodeURIComponent(input))
                    .then(response => response.json())
                    .then(data => {
                        suggestionsContainer.innerHTML = '';
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'suggestion-item';
                            div.innerText = item;
                            div.onclick = () => selectSuggestion(item);
                            suggestionsContainer.appendChild(div);
                        });
                    });
            }, 300); // Adjust the timeout as needed
        }

        function selectSuggestion(value) {
            document.getElementById('searchInput').value = value;
            document.getElementById('suggestions').innerHTML = '';
            document.getElementById('searchForm').submit();
        }
    </script>
</head>

<body>

    <a href="admin_page.php">Back to Admin Page</a>
    <center>
        <h2>Testing Service Records</h2>
        <form method="post" id="searchForm">
            <input type="text" id="searchInput" name="search" onkeyup="showSuggestions(this.value)" placeholder="Search by name..." autocomplete="off">
            <div id="suggestions" class="suggestions"></div>
            <input type="submit" value="Search">
        </form>
    </center>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Name of Test</th>
                <th>Date</th>
                <th>Dimension/Aspect</th>
                <th>Raw Score</th>
                <th>Percentile</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($records_result) > 0): ?>
                <?php while ($record = mysqli_fetch_assoc($records_result)):
                    $userid = $record['user_id'];
                    $records_query2 = "SELECT * FROM user WHERE user_id = $userid";
                    $records_result2 = mysqli_query($con, $records_query2);
                    $record2 = mysqli_fetch_assoc($records_result2);
                    $fullname = htmlspecialchars($record2['first_name'] . " " . $record2['last_name']); ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['id']); ?></td>
                        <td><?= $fullname ?></td>
                        <td><?php echo htmlspecialchars($record['name_of_test']); ?></td>
                        <td><?php echo htmlspecialchars($record['date']); ?></td>
                        <td><?php echo htmlspecialchars($record['dimension_aspect']); ?></td>
                        <td><?php echo htmlspecialchars($record['raw_score']); ?></td>
                        <td><?php echo htmlspecialchars($record['percentile']); ?></td>
                        <td><?php echo htmlspecialchars($record['description']); ?></td>
                        <td>
                            <a href="edit_test_data.php?id=<?php echo htmlspecialchars($record['id']); ?>" class="edit-button">Edit</a>
                            <a href="?delete_id=<?php echo htmlspecialchars($record['id']); ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>