<?php
session_start();
include 'db.php'; // Include database connection

// Check if the ID is provided via GET for editing
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input

    // Fetch user data based on the ID
    $query = "SELECT * FROM user_data WHERE id = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); // Fetch user data

        if (!$user) {
            echo "User not found.";
            exit();
        }
    } else {
        echo "Database query error.";
        exit();
    }

    // Close the statement
    $stmt->close();
}

// If the form is submitted for updating user data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $course_section = mysqli_real_escape_string($con, $_POST['course_section']);
    $birth_order = mysqli_real_escape_string($con, $_POST['birth_order']);

    // Update the user data in the database
    $query = "UPDATE user_data SET email = ?, name = ?, course_section = ?, birth_order = ? WHERE id = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("ssssi", $email, $name, $course_section, $birth_order, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect back to admin page after successful update
            header("Location: admin_page.php");
            exit();
        } else {
            echo "Error: Could not update the user.";
        }
    } else {
        echo "Database query error.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection after all queries are done
$con->close();
?>

<!-- Edit User Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            margin-bottom: 20px;
            color: #4CAF50;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: left;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
            display: block;
        }

        input[type="email"],
        input[type="text"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-decoration: none;
            color: black;
            position: absolute;
            top: 20px;
            left: 40px;
        }

        .back-link svg {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>
<a href="cumulative_records.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Outer circle -->
        <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
        <!-- Inner arrow shape -->
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>

    <h1>Edit User Information</h1>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label for="course_section">Course Section:</label>
        <input type="text" name="course_section" id="course_section" value="<?php echo htmlspecialchars($user['course_section']); ?>" required>

        <label for="birth_order">Birth Order:</label>
        <input type="text" name="birth_order" id="birth_order" value="<?php echo htmlspecialchars($user['birth_order']); ?>" required>

        <button type="submit" name="update_user">Update User</button>
    </form>
</body>
</html>
