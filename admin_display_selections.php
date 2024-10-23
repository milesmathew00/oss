<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Selections</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #211ACA;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .filter-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        select {
            padding: 5px;
            margin-right: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
    include 'db.php'; // Make sure your database connection is included

    // Initialize filter variables
    $filter_course_section = isset($_GET['course_section']) ? $_GET['course_section'] : 'All';
    $filter_year_level = isset($_GET['year_level']) ? $_GET['year_level'] : 'All';

    // Build the base SQL query to get only users who submitted the form
    $query = "SELECT u.user_id, u.first_name, u.last_name, s.course_section, s.year_level 
              FROM user u 
              JOIN selections s ON u.user_id = s.user_id 
              WHERE 1=1";

    // Add course section filter to the query if not 'All'
    if ($filter_course_section != 'All') {
        $query .= " AND s.course_section = '" . mysqli_real_escape_string($con, $filter_course_section) . "'";
    }

    // Add year level filter to the query if not 'All'
    if ($filter_year_level != 'All') {
        $query .= " AND s.year_level = '" . mysqli_real_escape_string($con, $filter_year_level) . "'";
    }

    // Execute the query
    $result = mysqli_query($con, $query);
?>
<a href="admin_page.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>
<br><br><br>

<center><h1>Admin - Mooney Assessment Test</h1></center>

<form method="GET" action="admin_display_selections.php" class="filter-form">
    <div>
        <label for="course_section">Filter by Course & Section:</label>
        <select name="course_section" id="course_section">
            <option value="All" <?php if ($filter_course_section == 'All') echo 'selected'; ?>>Filter All</option>
            <?php
            // Fetch the course sections from the selections table
            $course_sections_query = "SELECT DISTINCT course_section FROM selections";
            $course_sections_result = mysqli_query($con, $course_sections_query);
            while ($row = mysqli_fetch_assoc($course_sections_result)) {
                $section = htmlspecialchars($row['course_section']);
                echo "<option value='$section' " . ($filter_course_section == $section ? 'selected' : '') . ">$section</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="year_level">Filter by Year Level:</label>
        <select name="year_level" id="year_level">
            <option value="All" <?php if ($filter_year_level == 'All') echo 'selected'; ?>>Filter All</option>
            <option value="1" <?php if ($filter_year_level == '1') echo 'selected'; ?>>1</option>
            <option value="2" <?php if ($filter_year_level == '2') echo 'selected'; ?>>2</option>
            <option value="3" <?php if ($filter_year_level == '3') echo 'selected'; ?>>3</option>
            <option value="4" <?php if ($filter_year_level == '4') echo 'selected'; ?>>4</option>
            <!-- Add more year levels as needed -->
        </select>
    </div>
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course & Section</th>
            <th>Year Level</th>
            <th>View Selection</th>
        </tr>
    </thead>
    <tbody>
        <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['user_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['course_section']) . '</td>';
                echo '<td>' . htmlspecialchars($row['year_level']) . '</td>';
                echo '<td><a href="view_user_selections.php?user_id=' . $row['user_id'] . '">View Selection</a></td>';
                echo '</tr>';
            }
        ?>
    </tbody>
</table>

<?php
// Query for Top 20 Concerns - counting unique user selections
$query_top_20 = "SELECT ac.concern, COUNT(DISTINCT s.user_id) AS selection_count 
                 FROM aggregated_concerns ac 
                 JOIN selections s ON FIND_IN_SET(ac.concern, s.top_20) > 0
                 WHERE 1=1";

// Add course section filter if a specific course section is selected
if ($filter_course_section != 'All') {
    $query_top_20 .= " AND s.course_section = '" . mysqli_real_escape_string($con, $filter_course_section) . "'";
}

$query_top_20 .= " GROUP BY ac.concern 
                   ORDER BY selection_count DESC 
                   LIMIT 20";

// Query for Top 5 Concerns - counting unique user selections
$query_top_5 = "SELECT ac.concern, COUNT(DISTINCT s.user_id) AS selection_count 
                FROM aggregated_concerns ac 
                JOIN selections s ON FIND_IN_SET(ac.concern, s.top_5) > 0
                WHERE 1=1";

// Add course section filter if a specific course section is selected
if ($filter_course_section != 'All') {
    $query_top_5 .= " AND s.course_section = '" . mysqli_real_escape_string($con, $filter_course_section) . "'";
}

$query_top_5 .= " GROUP BY ac.concern 
                  ORDER BY selection_count DESC 
                  LIMIT 5";

// Execute the queries
$result_top_20 = mysqli_query($con, $query_top_20);
$result_top_5 = mysqli_query($con, $query_top_5);

// Check for query execution errors
if (!$result_top_20) {
    die("Query failed for Top 20 concerns: " . mysqli_error($con));
}

if (!$result_top_5) {
    die("Query failed for Top 5 concerns: " . mysqli_error($con));
}

// Display Top 20 Concerns
echo '<h2>Most Common Top 20 Concerns for Course Section: ' . htmlspecialchars($filter_course_section) . '</h2>';
echo '<table>';
echo '<tr><th>Concern</th><th>Selection Count</th></tr>';
while ($row = mysqli_fetch_assoc($result_top_20)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['concern']) . '</td>';
    echo '<td>' . htmlspecialchars($row['selection_count']) . '</td>';
    echo '</tr>';
}
echo '</table>';

// Display Top 5 Concerns
echo '<h2>Most Common Top 5 Concerns for Course Section: ' . htmlspecialchars($filter_course_section) . '</h2>';
echo '<table>';
echo '<tr><th>Concern</th><th>Selection Count</th></tr>';
while ($row = mysqli_fetch_assoc($result_top_5)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['concern']) . '</td>';
    echo '<td>' . htmlspecialchars($row['selection_count']) . '</td>';
    echo '</tr>';
}
echo '</table>';

mysqli_close($con);
?>
<!-- Add this button somewhere in your HTML -->
<!-- Add this button inside your HTML -->
<a href="mooneypdf.php?course_section=<?php echo urlencode($filter_course_section); ?>&year_level=<?php echo urlencode($filter_year_level); ?>" class="btn" target="_blank">Generate PDF</a>



</body>
</html>
