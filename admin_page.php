<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url('images/MTG.png'); /* Add your background image here */
            background-size: cover; /* Ensures the image covers the whole body */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents image repetition */
            height: 100vh; /* Sets the height to 100% of the viewport height */
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white for header */
            padding: 15px 30px; /* Increase padding for more space */
            width: 95%; /* Ensures header spans the entire width of the viewport */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 100px; /* Adjust size as necessary */
            height: 100px; /* Make height equal to width for a perfect circle */
            margin: 5px; /* Space around logos */
            border-radius: 50%; /* This should be border-radius, not radius */
            overflow: hidden; /* Ensures that any overflow is hidden */
            display: flex; /* Center content within the circle */
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            background-color: #f7f7f7; /* Optional: background color */
        }

        /* Optional: If you want to include an image inside the circle */
        .logo img {
            width: 100%; /* Ensure image fills the circle */
            height: auto; /* Maintain aspect ratio */
            object-fit: cover; /* Cover the circle without stretching */
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .container {
            text-align: center;
            margin-top: 50px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
            width: 60%;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .container h1 {
            margin-bottom: 40px;
            color: #333;
            font-size: 2.2rem;
        }

        .button-group {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .dashboard-button {
            padding: 15px 25px;
            background-color: #211ACA;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
            width: 180px;
            text-align: center;
        }

        .dashboard-button:hover {
            background-color: #211A91;
            transform: translateY(-2px);
        }

        .action-buttons {
            display: none; /* Initially hidden */
            margin-top: 20px;
        }

        .action-button {
            padding: 10px 15px;
            background-color: #007BFF; /* Bootstrap primary color */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            transition: background-color 0.3s;
        }

        .action-button:hover {
            background-color: #0056b3; /* Darker shade */
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0; /* Align to the right */
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .show {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 80%;
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
                gap: 20px;
            }

            .dashboard-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="images/logo.jpg" alt="Your Logo" class="logo">
        </div>
        <div class="dropdown">
            <h1 onclick="toggleDropdown()">Welcome to the Admin Dashboard</h1>
            <div id="myDropdown" class="dropdown-content">
                <form action="admin_page.php" method="post">
                    <input type="submit" name="logout" value="Logout" class="logout-button">
                </form>
            </div>
        </div>
        <div>
            <img src="images/bsu.jpg" alt="Your Logo" class="logo">
        </div>
    </header>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="button-group">
            <a href="#" class="dashboard-button" onclick="toggleActionButtons('testing-service')">Testing Service</a>
            <a href="admin_display_selections.php" class="dashboard-button">Mooney Checklist</a>
            <a href="cumulative_records.php" class="dashboard-button">Cumulative Record</a>
            <a href="slip.php" class="dashboard-button">Call Slip</a>
        </div>

        <div id="testing-service" class="action-buttons">
            <a href="admin_input.php" class="action-button">INSERT</a>
            <a href="edit_test_data.php" class="action-button">EDIT/DELETE</a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown h1')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        function toggleActionButtons(service) {
            const actionButtons = document.getElementById(service);
            if (actionButtons.style.display === "none" || actionButtons.style.display === "") {
                actionButtons.style.display = "block"; // Show action buttons
            } else {
                actionButtons.style.display = "none"; // Hide action buttons
            }
        }
    </script>
</body>
</html>
