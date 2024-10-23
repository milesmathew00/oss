<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        
        body {
            height: 100vh; /* Sets the height to 100% of the viewport height */
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('images/RCS.png'); /* Add your background image here */
            background-size: cover; /* Ensures the image covers the whole body */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents image repetition */
            background-color: #f4f4f9; /* Fallback color for better aesthetics */
        }

        header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white for header */
    padding: 10px 20px; /* Adjust as needed */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}


        .logo {
    width: 100px; /* Adjust size as necessary */
    height: 100px; /* Make height equal to width for a perfect circle */
    margin: 0; /* Remove margin to ensure no space around the logo */
    border-radius: 50%; /* Makes the logo circular */
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
    display: block; /* Prevents extra space below the image */
}
        .profile-picture {
            position: relative;
            display: flex;
            align-items: center;
        }

        .profile-picture img {
            width: 40px; /* Adjust profile picture size */
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            margin-left: 10px;
        }

        h1.student-dashboard {
            font-size: 1.5rem;
            cursor: pointer;
            margin: 0;
            padding: 0 10px;
            flex-grow: 1; /* Allow the header to grow and center */
            text-align: center; /* Center text in header */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0; /* Align to the right */
        }

        .dropdown-content a,
        .dropdown-content form {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .dropdown-content a:hover,
        .dropdown-content form input:hover {
            background-color: #f1f1f1; /* Hover effect */
        }

        .show {
            display: block;
        }

        h1.welcome {
            text-align: center;
            margin-top: 20px;
            font-size: 2rem;
            color: beige;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        button {
            background-color: #211ACA;
            color: white;
            padding: 15px 20px;
            margin: 0 10px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #211A91;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logo {
                max-width: 80px; /* Adjust for smaller screens */
            }

            .profile-picture img {
                width: 35px;
                height: 35px;
            }

            h1.welcome {
                font-size: 1.5rem;
                
            }

            button {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
        .small-text {
    font-size: 0.5em; /* Adjust this value as needed for the desired size */
    margin: 0; /* Remove default margin */
    line-height: 1; /* Control spacing between lines if necessary */
}

    </style>
</head>
<body>
<header>
    <div>
        <img src="images/srb.png" alt="Your Logo" class="logo">
    </div>
    <h1 onclick="toggleDropdown()" class="student-dashboard"><p class="small-text">click to view settings</p>Student Dashboard</h1>
    <div class="profile-picture">
        <div id="dropdownContent" class="dropdown-content">
            <a href="account_settings.php">Profile Settings</a>
            <form action="account_settings.php" method="post">
                <input type="submit" id="logout" name="logout" value="Logout" style="width: 100%; padding: 10px; border: none; background-color: #f44336; color: white; border-radius: 5px; cursor: pointer;">
            </form>
        </div>
    </div>
    <div>
        <img src="images/main.png" alt="Your Logo" class="logo">
    </div>
</header>

<h1 class="welcome">Bulsu SRC Guidance and Counseling Services Center Portal
</h1>

<!-- Button Section -->
<div class="button-container">
    <button onclick="location.href='cumulative_record.php'">CUMULATIVE RECORD</button>
    <button onclick="location.href='personal_info_form.php'">PROBLEM CHECKLIST</button>
    <button onclick="location.href='testing_service.php'">TESTING SERVICE</button>
</div>

<script>
    function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdownContent");
        dropdownContent.classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.profile-picture img') && !event.target.matches('.student-dashboard')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
</body>
</html>
