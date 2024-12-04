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

        .editable {
            background-color: #fff7e6;
            cursor: pointer;
        }

        .edit-input {
            border: none;
            width: 100%;
            background-color: #fff7e6;
        }
    </style>
    <script>
        // Inline editing function
        function makeEditable(element, fieldName, id) {
            const originalText = element.innerText;
            element.innerHTML = `<input type='text' class='edit-input' value='${originalText}' onblur='updateField(this, "${fieldName}", ${id})'>`;
            element.querySelector('input').focus();
        }

        // Send AJAX request to update the field
        function updateField(inputElement, fieldName, id) {
            const newValue = inputElement.value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_testing_service.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    inputElement.parentElement.innerText = newValue; // Update the cell with the new value
                }
            };

            xhr.send(`id=${id}&field=${fieldName}&value=${encodeURIComponent(newValue)}`);
        }

        // Print function
        function printTable() {
            var printWindow = window.open('', '', 'height=600,width=800'); // Open new print window
            printWindow.document.write('<html><head><title>Testing Service Records</title></head><body>');
            printWindow.document.write('<h2>Testing Service Records</h2>'); // Add header to print window
            printWindow.document.write(document.querySelector('table').outerHTML); // Copy table HTML to print window
            printWindow.document.write('</body></html>');
            printWindow.document.close(); // Close the document
            printWindow.print(); // Trigger print dialog
        }
    </script>
</head>

<body>

    <a href="admin_page.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer circle -->
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
            <!-- Inner arrow shape -->
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    <center>
        <h2>Testing Service Records</h2>
        <form method="post" id="searchForm">
            <input type="text" id="searchInput" name="search" placeholder="Search by name..." autocomplete="off">
            <input type="submit" value="Search">
        </form>


    </center>

    <table>
        <thead>
            <tr>
                <!-- <th>ID</th> -->
                <th>Student Name</th>
                <th>Name of Test</th>
                <th>Date</th>
                <th>Dimension/Aspect</th>
                <th>Raw Score</th>
                <th>Percentile</th>
                <th>Description</th>
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
                        <!-- <td><?php echo htmlspecialchars($record['id']); ?></td> -->
                        <td><?= $fullname ?></td>
                        <td class="editable" onclick="makeEditable(this, 'name_of_test', <?php echo $record['id']; ?>)"><?php echo htmlspecialchars($record['name_of_test']); ?></td>
                        <td class="editable" onclick="makeEditable(this, 'date', <?php echo $record['id']; ?>)"><?php echo htmlspecialchars($record['date']); ?></td>
                        <td class="editable" onclick="makeEditable(this, 'dimension_aspect', <?php echo $record['id']; ?>)"><?php echo htmlspecialchars($record['dimension_aspect']); ?></td>
                        <td class="editable" onclick="makeEditable(this, 'raw_score', <?php echo $record['id']; ?>)"><?php echo htmlspecialchars($record['raw_score']); ?></td>
                        <td class="editable" onclick="makeEditable(this, 'percentile', <?php echo $record['id']; ?>)"><?php echo htmlspecialchars($record['percentile']); ?></td>
                        <td class="editable" onclick="makeEditable(this, 'description', <?php echo $record['id']; ?>)"><?php echo htmlspecialchars($record['description']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Print Button -->
    <button onclick="printTable()">Print Records</button>

</body>

</html>