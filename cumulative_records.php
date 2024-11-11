<?php
session_start();
include 'db.php';

// Check if the logout request is made
if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: signin.html");
    exit();
}

// Initialize filter variables
$filter_course_section = isset($_GET['course_section']) ? mysqli_real_escape_string($con, $_GET['course_section']) : '';
$filter_birth_order = isset($_GET['birth_order']) ? mysqli_real_escape_string($con, $_GET['birth_order']) : '';
$filter_monthly_income = isset($_GET['monthly_income']) ? mysqli_real_escape_string($con, $_GET['monthly_income']) : '';
$filter_religion = isset($_GET['religion']) ? mysqli_real_escape_string($con, $_GET['religion']) : '';
$filter_number_of_siblings = isset($_GET['number_of_siblings']) ? mysqli_real_escape_string($con, $_GET['number_of_siblings']) : '';
$filter_marriage_status = isset($_GET['marriage_status']) ? mysqli_real_escape_string($con, $_GET['marriage_status']) : '';

// Query to get distinct course sections
$course_query = "SELECT DISTINCT course_section FROM user_data ORDER BY course_section";
$course_result = mysqli_query($con, $course_query);
if (!$course_result) {
    die("Error fetching course sections: " . mysqli_error($con));
}

// Fetch course sections
$course_sections = [];
while ($row = mysqli_fetch_assoc($course_result)) {
    $course_sections[] = $row['course_section'];
}

// Query to get distinct religions
$religion_query = "SELECT DISTINCT religion FROM user_data ORDER BY religion";
$religion_result = mysqli_query($con, $religion_query);
if (!$religion_result) {
    die("Error fetching religions: " . mysqli_error($con));
}

// Fetch religions
$religions = [];
while ($row = mysqli_fetch_assoc($religion_result)) {
    $religions[] = $row['religion'];
}

// Create the base query
$query = "SELECT * FROM user_data WHERE 1";

// Append filters if selected
if ($filter_course_section && $filter_course_section != 'All') {
    $query .= " AND course_section = '$filter_course_section'";
}

if ($filter_birth_order && $filter_birth_order != 'All') {
    $query .= " AND birth_order = '$filter_birth_order'";
}

if ($filter_monthly_income && $filter_monthly_income != 'All') {
    $query .= " AND family_income = '$filter_monthly_income'";
}

if ($filter_religion && $filter_religion != 'All') {
    $query .= " AND religion = '$filter_religion'";
}

if ($filter_number_of_siblings && $filter_number_of_siblings != 'All') {
    $query .= " AND number_of_siblings = '$filter_number_of_siblings'";
}

if ($filter_marriage_status && $filter_marriage_status != 'All') {
    $query .= " AND marriage_status = '$filter_marriage_status'";
}

$result = mysqli_query($con, $query);
if (!$result) {
    die("Error fetching user data: " . mysqli_error($con));
}

