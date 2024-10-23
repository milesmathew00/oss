<?php
session_start(); // Start the session

include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get confirmation code from the form
    $userConfirmationCode = $_POST['confirmation_code'];

    // Check if the confirmation code is not empty
    if (!empty($userConfirmationCode)) {
        // Check confirmation code in a case-insensitive manner
        $checkCodeQuery = "SELECT * FROM user WHERE forgot_password_code = '$userConfirmationCode'";
        
        $result = mysqli_query($con, $checkCodeQuery);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Store the confirmation code in the session
                $_SESSION['reset_password_code'] = $userConfirmationCode;

                // Redirect to reset_password.html
                header("Location: reset_password.html");
                exit();
            } else {
                $invalidCode = true;
            }
        } else {
            $errorMessage = "Query failed - " . mysqli_error($con);
        }
    } else {
        $errorMessage = "Please enter a confirmation code";
    }
}

// Close the database connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Account</title>
    <style>
      body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #046c2d;
        }

        label {
            margin-bottom: 10px;
            display: block;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #046c2d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #044a1c;
        }

        img {
            width: 100px; /* Adjust as needed */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <img src="images/logo.jpg" alt="Logo">
    
    <?php if (isset($invalidCode) && $invalidCode) { ?>
        echo '<script>alert("Invalid Code");window.location.href = "confirm_account_forgot.php";</script>';
    <?php } 
    else { ?>
        <h1>Verify Your Account</h1>
        <form action="confirm_account_forgot.php" method="POST">
            <label for="confirmation_code">Confirmation Code:</label>
            <input type="text" name="confirmation_code" required>
            <button type="submit">Confirm Account</button>
        </form>
    <?php } ?>
</div>
</body>
</html>
