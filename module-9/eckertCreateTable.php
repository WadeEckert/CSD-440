<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 8.2 Programming Assignment 
Original Author: Wade Eckert
Professor: Darrell Payne
Date: May 9, 2026
Description: Script to create the players table in the Baseball_01 database.
*/ 
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content="Create the players table in the Baseball_01 database.">
	<meta name="author" content="Wade Eckert">
	<title>Create Baseball_01 Players Table</title>
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

<div class="container"> <!-- Container for content with styling starts -->

<h1>Create Baseball_01 Players Table</h1>

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

// SQL statement to create the players table in the baseball_01 database with the specified columns and data types
$sql = "CREATE TABLE players (
    player_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    team VARCHAR(75) NOT NULL,
    position VARCHAR(30) NOT NULL,
    season_year INT NOT NULL,
    home_runs INT NOT NULL,
    batting_avg DECIMAL(4,3) NOT NULL,
    active_player BOOLEAN NOT NULL
)";

// Check if the players table was created successfully and display an appropriate message if the operation fails or is successful
if ($conn->query($sql) === TRUE) {
    echo "<p class=\"success-box\">The players table was created successfully in the baseball_01 database.</p>";
} else {
    echo "<p class=\"error-box\">Error creating players table: " . $conn->error . ".</p>";
}

$conn->close();

?>

<!-- Link to return to the index page -->
<a class="home-link" href="eckertIndex.php">Return to Index Page</a>

</div> <!-- Container for content with styling ends -->
</body>
</html>