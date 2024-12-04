<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            height: 100vh;
            /* Sets the height to 100% of the viewport height */
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('images/RCS.png');
            /* Add your background image here */
            background-size: cover;
            /* Ensures the image covers the whole body */
            background-position: center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents image repetition */
            background-color: #f4f4f9;
            /* Fallback color for better aesthetics */
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8);
            /* Slightly transparent white for header */
            padding: 10px 20px;
            /* Adjust as needed */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }


        .logo {
            width: 100px;
            /* Adjust size as necessary */
            height: 100px;
            /* Make height equal to width for a perfect circle */
            margin: 0;
            /* Remove margin to ensure no space around the logo */
            border-radius: 50%;
            /* Makes the logo circular */
            overflow: hidden;
            /* Ensures that any overflow is hidden */
            display: flex;
            /* Center content within the circle */
            justify-content: center;
            /* Center content horizontally */
            align-items: center;
            /* Center content vertically */
            background-color: #f7f7f7;
            /* Optional: background color */
        }

        /* Optional: If you want to include an image inside the circle */
        .logo img {
            width: 100%;
            /* Ensure image fills the circle */
            height: auto;
            /* Maintain aspect ratio */
            object-fit: cover;
            /* Cover the circle without stretching */
            display: block;
            /* Prevents extra space below the image */
        }

        .profile-picture {
            position: relative;
            display: flex;
            align-items: center;
        }

        .profile-picture img {
            width: 40px;
            /* Adjust profile picture size */
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
            flex-grow: 1;
            /* Allow the header to grow and center */
            text-align: center;
            /* Center text in header */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0;
            /* Align to the right */
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
            background-color: #f1f1f1;
            /* Hover effect */
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

        /* Sidebar styling */
        .sidebar {
            position: fixed;
            top: 150px;
            /* Adjust this based on your header height */
            left: 0;
            width: 250px;
            /* Sidebar width */
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            height: 500px;
            /* Subtract the header height to avoid overlap */
            overflow-y: auto;
            /* Make the sidebar scrollable */
            font-size: 14px;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .logo {
                max-width: 80px;
                /* Adjust for smaller screens */
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
            font-size: 0.5em;
            /* Adjust this value as needed for the desired size */
            margin: 0;
            /* Remove default margin */
            line-height: 1;
            /* Control spacing between lines if necessary */
        }

        .notif {
            width: 75px;
            height: 75px;
        }

        .notif {
            width: 50px;
            height: 50px;
            cursor: pointer;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            width: 80%;
            max-height: 80%;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .modal-content h1 {
            text-align: center;
            color: #28a745;
            padding: 20px;
            margin: 0;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            color: #888;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #000;
        }

        .scrollable {
            padding: 20px;
        }

        .scrollable .announcement {
            border-bottom: 1px solid #ddd;
            padding: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .scrollable .announcement:last-child {
            border-bottom: none;
        }

        .scrollable .announcement img {
            max-width: 120px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .scrollable .announcement-content {
            flex: 1;
        }

        .scrollable .announcement-content h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .scrollable .announcement-content p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }

        .scrollable .announcement-content .meta {
            font-size: 12px;
            color: #888;
        }

        .scrollable::-webkit-scrollbar {
            width: 8px;
        }

        .scrollable::-webkit-scrollbar-thumb {
            background-color: #28a745;
            border-radius: 4px;
        }

        .scrollable::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .no-announcements {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <img src="images/main.png" alt="Your Logo" class="logo">
        </div>
        <h1 onclick="toggleDropdown()" class="student-dashboard">
            <p class="small-text">click to view settings</p>Student Dashboard
        </h1>
        <div class="profile-picture">
            <div id="dropdownContent" class="dropdown-content">
                <a href="account_settings.php">Profile Settings</a>
                <form action="account_settings.php" method="post">
                    <input type="submit" id="logout" name="logout" value="Logout" style="width: 100%; padding: 10px; border: none; background-color: #f44336; color: white; border-radius: 5px; cursor: pointer;">
                </form>
            </div>
        </div>
        <div>
            <img src="images/notif.png" alt="Notification Icon" class="notif" id="notif-icon">
        </div>
        <div>
            <img src="images/srb.png" alt="Your Logo" class="logo">
        </div>

    </header>
    <!-- <div class="sidebar">
        <h2>Instructions</h2>
        <p>To fully utilize the system, both the <strong><a href="cumulative_record.php">Cumulative Record</a>
            </strong> and the <strong><a href="personal_info_form.php">Problem Checklist</a></strong> need to be completed. While you can still access the <strong>Testing Service</strong>, please note the following:</p>
        <ul>
            <li>You can access the Testing Service even if the forms are incomplete.</li>
            <li>However, the teacher will not be able to input any data or proceed with further actions until both records are fully completed.</li>
        </ul>
        <p>Ensure that both forms are filled out accurately to enable full functionality of the portal.</p>
        <p>If you have any questions or need assistance, please contact the support team.</p>
    </div> -->




    <!-- Modal -->
    <div class="modal" id="announcement-modal">
        <div class="modal-content">
            <span class="close-btn" id="close-modal">&times;</span>

            <?php include 'user_announce.php'; ?>
        </div>
    </div>
    <h1 class="welcome">Bulsu SRC Guidance and Counseling Services Center Portal
    </h1>

    <!-- Button Section -->
    <div class="button-container">
        <button onclick="location.href='services.html'">SERVICES OFFERED</button>
        <button onclick="location.href='cumulative_record.php'">CUMULATIVE RECORD</button>
        <button id="problem-checklist-btn" onclick="location.href='personal_info_form.php'">PROBLEM CHECKLIST</button>
        <button onclick="location.href='testing_service.php'">TESTING SERVICE</button>
        <button onclick="location.href='contactus.html'">CONTACT US</button>
    </div>

    <script>
        // Function to check if the service is available
function checkServiceAvailability() {
    // Fetch the restriction date from the backend
    fetch('get_restriction_date.php')
        .then(response => response.json())
        .then(data => {
            const restrictionDate = new Date(data.restriction_date);
            const currentDate = new Date();

            if (currentDate < restrictionDate) {
                // Disable the button and show the message
                document.getElementById('problem-checklist-btn').disabled = true;
                document.getElementById('problem-checklist-btn').innerText = `Services will resume on ${restrictionDate.toLocaleString()}`;
                document.getElementById('problem-checklist-btn').onclick = function() {
                    alert("Services will resume on " + restrictionDate.toLocaleString());
                };
            }
        });
}

// Call the function to check availability when the page loads
checkServiceAvailability();






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


        const notifIcon = document.getElementById('notif-icon');
        const modal = document.getElementById('announcement-modal');
        const closeModal = document.getElementById('close-modal');

        // Open modal on click
        notifIcon.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        // Close modal on click
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close modal on outside click
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>

</html>