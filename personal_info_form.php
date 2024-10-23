<?php
session_start();
include 'db.php';  // Include your database connection

// Ensure user_id is stored in session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Initialize variables
$top20_submitted = false;  
$top5_submitted = false;   
$course_section = ""; 
$year_level = ""; 
$top_20_concerns = [];  
$top_5_concerns = []; // To store Top 5 concerns after Top 20 submission

// Check if the user has already submitted the concerns
$query = "SELECT submitted, top_20, top_5 FROM selections WHERE user_id='$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    // Check if already submitted
    if ($row['submitted'] == 1) {
        header("Location: view_concern_form.php");
        exit;
    }
    // Load existing Top 20 concerns
    if (!empty($row['top_20'])) {
        $top_20_concerns = explode(',', $row['top_20']);
    }
}

// Function to update or insert into the aggregated_concerns table
function updateAggregatedConcerns($con, $concern) {
    $query_insert = "INSERT INTO aggregated_concerns (concern, selection_count) VALUES ('$concern', 1)
                     ON DUPLICATE KEY UPDATE selection_count = selection_count + 1";
    mysqli_query($con, $query_insert);
}

// Check if the form for course and year level is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_section'], $_POST['year_level'])) {
    $course_section = $_POST['course_section'];
    $year_level = $_POST['year_level'];

    // Save course and year level in selections
    $stmt = $con->prepare("INSERT INTO selections (user_id, course_section, year_level) VALUES (?, ?, ?)
                            ON DUPLICATE KEY UPDATE course_section=?, year_level=?");
    $stmt->bind_param("sssss", $user_id, $course_section, $year_level, $course_section, $year_level);

    if ($stmt->execute()) {
        // Course and year level saved successfully
    } else {
        echo "Error saving course and year level: " . mysqli_error($con);
    }
}

// Check if the form for Top 20 is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['concerns'])) {
    $selected_concerns = $_POST['concerns'];

    // Ensure the user selects exactly 20 concerns
    if (count($selected_concerns) === 20) {
        $top_20_concerns_str = implode(",", $selected_concerns);
        
        // Update or insert Top 20 concerns
        $stmt = $con->prepare("UPDATE selections SET top_20=?, submitted=0 WHERE user_id=?");
        $stmt->bind_param("ss", $top_20_concerns_str, $user_id);

        if ($stmt->execute()) {
            // Update aggregated concerns count for Top 20
            foreach ($selected_concerns as $concern) {
                updateAggregatedConcerns($con, mysqli_real_escape_string($con, $concern));
            }
            $top20_submitted = true;  // Mark as submitted

            // Fetch available concerns for Top 5 selection
            $query_top_5 = "SELECT concern FROM aggregated_concerns"; // Update this to your actual table
            $result_top_5 = mysqli_query($con, $query_top_5);
            while ($row_top_5 = mysqli_fetch_assoc($result_top_5)) {
                $top_5_concerns[] = $row_top_5['concern'];
            }
        } else {
            echo "Error updating concerns: " . mysqli_error($con);
        }
    } else {
        echo "You must select exactly 20 concerns.";
    }
}

