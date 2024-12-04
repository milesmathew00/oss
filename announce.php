<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .form-container {
            background-color: #28a745;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            width: 900px;
        }

        .form-container textarea,
        .form-container input[type="file"],
        .form-container input[type="datetime-local"],
        .form-container button {
            width: 95%;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 16px;
        }

        .form-container textarea {
            resize: none;
            height: 100px;
        }

        .form-container button {
            background-color: #d4ff00;
            color: black;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .form-container button:hover {
            background-color: #c4ef00;
        }
    </style>
</head>

<body>
    <div id="backButtonContainer">
        <a href="admin_page.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
            <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
                <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <div>
        <form class="form-container" action="submit_announcement.php" method="POST" enctype="multipart/form-data">
            <textarea name="announcement_text" placeholder="Type your announcement here..." required></textarea>
            <input type="file" name="image" accept="image/*">
            <label for="scheduled_at" style="color: white;">Schedule Post:</label>
            <input type="datetime-local" name="scheduled_at">
            <button type="submit">SUBMIT</button>
        </form><br></br>
    </div>
    <div>
        <?php include 'fetch_announcements.php'; ?>

    </div>
</body>

</html>