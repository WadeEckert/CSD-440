<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 8.2 Programming Assignment 
Original Author: Wade Eckert
Professor: Darrell Payne
Date: May 9, 2026
Description: 
*/ 
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content="">
	<meta name="author" content="Wade Eckert">
	<title>Query Baseball_01 Players Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .container {
            width: 90%;
            margin: 50px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h1, h2, p {
            text-align: center;
        }

        h1, h2 {
            color: #1f3c5c;
        }

        h2 {
            margin-top: 45px;
        }

        p {
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px;
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

        a.home-link {
            display: block;
            width: fit-content;
            margin: 30px auto 0 auto;
            color: #1f3c5c;
            font-weight: bold;
            text-decoration: none;
        }

        a.home-link:hover {
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

<div class="container"> <!-- Container for content with styling starts -->

<h1>Query Baseball_01 Players Table</h1>

<?php

$servername = "localhost";
$username = "student1";
$password = "pass";
$dbname = "baseball_01";

// Create connection to the baseball_01 database
$conn = @new mysqli($servername, $username, $password, $dbname);

// Check connection to the baseball_01 database and display an appropriate message if the connection fails or is successful
if ($conn->connect_error) {
    die("<p class=\"error-box\">Connection to the baseball_01 database failed: " . $conn->connect_error . ".</p>");
}

echo "<p class=\"success-box\">Connection to the baseball_01 database successful.</p>";


// SQL statement to query all player records from the players table in the baseball_01 database and order 
// the results by home runs in descending order and season year in ascending order
$sqlAllPlayers = "SELECT *
                  FROM players
                  ORDER BY home_runs DESC, season_year ASC";

// Execute the query and store the result set in a variable
$resultAllPlayers = $conn->query($sqlAllPlayers);

echo "<h2>Top 50 Home Run Seasons in Baseball History Through 2024</h2>";
echo "<p>Total Records Returned: " . $resultAllPlayers->num_rows . "</p>";

// Check if any player records were returned by the query and display the results in an HTML table
if ($resultAllPlayers && $resultAllPlayers->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Team</th>
            <th>Position</th>
            <th>Season Year</th>
            <th>Home Runs</th>
            <th>Batting Avg</th>
            <th>Status</th>
          </tr>";

    // Loop through each player record in the result set and display the player's information in a table row
    while ($row = $resultAllPlayers->fetch_assoc()) {
        $status = $row["active_player"] ? "Active" : "Retired";
        $statusClass = $row["active_player"] ? "active" : "retired";

        echo "<tr>";
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
    echo "<p class=\"error-box\">No player records were found.</p>";
}


// SQL statement to query only active player records from the players table in the baseball_01 database and order
// the results by home runs in descending order and batting average in descending order
$sqlActivePlayers = "SELECT first_name, last_name, team, position, season_year, home_runs, batting_avg
                     FROM players
                     WHERE active_player = 1
                     ORDER BY home_runs DESC, batting_avg DESC";

// Execute the query and store the result set in a variable
$resultActivePlayers = $conn->query($sqlActivePlayers);

echo "<h2>Top Active Players Home Run Seasons Through 2024</h2>";
echo "<p>Total Active Player Records Returned: " . $resultActivePlayers->num_rows . "</p>";

// Check if any active player records were returned by the query and display the results in an HTML table
if ($resultActivePlayers && $resultActivePlayers->num_rows > 0) {
    echo "<table>";
    echo "<tr> 
            <th>First Name</th>
            <th>Last Name</th>
            <th>Team</th>
            <th>Position</th>
            <th>Season Year</th>
            <th>Home Runs</th>
            <th>Batting Avg</th>
          </tr>";

    // Loop through each active player record in the result set and display the player's information in a table row
    while ($row = $resultActivePlayers->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["team"] . "</td>";
        echo "<td>" . $row["position"] . "</td>";
        echo "<td>" . $row["season_year"] . "</td>";
        echo "<td>" . $row["home_runs"] . "</td>";
        echo "<td>" . number_format($row["batting_avg"], 3) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p class=\"error-box\">No active player records were found.</p>";
}

$conn->close();

?>

<!-- Link to return to the index page -->
<a class="home-link" href="eckertIndex.php">Return to Index Page</a>

</div> <!-- Container for content with styling ends -->
</body>
</html>