// Check if the form for Top 5 is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_top_5'])) {
    $concerns_top_5 = $_POST['concerns_top_5'] ?? [];

    // Validate the number of selected concerns
    if (count($concerns_top_5) === 5) {
        $top_5_concerns_str = implode(",", $concerns_top_5);

        // Update selections safely using a prepared statement
        $stmt = $con->prepare("UPDATE selections SET top_5=?, submitted=1 WHERE user_id=?");
        $stmt->bind_param("ss", $top_5_concerns_str, $user_id);

        if ($stmt->execute()) {
            // Update aggregated concerns for the top 5
            foreach ($concerns_top_5 as $concern) {
                updateAggregatedConcerns($con, mysqli_real_escape_string($con, $concern));
            }
            $top5_submitted = true;  // Mark as submitted
          // Set the alert message in the session
    $_SESSION['alert_message'] = "Your response is already recorded.";

    // Redirect to a temporary page that displays the alert
    header("Location: alert.php"); // Create alert.php to handle this
    exit(); // Make sure to call exit after a header redirect
        } else {
            echo "Error updating top 5 concerns: " . mysqli_error($con);
        }
    } else {
        echo "You must select exactly 5 concerns.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FBFFEA; /* Light background */
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 30px;
        }
        .concern-list {
            max-height: 620px;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        a {
            position: absolute;
            top: 20px;
            left: 40px;
            text-decoration: none;
            color: black;
            transition: transform 0.2s; /* Add transition for hover effect */
        }

        a:hover {
            transform: scale(1.1); /* Slightly enlarge the icon on hover */
        }

        svg {
            display: block; /* Center the SVG */
            margin: 0 auto; /* Center the SVG horizontally */
        }

        form {
            background-color: white; /* White background for form */
            padding: 20px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            max-width: 1200px; /* Limit width */
            margin: 20px auto; /* Center form on the page */
        }

        label {
            display: block;
            margin-bottom: 10px; /* Spacing between labels */
            font-weight: bold; /* Bold labels */
        }

        input[type="text"] {
            width: 100%; /* Full width input */
            padding: 10px; /* Padding for input */
            margin-bottom: 15px; /* Space below inputs */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
            box-sizing: border-box; /* Include padding in width */
        }

        button {
            background-color: #2219A8 ; /* Green button */
            color: white; /* White text */
            padding: 10px 15px; /* Padding for button */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            width: 100%; /* Full width button */
            font-size: 16px; /* Increase font size */
            transition: background-color 0.3s; /* Transition for hover effect */
        }

        button:hover {
            background-color:#89C8FD; /* Darker green on hover */
        }
    </style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to validate Top 20 concerns selection
        function validateTop20() {
            const concerns = document.querySelectorAll('input[name="concerns[]"]:checked');
            if (concerns.length !== 20) {
                alert("Please select exactly 20 concerns.");
                return false;
            }
            const confirmation = confirm("Are you sure you want to submit your top 20 concerns?");
            return confirmation;
        }

        // Function to validate Top 5 concerns selection
        function validateTop5() {
    const checkboxes = document.querySelectorAll('input[name="concerns_top_5[]"]:checked');
    if (checkboxes.length !== 5) {
        alert('Please select exactly 5 concerns.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

        // Function to count selected concerns for Top 20
        function updateTop20Counter() {
            const selectedConcerns = document.querySelectorAll('input[name="concerns[]"]:checked');
            const counter = document.getElementById('top20Counter');
            counter.textContent = selectedConcerns.length;

            if (selectedConcerns.length > 20) {
                alert("You cannot exceed 20 concerns. Please deselect some choices.");
                selectedConcerns[selectedConcerns.length - 1].checked = false;
            }
        }

        // Function to count selected concerns for Top 5
        function updateTop5Counter() {
            const selectedConcerns = document.querySelectorAll('input[name="concerns_top_5[]"]:checked');
            const counter = document.getElementById('top5Counter');
            counter.textContent = selectedConcerns.length;

            if (selectedConcerns.length > 5) {
                alert("You cannot exceed 5 concerns. Please deselect some choices.");
                selectedConcerns[selectedConcerns.length - 1].checked = false;
            }
        }

        // Add event listeners to the checkboxes for Top 20 concerns
        document.querySelectorAll('input[name="concerns[]"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', updateTop20Counter);
        });

        // Add event listeners to the checkboxes for Top 5 concerns
        document.querySelectorAll('input[name="concerns_top_5[]"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', updateTop5Counter);
        });
    });
    </script>

