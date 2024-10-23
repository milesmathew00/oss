<?php
include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get confirmation code from the form
    $userConfirmationCode = mysqli_real_escape_string($con, $_POST['confirmation_code']);

    // Check if the confirmation code is not empty
    if (!empty($userConfirmationCode)) {
        // Check if the confirmation code exists in the database
        $checkCodeQuery = "SELECT * FROM user WHERE confirmation_code = '$userConfirmationCode'";
        $result = mysqli_query($con, $checkCodeQuery);

        if ($result && mysqli_num_rows($result) > 0) {
            // Update confirmation status to 'confirmed'
            $updateStatusQuery = "UPDATE user SET confirmation_status = 'confirmed' WHERE confirmation_code = '$userConfirmationCode'";
            if (mysqli_query($con, $updateStatusQuery)) {
                echo '<script>alert("Account confirmed!");</script>';
                // Redirect to signin.html
                echo '<script>window.location.href = "signin.html";</script>';
                exit; // Ensure no further code is executed
            } else {
                echo "Error updating confirmation status: " . mysqli_error($con);
            }
        } else {
            echo '<script>alert("Invalid or already confirmed confirmation code");</script>';
        }
    } else {
        echo '<script>alert("Please enter a confirmation code");</script>';
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

        .container {
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

        @media (max-width: 480px) {
            h1 {
                font-size: 20px;
            }
            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="images/logo.jpg" alt="Logo">
        <h1>Verify Your Account</h1>
        <form action="confirm_account.php" method="POST">
            <label for="confirmation_code">Confirmation Code:</label>
            <input type="text" name="confirmation_code" required>
            <button type="submit">Confirm Account</button>
        </form>
    </div>
</body>
</html>
