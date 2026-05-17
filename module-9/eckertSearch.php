<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 9.2 Programming Assignment
Original Author: Wade Eckert
Date: May 16, 2026
Description: Search page for the Baseball_01 database project. This page allows users to select a player from a dropdown menu 
and view that player's home run season records (through 2024) from the Baseball_01 database. The search results are displayed in a table format, 
showing the player's all-time home run rank, season details, and status (active or retired).
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Search player seasons from the Baseball_01 database.">
	<meta name="author" content="Wade Eckert">
	<title>Baseball_01 Database - Search Player Seasons</title>

    <style> <!-- Simple CSS styling for the search page -->
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .container {
            width: 85%;
            margin: 50px auto;
            background-color: white;
            padding: 45px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .search-box {
            width: fit-content;
            margin: 30px auto 35px auto;
            padding: 25px 35px;
            background-color: #f4f6f8;
            border-radius: 8px;
            border: 1px solid #d6dce2;
        }

        h1, h2 {
            color: #1f3c5c;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
        }

        p.search-instructions {
            margin-top: 50px;
            color: #1f3c5c;
            font-weight: bold;
        }

        form {
            margin: 0 auto;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            color: #1f3c5c;
            margin-right: 10px;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 18px;
            margin-left: 10px;
            background-color: #1f3c5c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4f7cac;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin: 25px auto 35px auto;
            font-size: 15px;
        }

        th {
            background-color: #1f3c5c;
            color: white;
            padding: 12px;
            border: 1px solid #ccc;
        }

        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #eef2f5;
        }

        tr:hover {
            background-color: #dbe7f1;
        }

        .active {
            color: green;
            font-weight: bold;
        }

        .retired {
            color: #ff0000;
            font-weight: bold;
        }

        .home-link {
            display: inline-block;
            margin-top: 30px;
            color: #1f3c5c;
            font-weight: bold;
            text-decoration: none;
            font-size: 18px;
        }

        .home-link:hover {
            color: #4f7cac;
            text-decoration: underline;
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

        .error-box {
            width: 60%;
            margin: 25px auto;
            padding: 18px 25px;
            background-color: #ffecec;
            border: 1px solid #ff9c9c;
            border-radius: 8px;
            color: #9b0000;
        }
    </style>
</head>

<body>

<div class="container"> <!-- Container for the search page content with styling similar to the index page starts-->

<h1>Search All-Time Home Run Seasons by Player Through 2024</h1>

<?php

$servername = "localhost";
$username = "student1";
$password = "pass";
$dbname = "baseball_01";

// Create connection to the baseball_01 database
$conn = @new mysqli($servername, $username, $password, $dbname);

// Check connection to the baseball_01 database
if ($conn->connect_error) {
    die("<p class=\"error-box\">Connection to the baseball_01 database failed: " . $conn->connect_error . ".</p>");
}

echo "<p class=\"success-box\">Connection to the baseball_01 database successful.</p>";

?>

<p class="search-instructions">
    Select a player from the dropdown menu to view that player's home run season records (through 2024)
    from the Baseball_01 database.
</p>

<div class="search-box"> <!-- Search box container with styling similar to the index page starts-->
    <form method="POST" action="eckertSearch.php">
        <label for="player_name">Select Player:</label>

        <select name="player_name" id="player_name" required>
            <option value="">-- Select a Player --</option>

            <?php

            // Query unique player names for the dropdown menu
            $playerListSql = "SELECT DISTINCT first_name, last_name
                            FROM players
                            ORDER BY first_name, last_name";

            $playerListResult = $conn->query($playerListSql);

            // Loop through the results and create an option for each player in the dropdown menu
            if ($playerListResult && $playerListResult->num_rows > 0) {
                while ($player = $playerListResult->fetch_assoc()) {
                    $fullName = $player["first_name"] . " " . $player["last_name"];

                    $selected = "";
                    if (isset($_POST["player_name"]) && $_POST["player_name"] == $fullName) {
                        $selected = "selected";
                    }

                    echo "<option value='" . $fullName . "' " . $selected . ">" . $fullName . "</option>";
                }
            }

            ?>

        </select>

        <input type="submit" name="search" value="Search Player Seasons">
    </form>
</div> <!-- End of search box container -->

<?php

// Check if the search form has been submitted
if (isset($_POST["search"])) {

    // Get the selected player name from the form submission
    $selectedPlayer = $_POST["player_name"];

    // Split selected player name into first and last name
    $nameParts = explode(" ", $selectedPlayer, 2);
    $firstName = $nameParts[0];
    $lastName = $nameParts[1];

    // Create rankings based on all records ordered by home runs
    $rankingSql = "SELECT player_id
                   FROM players
                   ORDER BY home_runs DESC, season_year ASC";

    $rankingResult = $conn->query($rankingSql);

    // Build an associative array to store player_id and their corresponding all-time home run rank
    $rankings = array();
    $rank = 1;

    // Loop through the ranking results and assign ranks to each player_id
    if ($rankingResult && $rankingResult->num_rows > 0) {
        while ($rankingRow = $rankingResult->fetch_assoc()) {
            $rankings[$rankingRow["player_id"]] = $rank;
            $rank++;
        }
    }

    // Prepared statement to select all seasons for the chosen player
    $playerSql = "SELECT *
                  FROM players
                  WHERE first_name = ? AND last_name = ?
                  ORDER BY home_runs DESC, season_year ASC";

    $stmt = $conn->prepare($playerSql);
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();

    $playerResult = $stmt->get_result();

    echo "<h2>Search Results for " . $selectedPlayer . "</h2>";

    // Display total records returned and the results in a table format
    if ($playerResult && $playerResult->num_rows > 0) {

        echo "<p>Total Records Returned: " . $playerResult->num_rows . "</p>";

        echo "<table>";
        echo "<tr>
                <th>All-Time Rank</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Team</th>
                <th>Position</th>
                <th>Season Year</th>
                <th>Home Runs</th>
                <th>Batting Avg</th>
                <th>Status</th>
              </tr>";

        // Loop through the results and display each season record with the player's all-time home run rank
        while ($row = $playerResult->fetch_assoc()) {
            $status = $row["active_player"] ? "Active" : "Retired";
            $statusClass = $row["active_player"] ? "active" : "retired";
            $playerRank = $rankings[$row["player_id"]];

            echo "<tr>";
            echo "<td>" . $playerRank . "</td>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["last_name"] . "</td>";
            echo "<td>" . $row["team"] . "</td>";
            echo "<td>" . $row["position"] . "</td>";
            echo "<td>" . $row["season_year"] . "</td>";
            echo "<td>" . $row["home_runs"] . "</td>";
            echo "<td>" . number_format($row["batting_avg"], 3) . "</td>";
            echo "<td class='" . $statusClass . "'>" . $status . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "<p class=\"error-box\">No records were found for the selected player.</p>";
    }

    $stmt->close();
}

$conn->close();

?>

<!-- Link to return to the index page -->
<a class="home-link" href="eckertIndex.php">Return to Index Page</a>

</div> <!-- End of container -->

</body>
</html>