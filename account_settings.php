<?php
session_start();


if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: signin.html");
    exit();
}


include 'db.php';


$userId = $_SESSION['user_id'];


$query = "SELECT * FROM `user` WHERE `user_id` = $userId";
$result = mysqli_query($con, $query);


if ($result) {

    $userData = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
} else {

    die("Query failed: " . mysqli_error($con));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['upload_photo'])) {


        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {

            $uploadDirectory = 'images/';


            $fileName = uniqid('photo_') . '_' . basename($_FILES["profile_picture"]["name"]);


            $filePath = $uploadDirectory . $fileName;


            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $filePath)) {

                $userId = $_SESSION['user_id'];
                $updateQuery = "UPDATE user SET profile_picture = '$fileName' WHERE user_id = $userId";

                if (mysqli_query($con, $updateQuery)) {


                    echo '<script>alert("Profile picture uploaded successfully!");window.location.href = "account_settings.php";</script>';
                } else {

                    echo "Error updating profile picture in the database: " . mysqli_error($con);
                }
            } else {

                echo "Error uploading file.";
            }
        } else {


            echo '<script>alert("Please select a file.")</script>';
        }
    } elseif (isset($_POST['change_password'])) {

        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];


        if ($userData['password'] === $currentPassword) {

            if (!empty($newPassword)) {
                $updatePasswordQuery = "UPDATE user SET password = '$newPassword' WHERE user_id = $userId";

                if (mysqli_query($con, $updatePasswordQuery)) {


                    echo '<script>alert("Password changed successfully!")</script>';
                } else {

                    echo "Error updating password in the database: " . mysqli_error($con);
                }
            } else {


                echo '<script>alert("Please enter a new password.")</script>';
            }
        } else {


            echo '<script>alert("Current password is incorrect.")</script>';
        }
    } elseif (isset($_POST['change_account_info'])) {






        $newFirstName = $_POST['first_name'];
        $newLastName = $_POST['last_name'];
        $newSubject = $_POST['subject'];
        $newEmail = $_POST['email'];
        $newAddress = $_POST['address'];



        $updateAccountQuery = "UPDATE user SET 
            first_name = '$newFirstName',
            last_name = '$newLastName',
            email = '$newEmail',
            subject = '$newSubject',
            address = '$newAddress'
            WHERE user_id = $userId";

        if (mysqli_query($con, $updateAccountQuery)) {

            echo '<script>alert("Account information updated successfully!");window.location.href = "account_settings.php";</script>';
        } else {

            echo "Error updating account information in the database: " . mysqli_error($con);
        }
    } elseif (isset($_POST['logout'])) {

        $_SESSION = array();


        session_destroy();


        header("Location: signin.html");
        exit();
    }
}


// mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            margin-top: 20px;
            color: #555;
        }

        form {
            margin-top: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Style for the profile picture */
        img {
            max-width: 100%;
            height: auto;
            cursor: pointer;
            border-radius: 50%;
            /* Optional: makes the profile picture circular */
            border: 2px solid #ddd;
            /* Optional: adds a border around the image */
            display: block;
            /* Ensures the image is displayed as a block element */
            margin: 0 auto;
            /* Centers the image */
        }

        /* Full screen styling */
        .fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            cursor: pointer;
        }

        .fullscreen img {
            max-width: 90%;
            max-height: 90%;
        }

        .exit-button:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .arrow-link {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: black;
        }
    </style>


    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Password is not match");
                return false;
            }

            return true;
        }
    </script>




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


    <main>
        <h1>Account Settings</h1>
        <p>Change your account settings</p>
        <div>
            <div>
                <!-- Display Profile Picture -->
                <?php if ($userData['profile_picture']) : ?>
                    <!-- Add an onclick event to open the image in full screen -->
                    <img src="images/<?php echo $userData['profile_picture']; ?>" alt="Profile Picture" onclick="openFullScreen(this)">
                <?php endif; ?>

                <button class="exit-button" onclick="exitFullScreen()">X</button>
                <!-- Profile Picture Upload/Change -->
                <form action="account_settings.php" method="post" enctype="multipart/form-data">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" name="profile_picture" accept="image/*">
                    <input type="submit" name="upload_photo" value="Upload/Change Profile Picture">
                </form>
                <h2>Account</h2>
                <form action="account_settings.php" method="post">
                    <div>
                        <div>
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="<?php echo $userData['first_name']; ?>" required>
                        </div>
                        <div>
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" value="<?php echo $userData['last_name']; ?>" required>

                        </div>
                        <div><label for="email">Email:</label>
                            <input type="email" name="email" value="<?php echo $userData['email']; ?>" required readonly>
                        </div>

                    </div>
            </div>
            <div>
                <h2>General Info</h2>
                <div>

                    <div>
                        <label for="address">Address:</label>
                        <input type="text" name="address" value="<?php echo $userData['address']; ?>" required>
                    </div><br>
                    <div><input type="submit" class="b" name="change_account_info" value="Save Changes"></div>
                </div>
            </div>
        </div>
        </form>
        <form method="POST">
            <div>
                <h2>Password</h2>
                <div>
                    <div>
                        <label for="current_password">Current Password:</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div>
                        <label for="new_password">New Password:</label>
                        <input type="password" id="password" name="new_password" required><br>
                    </div>
                    <div>
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
            </div>
            <div>
                <input type="submit" class="b" name="change_password" value="Change Password" onclick="return validatePassword();">

            </div>
        </form>
        <form action="account_settings.php" method="post">
            <input type="submit" id="logout" name="logout" value="Logout">
        </form>
    </main>

    <!-- Logout Button -->

    <script>
        function openFullScreen(image) {

            if (image.requestFullscreen) {
                image.requestFullscreen();
            } else if (image.mozRequestFullScreen) {
                /* Firefox */
                image.mozRequestFullScreen();
            } else if (image.webkitRequestFullscreen) {
                /* Chrome, Safari and Opera */
                image.webkitRequestFullscreen();
            } else if (image.msRequestFullscreen) {
                /* IE/Edge */
                image.msRequestFullscreen();
            }


            document.querySelector('.exit-button').style.display = 'block';
        }

        function exitFullScreen() {

            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                /* Firefox */
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                /* Chrome, Safari and Opera */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                /* IE/Edge */
                document.msExitFullscreen();
            }


            document.querySelector('.exit-button').style.display = 'none';
        }
    </script>
</body>

</html>