// Close the connection after all queries are done
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #211ACA;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
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

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        select {
            padding: 5px;
            margin-right: 10px;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <header>
        <a href="admin_page.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
            <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Outer circle -->
                <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
                <!-- Inner arrow shape -->
                <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <h1>Cumulative Dashboard</h1>
    </header>
    <div class="container">
        <h1>Form Responses</h1>

        <!-- Button to View Chart -->
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="view_chart.php" class="button" style="padding: 10px 20px; background-color: #211ACA; color: white; text-decoration: none; border-radius: 5px;">View Dashboard</a>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="filter-form">
            <div>
                <label for="course_section">Filter by Course & Section:</label>
                <select name="course_section" id="course_section">
                    <option value="All" <?php if ($filter_course_section == 'All') echo 'selected'; ?>>Filter All</option>
                    <?php foreach ($course_sections as $section): ?>
                        <option value="<?php echo htmlspecialchars($section); ?>" <?php if ($filter_course_section == $section) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($section); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="birth_order">Filter by Birth Order:</label>
                <select name="birth_order" id="birth_order">
                    <option value="All" <?php if ($filter_birth_order == 'All') echo 'selected'; ?>>Filter All</option>
                    <option value="Only Child" <?php if ($filter_birth_order == 'Only Child') echo 'selected'; ?>>Only Child</option>
                    <option value="First Born" <?php if ($filter_birth_order == 'First Born') echo 'selected'; ?>>First Born</option>
                    <option value="Second Born" <?php if ($filter_birth_order == 'Second Born') echo 'selected'; ?>>Second Born</option>
                    <option value="Middle Born" <?php if ($filter_birth_order == 'Middle Born') echo 'selected'; ?>>Middle Born</option>
                    <option value="Youngest" <?php if ($filter_birth_order == 'Youngest') echo 'selected'; ?>>Youngest</option>
                </select>
            </div>

            <div>
                <label for="monthly_income">Filter by Monthly Income:</label>
                <select name="monthly_income" id="monthly_income">
                    <option value="All" <?php if ($filter_monthly_income == 'All') echo 'selected'; ?>>Filter All</option>
                    <option value="Less Than 11,6990.00PHP" <?php if ($filter_monthly_income == 'Less Than 11,6990.00PHP"') echo 'selected'; ?>>Less Than 11,6990.00PHP"</option>
                    <option value="23,381-46,761.00PHP" <?php if ($filter_monthly_income == '23,381-46,761.00PHP') echo 'selected'; ?>>Lower Middle Income Between 23,381-46,761.00PHP</option>
                    <option value="46,761.00PHP+" <?php if ($filter_monthly_income == '46,761.00PHP+"') echo 'selected'; ?>>Middle Upper Income of 46,761.00PHP</option>
                </select>
            </div>

            <div>
                <label for="religion">Filter by Religion:</label>
                <select name="religion" id="religion">
                    <option value="All" <?php if ($filter_religion == 'All') echo 'selected'; ?>>Filter All</option>
                    <?php foreach ($religions as $religion): ?>
                        <option value="<?php echo htmlspecialchars($religion); ?>" <?php if ($filter_religion == $religion) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($religion); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="number_of_siblings">Filter by Number of Siblings:</label>
                <select name="number_of_siblings" id="number_of_siblings">
                    <option value="All" <?php if ($filter_number_of_siblings == 'All') echo 'selected'; ?>>Filter All</option>
                    <option value="Only Child" <?php if ($filter_number_of_siblings == 'Only Child') echo 'selected'; ?>>Only Child</option>
                    <option value="1 Sibling" <?php if ($filter_number_of_siblings == '1 Sibling') echo 'selected'; ?>>1 Sibling</option>
                    <option value="2-4 Siblings" <?php if ($filter_number_of_siblings == '2-4 Siblings') echo 'selected'; ?>>2-4 Siblings</option>
                    <option value="5 or More" <?php if ($filter_number_of_siblings == '5 or More') echo 'selected'; ?>>5 or More</option>
                </select>
            </div>

            <div>
                <label for="marriage_status">Filter by Marriage Status:</label>
                <select name="marriage_status" id="marriage_status">
                    <option value="All" <?php if ($filter_marriage_status == 'All') echo 'selected'; ?>>Filter All</option>
                    <option value="Single" <?php if ($filter_marriage_status == 'Single') echo 'selected'; ?>>Single</option>
                    <option value="Married" <?php if ($filter_marriage_status == 'Married') echo 'selected'; ?>>Married</option>
                    <option value="Widowed" <?php if ($filter_marriage_status == 'Widowed') echo 'selected'; ?>>Widowed</option>
                    <option value="Separated" <?php if ($filter_marriage_status == 'Separated') echo 'selected'; ?>>Separated</option>
                </select>
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #211ACA; color: white; border: none; cursor: pointer;">Filter</button>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Course & Section</th>
                        <th>Birth Order</th>
                        <th>Family Income</th>
                        <th>Religion</th>
                        <th>Number of Siblings</th>
                        <th>Marriage Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_section']); ?></td>
                            <td><?php echo htmlspecialchars($row['birth_order']); ?></td>
                            <td><?php echo htmlspecialchars($row['family_income']); ?></td>
                            <td><?php echo htmlspecialchars($row['religion']); ?></td>
                            <td><?php echo htmlspecialchars($row['number_of_siblings']); ?></td>
                            <td><?php echo htmlspecialchars($row['marriage_status']); ?></td>
                            <td>
                                <a href="view_user.php?id=<?php echo $row['id']; ?>">View</a> |
                                <!-- <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> | -->
                                <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- <form method="POST">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form> -->
    </div>
</body>

</html>