</head>
<body>
    <a href="homepage.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Outer circle -->
        <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
        <!-- Inner arrow shape -->
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>
   <center><h1>Personal Information Form</h1></center>

 

   <?php if (!$top20_submitted): ?>
    <form action="" method="POST" onsubmit="return validateTop20() && confirmSubmit();">
        <center><h2>Please Select Top 20 Concerns</h2></center>
    <div class="concern-list">
        <!-- Input for Course & Section -->
        <label>Course & Section:
            <input type="text" name="course_section" required>
        </label>

        <!-- Input for Year Level -->
        <label>Year Level:
            <input type="text" name="year_level" required>
        </label>
            <?php
                // List of concerns
                $concerns = [
                    "1.Feeling tired much of the time", "2.Going into debt for college expenses", "3.Not enough time for recreation",
                    "4.Losing friends", "5.Taking things too seriously", "6.Forgetting things I’ve learned in school",
                    "7.Restless at delay in starting life work", "8.College too indifferent to student needs", "9.Being underweight",
                    // Add all 200 concerns here...
                    "10.Graduation threatened by lack of funds",
"11.Too little chance to get into sports",
"12.Wanting to be more popular",
"13.Worrying about unimportant things",
"14.Getting low grades",
"15.Doubting wisdom of my vocational choice",
"16.Dull classes",
"17.Being overweight",
"18.Needing money for graduate training",
"19.Too little chance to enjoy art or music",
"20.Being left out of things",
"21.Nervousness",
"22.Weak in writing",
"23.Purpose in going to college not clear",
"24.Too many poor teachers",
"25.Not getting enough exercise",
"26.Too many financial problems",
"27.Too little chance to enjoy radio or television",
"28.Having feelings of extreme loneliness",
"29.Finding it difficult to relax",
"30.Weak in spelling or grammar",
"31.Doubting the value of a college degree",
"32.Teacher lacking grasp of subject matter",
"33.Not getting enough sleep",
"34.Too little money for clothes",
"35.Too little time to myself",
"36.Being timid or shy",
"37.Moodiness, “having the blues”",
"38.Slow in reading",
"39.Unable to enter desired vocation",
"40.Teachers lacking personality",
"41.Not as strong and healthy as I should be",
"42.Receiving too little help from home",
"43.Not using my leisure time well",
"44.Being ill at ease with other people",
"45.Failing in so many thing I try to do",
"46.Not knowing how to study effectively",
"47.Enrolled in the wrong curriculum",
"48.Hard to study in living quarters",
"49.Allergies (hay fever, asthma, hives, etc.)",
"50.Having less money than my friends",
"51.Wanting more change for self-expression",
"52.Having no close friends in college",
"53.Too easily discouraged",
"54.Easily distracted from my work",
"55.Wanting to change to another college",
"56.Teacher too hard to understand",
"57.Occasional pressure and pain in my head",
"58.Managing my finances poorly",
"59.Missing someone back home",
"60.Having bad luck",
"61.Not planning my work ahead",
"62.Wanting part-time experience in my field",
"63.Textbooks too hard to understand",
"64.Not getting enough outdoor air and sunshine",
"65.Needing a part-time job now",
"66.Sometimes wishing Id never been born",
"67.Having a poor background for some subjects",
"68.Doubting college prepares me for working",
"69.Inadequate high school training",
"70.Poor posture",
"71.Needing money for better health care",
"72.Awkward in meeting people",
"73.Feelings too easily hurt",
"74.Unhappy too much of the time",
"75.Not spending enough time in study",
"76.Wondering if Ill be successful in life",
"77.Not having a good college adviser",
"78.Poor complexion or skin trouble",
"79.Needing to watch every penny I spend",
"80.Awkward in making a date",
"81.Being talked about",
"82.Forgetting things",
"83.Trouble organizing term papers",
"84.Not knowing what I really want",
"85.Not getting individual help from teachers",
"86.Too short",
"87.Family worried about finances",
"88.Slow in getting acquainted with people",
"89.Worrying how I impress people",
"90.Having a certain nervous habit",
"91.Trouble in outlining or note-taking",
"92.Trying to combine marriage and a career",
"93.Not enough chances to talk to teachers",
"94.Too tall",
"95.Disliking financial dependence on others",
"96.In too few student activities",
"97.Feeling inferior",
"98.Trouble with oral reports",
"99.Teachers lacking interest in students",
"100. Not very attractive physically",
"101. Financially unable to get married",
"102. Boring weekends",
"103. Frequent sore throat",
"104. Working lat night on a job",
"105. Wanting to learn how to dance",
"106. Being stubborn or obstinate",
"107. Losing my temper",
"108. Not getting studies done on time",
"109. Is further education worthwhile",
"110. Classes too large",
"111. Frequent colds",
"112. Living in an inconvenient location",
"113. Wanting to improve my appearance",
"114. Getting into arguments",
"115. Being careless",
"116. Unable to concentrate well",
"117. Not knowing where I belong in the world",
"118. Not enough class discussion",
"119. Nose or sinus trouble",
"120. Transportation or commuting difficulty",
"121. Want to improve my manners or etiquette",
"122. Speaking or acting without thinking",
"123. Being lazy",
"124. Unable to express myself well in words",
"125. Needing to decide on an occupation",
"126. Classes run too much like high school",
"127. Speech handicap (stuttering, etc.)",
"128. Lacking privacy in living quarters",
"129. Trouble in keeping a conversation going",
"130. Sometimes acting childish or immature",
"131. Tending to exaggerate too much",
"132. Needing information about occupations",
"133. Too much work required in some courses",
"134. Weak eyes",
"135. Not taking things seriously enough",
"136. Needing to know my vocational abilities",
"137. Teacher too theoretical",
"138. Frequent headaches",
"139. Too little money for recreation",
"140. Lacking skill in sports and games",
"141. Disliking someone",
"142. Afraid of making mistakes",
"143. Worrying about examinations",
"144. Deciding whether to leave college for a job",
"145. Some courses poorly organize",
"146. Sometimes feeling faint or dizzy",
"147. No steady income",
"148. Too little change to enjoy nature",
"149. Being dislike by someone",
"150. Can’t make up my mind about things",
"151. Slow with theories and abstractions",
"152. Doubting I can get a job in chosen vocation",
"153. Courses too unrelated to each other",
"154. Glandular disorders (thyroid, lymph, etc.)",
"155. Unsure of my future financial support",
"156. To little change to pursue a hobby",
"157. Feeling that no one understands me",
"158. Lacking self-confidence",
"159. Weak in logical reasoning",
"160. Wanting advice on next steps after college",
"161. Too many rules and regulations",
"162. Too little chance to read what I like",
"163. Having no one to tell my troubles to",
"164. Can’t forget an unpleasant experience",
"165. Not smart enough in scholastics ways",
"166. Choosing best courses to prepare for a job",
"167. Unable to take courses I want",
"168. Want more meaning in debates w/ people",
"169. Finding it hard to talk about my troubles",
"170. Feeling life has given me a “raw’ deal",
"171. Fearing failure in college",
"172. Choosing best courses to prepare for a job",
"173. Forced to take courses I don’t like",
"174. Having considerable trouble with my teeth",
"175. Needing a job during vacations",
"176. Too little chance to do what I want to do",
"177. Too self-centered",
"178. Too many personal problems",
"179. Not having a well-planned college program",
"180. Afraid of unemployment after graduation",
"181. Grades unfair as measure of ability",
"182. Bothered by a physical handicap",
"183. Doing more outside work than is necessary",
"184. Too little social life",
"185. Hurting other people’s feelings",
"186. Too easily moved to tears",
"187. Poor memory",
"188. Not knowing how to look for a job",
"189. Unfair tests",
"190. Needing medical advice",
"191. Getting low wages",
"192. Too much social life",
"193. Too easily led by other people",
"194. Thought of suicide",
"195. Slow in Mathematics",
"196. Campus lacking in recreational facilities",
"197. Dissatisfied with my present job",
"198. Nothing interesting to do in vacation",
"199. Lacking leadership ability",
"200. Wanting to quit college"
                ];

                // Display each concern as a checkbox
                foreach ($concerns as $index => $concern) {
                    echo '<label><input type="checkbox" name="concerns[]" value="'.$concern.'"> '.$concern.'</label>';
                }
            ?>
        </div>

        <p>Selected concerns: <span id="top20Counter">0</span>/20</p>

<!-- Submit button -->
<button type="submit" name="submit_top_20">Submit Top 20</button>
<?php else: ?>
    <p>Top 20 concerns submitted!</p>
<?php endif; ?>
    </form>
<!-- Display the Top 5 selection form only if the Top 20 concerns have been submitted -->
<?php if ($top20_submitted): ?>
    <form method="POST">
        <h3>Select Your Top
        5 Immediate Concerns</h3>
        <div class="concern-list">
            <!-- Populate the top 5 concerns dynamically as checkboxes -->
            <?php foreach ($top_5_concerns as $concern): ?>
                <label>
                    <input type="checkbox" name="concerns_top_5[]" value="<?= htmlspecialchars($concern) ?>">
                    <?= htmlspecialchars($concern) ?>
                </label>
            <?php endforeach; ?>
        </div>
        <p>Selected concerns: <span id="top5Counter">0</span>/5</p>
        <button type="submit" name="submit_top_5">Submit Top 5</button>
    </form>
<?php endif; ?>
</body>
</html>