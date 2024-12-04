<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch announcements
$sql = "SELECT id, announcement_text, image_path, scheduled_at, created_at, username FROM announcements ORDER BY created_at DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            overflow: hidden;
        }

        /* Scrollable announcement list */
        .scrollable {
            width: 70%;
            max-height: 600px;
            overflow-y: auto;
            border-right: 1px solid #ddd;
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

        .announcement {
            border-bottom: 1px solid #ddd;
            padding: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            position: relative;
        }

        .announcement:last-child {
            border-bottom: none;
        }

        .announcement img {
            max-width: 120px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .announcement-content {
            flex: 1;
        }

        .announcement-content h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .announcement-content p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }

        .announcement-content .meta {
            font-size: 12px;
            color: #888;
        }

        .announcement-content .meta span {
            margin-right: 10px;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
        }

        .delete-btn:hover {
            background-color: #e60000;
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
    <div class="container">
        <!-- Scrollable Announcement Section -->
        <div>
            <h1 style="text-align: center; color: #28a745; font-size: 24px;">Announcements</h1>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="announcement">


                        <!-- Image (if available) -->
                        <?php if (!empty($row['image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Announcement Image">
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="announcement-content">
                            <h3><?php echo htmlspecialchars($row['announcement_text']); ?></h3>
                            <p class="meta">
                                <span>Posted by: <?php echo htmlspecialchars($row['username']); ?></span>
                                <span>Created on: <?php echo date('F d, Y h:i A', strtotime($row['created_at'])); ?></span>
                                <?php if (!empty($row['scheduled_at'])): ?>
                                    <span>Scheduled for: <?php echo date('F d, Y h:i A', strtotime($row['scheduled_at'])); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-announcements">No announcements to display at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php $con->close(); ?>
</body>

</html>