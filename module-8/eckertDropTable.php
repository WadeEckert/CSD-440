<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 8.2 Programming Assignment 
Original Author: Wade Eckert
Professor: Darrell Payne
Date: May 9, 2026
Description: Script to drop the players table from the Baseball_01 database.
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content="Drop the players table from the Baseball_01 database.">
	<meta name="author" content="Wade Eckert">
	<title>Drop Baseball_01 Players Table</title>
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
    </style>
</head>
<body>

<div class="container"> <!-- Container for content with styling starts -->

<h1>Drop Baseball_01 Players Table</h1>

<?php

$servername = "localhost";
$username = "student1";
$password = "pass";
$dbname = "baseball_01";

// Create connection to the baseball_01 database
$conn = @new mysqli($servername, $username, $password, $dbname);

// Check connection to the baseball_01 database and display an appropriate message if the connection fails or is successful
if ($conn->connect_error) {
    die("<p>Connection to the baseball_01 database failed: " . $conn->connect_error . ".</p>");
}

echo "<p>Connection to the baseball_01 database successful.</p>";

// SQL statement to drop the players table from the baseball_01 database if it exists
$sql = "DROP TABLE IF EXISTS players";

// Check if the players table was dropped successfully and display an appropriate message if the operation fails or is successful
if ($conn->query($sql) === TRUE) {
    echo "<p>The players table was dropped successfully from the baseball_01 database.</p>";
} else {
    echo "<p>Error dropping players table: " . $conn->error . ".</p>";
}

$conn->close();

?>

</div> <!-- Container for content with styling ends -->
</body>
</html>