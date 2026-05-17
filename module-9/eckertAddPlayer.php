<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 9.2 Programming Assignment
Original Author: Wade Eckert
Date: May 16, 2026
Description: Form page for adding a new player record to the players table in the Baseball_01 database. This page includes a 
form for entering player details such as first name, last name, team, position, season year, home runs, batting average, and 
active/retired status. The form validates the input data and displays error messages for any invalid entries. Upon successful submission, 
the new player record is inserted into the database, and a success message is displayed.
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Add a new player record to the Baseball_01 database.">
	<meta name="author" content="Wade Eckert">
	<title>Baseball_01 Database - Add Player Record</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .container {
            width: 70%;
            margin: 50px auto;
            background-color: white;
            padding: 45px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h1, p {
            text-align: center;
        }

        h1 {
            color: #1f3c5c;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
        }

        p.form-instructions {
            margin-top: 50px;
            color: #1f3c5c;
            font-weight: bold;
        }
        form {
            width: 60%;
            margin: 30px auto;
            padding: 25px 35px;
            background-color: #f4f6f8;
            border: 1px solid #d6dce2;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #1f3c5c;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            margin-top: 25px;
            background-color: #1f3c5c;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4f7cac;
        }

        .error-box {
            width: 60%;
            margin: 25px auto;
            padding: 18px 25px;
            background-color: #ffecec;
            border: 1px solid #ff9c9c;
            border-radius: 8px;
            color: #9b0000;
        }

        .error-box ul {
            margin: 10px 0 0 20px;
        }

        .success-box {
            width: 60%;
            margin: 25px auto;
            padding: 18px 25px;
            background-color: #e9f7ec;
            border: 1px solid #8fd19e;
            border-radius: 8px;
            color: #1f6b2e;
            text-align: center;
            font-weight: bold;
        }

        .home-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #1f3c5c;
            font-weight: bold;
            text-decoration: none;
        }

        .home-link:hover {
            color: #4f7cac;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">

<h1>Add New Player Record to Baseball_01 Database</h1>

<?php

$servername = "localhost";
$username = "student1";
$password = "pass";
$dbname = "baseball_01";

// Create connection to the database using mysqli
$conn = @new mysqli($servername, $username, $password, $dbname);

// Check connection to the database
if ($conn->connect_error) {
    die("<p>Connection to the baseball_01 database failed: " . $conn->connect_error . ".</p>");
}

echo "<p>Connection to the baseball_01 database successful.</p>";

// Initialize variables for form data, error messages, and success message
$errors = array();
$successMessage = "";

$firstName = "";
$lastName = "";
$team = "";
$position = "";
$seasonYear = "";
$homeRuns = "";
$battingAvg = "";
$activePlayer = "";

// Process form submission when the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Trim and retrieve form data from POST request
    $firstName = trim($_POST["first_name"]);
    $lastName = trim($_POST["last_name"]);
    $team = trim($_POST["team"]);
    $position = trim($_POST["position"]);
    $seasonYear = trim($_POST["season_year"]);
    $homeRuns = trim($_POST["home_runs"]);
    $battingAvg = trim($_POST["batting_avg"]);
    $activePlayer = trim($_POST["active_player"]);

    if (empty($firstName)) {
        $errors[] = "First name is required.";
    }

    if (empty($lastName)) {
        $errors[] = "Last name is required.";
    }

    if (empty($team)) {
        $errors[] = "Team is required.";
    }

    if (empty($position)) {
        $errors[] = "Position is required.";
    }

    if ($seasonYear === "" || !is_numeric($seasonYear) || $seasonYear < 1900 || $seasonYear > 2025) {
        $errors[] = "Season year must be a number between 1900 and 2025.";
    }

    if ($homeRuns === "" || !is_numeric($homeRuns) || $homeRuns < 0 || $homeRuns > 100) {
        $errors[] = "Home runs must be a number between 0 and 100.";
    }

    if ($battingAvg === "" || !is_numeric($battingAvg) || $battingAvg < 0 || $battingAvg > 1) {
        $errors[] = "Batting average must be a number between 0 and 1.";
    }

    if ($activePlayer !== "0" && $activePlayer !== "1") {
        $errors[] = "Please select whether the player is active or retired.";
    }

    // If there are no validation errors, proceed to insert the new player record into the database
    if (count($errors) == 0) {

        // Convert numeric form inputs to the appropriate data types for database insertion
        $seasonYear = (int)$seasonYear;
        $homeRuns = (int)$homeRuns;
        $battingAvg = (float)$battingAvg;
        $activePlayer = (int)$activePlayer;

        // Prepare the SQL statement to insert the new player record into the players table
        $sql = "INSERT INTO players
                (first_name, last_name, team, position, season_year, home_runs, batting_avg, active_player)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        // Check if the prepared statement was created successfully before binding parameters and executing
        if ($stmt) {
            $stmt->bind_param(
                "ssssiidi",
                $firstName,
                $lastName,
                $team,
                $position,
                $seasonYear,
                $homeRuns,
                $battingAvg,
                $activePlayer
            );

            // Execute the prepared statement and check if the execution was successful to determine whether to display a success message or an error message
            if ($stmt->execute()) {
                $successMessage = "The new player record was added successfully.";

                // Clear form fields after successful submission
                $firstName = "";
                $lastName = "";
                $team = "";
                $position = "";
                $seasonYear = "";
                $homeRuns = "";
                $battingAvg = "";
                $activePlayer = "";
            } else {
                $errors[] = "Error adding player record: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $errors[] = "Error preparing insert statement: " . $conn->error;
        }
    }
}

// Display any validation errors after form submission
if (count($errors) > 0) {
    echo "<div class='error-box'>";
    echo "<strong>Please correct the following errors:</strong>";
    echo "<ul>";

    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }

    echo "</ul>";
    echo "</div>";
}

// Display a success message if the player record was added successfully
if (!empty($successMessage)) {
    echo "<div class='success-box'>" . $successMessage . "</div>";
}

?>

<p class="form-instructions">
    Use the form below to add a new single-season home run record to the players table.
</p>

<!-- Form for adding a new player record to the database. The form fields are pre-filled with the submitted values to allow for -->
<!-- easy correction of any validation errors. -->
<form method="POST" action="eckertAddPlayer.php">

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>">

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>">

    <label for="team">Team:</label>
    <input type="text" id="team" name="team" value="<?php echo htmlspecialchars($team); ?>">

    <label for="position">Position:</label>
    <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($position); ?>">

    <label for="season_year">Season Year:</label>
    <input type="number" id="season_year" name="season_year" value="<?php echo htmlspecialchars($seasonYear); ?>">

    <label for="home_runs">Home Runs:</label>
    <input type="number" id="home_runs" name="home_runs" value="<?php echo htmlspecialchars($homeRuns); ?>">

    <label for="batting_avg">Batting Average:</label>
    <input type="number" step="0.001" id="batting_avg" name="batting_avg" value="<?php echo htmlspecialchars($battingAvg); ?>">

    <label for="active_player">Player Status:</label>
    <select id="active_player" name="active_player">
        <option value="">-- Select Player Status --</option>
        <option value="1" <?php if ($activePlayer === "1") echo "selected"; ?>>Active</option>
        <option value="0" <?php if ($activePlayer === "0") echo "selected"; ?>>Retired</option>
    </select>

    <input type="submit" value="Add Player Record">

</form>

<!-- Link to return to the index page after the form -->
<a class="home-link" href="eckertIndex.php">Return to Index Page</a>

<?php

$conn->close();

?>

</div>

</body>
</html>