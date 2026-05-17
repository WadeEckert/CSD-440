<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 8.2 Programming Assignment 
Original Author: Wade Eckert
Professor: Darrell Payne
Date: May 9, 2026
Description: Script to populate the players table in the Baseball_01 database with the top 50 single-season home run records in MLB history.
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content="Populate the players table in the Baseball_01 database with the top 50 single-season home run records in MLB history.">
	<meta name="author" content="Wade Eckert">
	<title>Populate Baseball_01 Players Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 100px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            color: #1f3c5c;
            margin-bottom: 30px;
        }

        p {
            font-size: 18px;
            margin: 15px 0;
            color: #333;
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

<div class="container">

<h1>Populate Baseball_01 Players Table</h1>

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

// SQL statement to clear any existing records from the players table in the baseball_01 database before inserting new records
$clearTable = "TRUNCATE TABLE players";

// Check if the players table was cleared successfully and display an appropriate message if the operation fails or is successful
if ($conn->query($clearTable) === TRUE) {
    echo "<p class=\"success-box\">Existing player records were cleared from the players table.</p>";
} else {
    echo "<p class=\"error-box\">Error clearing players table: " . $conn->error . "</p>";
}

// SQL statement to insert 50 player records into the players table in the baseball_01 database based on the top 50 single-season home run records in MLB history
// Each record includes the player's first name, last name, team, position, season year, home runs, batting average, and active player status
$sql = "INSERT INTO players
(first_name, last_name, team, position, season_year, home_runs, batting_avg, active_player)
VALUES
('Barry', 'Bonds', 'San Francisco Giants', 'Left Field', 2001, 73, 0.328, 0),
('Mark', 'McGwire', 'St. Louis Cardinals', 'First Base', 1998, 70, 0.299, 0),
('Sammy', 'Sosa', 'Chicago Cubs', 'Right Field', 1998, 66, 0.308, 0),
('Mark', 'McGwire', 'St. Louis Cardinals', 'First Base', 1999, 65, 0.278, 0),
('Sammy', 'Sosa', 'Chicago Cubs', 'Right Field', 2001, 64, 0.328, 0),
('Sammy', 'Sosa', 'Chicago Cubs', 'Right Field', 1999, 63, 0.288, 0),
('Aaron', 'Judge', 'New York Yankees', 'Right Field', 2022, 62, 0.311, 1),
('Roger', 'Maris', 'New York Yankees', 'Right Field', 1961, 61, 0.269, 0),
('Babe', 'Ruth', 'New York Yankees', 'Right Field', 1927, 60, 0.356, 0),
('Babe', 'Ruth', 'New York Yankees', 'Right Field', 1921, 59, 0.378, 0),

('Giancarlo', 'Stanton', 'Miami Marlins', 'Right Field', 2017, 59, 0.281, 1),
('Ryan', 'Howard', 'Philadelphia Phillies', 'First Base', 2006, 58, 0.313, 0),
('Hank', 'Greenberg', 'Detroit Tigers', 'First Base', 1938, 58, 0.315, 0),
('Jimmie', 'Foxx', 'Boston Red Sox', 'First Base', 1938, 58, 0.349, 0),
('Alex', 'Rodriguez', 'New York Yankees', 'Shortstop', 2002, 57, 0.300, 0),
('Ken', 'Griffey Jr.', 'Seattle Mariners', 'Center Field', 1997, 56, 0.304, 0),
('Ken', 'Griffey Jr.', 'Seattle Mariners', 'Center Field', 1998, 56, 0.284, 0),
('Matt', 'Olson', 'Atlanta Braves', 'First Base', 2023, 54, 0.283, 1),
('Shohei', 'Ohtani', 'Los Angeles Dodgers', 'Designated Hitter', 2024, 54, 0.310, 1),
('Pete', 'Alonso', 'New York Mets', 'First Base', 2019, 53, 0.260, 1),

('Mickey', 'Mantle', 'New York Yankees', 'Center Field', 1961, 54, 0.317, 0),
('Prince', 'Fielder', 'Milwaukee Brewers', 'First Base', 2007, 50, 0.288, 0),
('Albert', 'Pujols', 'St. Louis Cardinals', 'First Base', 2006, 49, 0.331, 0),
('Larry', 'Walker', 'Colorado Rockies', 'Right Field', 1997, 49, 0.366, 0),
('Chris', 'Davis', 'Baltimore Orioles', 'First Base', 2013, 53, 0.286, 0),
('Jose', 'Bautista', 'Toronto Blue Jays', 'Right Field', 2010, 54, 0.260, 0),
('David', 'Ortiz', 'Boston Red Sox', 'Designated Hitter', 2006, 54, 0.287, 0),
('Cecil', 'Fielder', 'Detroit Tigers', 'First Base', 1990, 51, 0.277, 0),
('George', 'Foster', 'Cincinnati Reds', 'Left Field', 1977, 52, 0.320, 0),
('Willie', 'Mays', 'San Francisco Giants', 'Center Field', 1965, 52, 0.317, 0),

('Aaron', 'Judge', 'New York Yankees', 'Right Field', 2024, 58, 0.322, 1),
('Kyle', 'Schwarber', 'Philadelphia Phillies', 'Left Field', 2023, 47, 0.197, 1),
('Yordan', 'Alvarez', 'Houston Astros', 'Left Field', 2022, 37, 0.306, 1),
('Ronald', 'Acuna Jr.', 'Atlanta Braves', 'Outfield', 2023, 41, 0.337, 1),
('Mookie', 'Betts', 'Los Angeles Dodgers', 'Right Field', 2023, 39, 0.307, 1),
('Freddie', 'Freeman', 'Los Angeles Dodgers', 'First Base', 2023, 29, 0.331, 1),
('Corey', 'Seager', 'Texas Rangers', 'Shortstop', 2023, 33, 0.327, 1),
('Bobby', 'Witt Jr.', 'Kansas City Royals', 'Shortstop', 2024, 32, 0.332, 1),
('Juan', 'Soto', 'New York Mets', 'Outfield', 2020, 13, 0.351, 1),
('Vladimir', 'Guerrero Jr.', 'Toronto Blue Jays', 'First Base', 2021, 48, 0.311, 1),

('Julio', 'Rodriguez', 'Seattle Mariners', 'Center Field', 2022, 28, 0.284, 1),
('Fernando', 'Tatis Jr.', 'San Diego Padres', 'Right Field', 2021, 42, 0.282, 1),
('Bryce', 'Harper', 'Philadelphia Phillies', 'Right Field', 2015, 42, 0.330, 1),
('Jose', 'Altuve', 'Houston Astros', 'Second Base', 2017, 24, 0.346, 1),
('Christian', 'Yelich', 'Milwaukee Brewers', 'Left Field', 2019, 44, 0.329, 1),
('Paul', 'Goldschmidt', 'St. Louis Cardinals', 'First Base', 2022, 35, 0.317, 1),
('Manny', 'Machado', 'San Diego Padres', 'Third Base', 2022, 32, 0.298, 1),
('Francisco', 'Lindor', 'New York Mets', 'Shortstop', 2018, 38, 0.277, 1),
('Ketel', 'Marte', 'Arizona Diamondbacks', 'Second Base', 2019, 32, 0.329, 1),
('Adley', 'Rutschman', 'Baltimore Orioles', 'Catcher', 2023, 20, 0.277, 1)";

// Check if the player records were inserted successfully and display an appropriate message if the operation fails or is successful
if ($conn->query($sql) === TRUE) {
    echo "<p class=\"success-box\">The players table was populated successfully.</p>";
    echo "<p class=\"success-box\">50 player records were inserted into the baseball_01 database.</p>";
} else {
    echo "<p class=\"error-box\">Error populating players table: " . $conn->error . "</p>";
}

$conn->close();

?>

<!-- Link to return to the index page -->
<a class="home-link" href="eckertIndex.php">Return to Index Page</a>

</div>

</body>
</html>