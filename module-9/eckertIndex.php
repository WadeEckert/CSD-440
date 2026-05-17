<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 9.2 Programming Assignment
Original Author: Wade Eckert
Date: May 16, 2026
Description: Index page for the Baseball_01 database project. This page provides access to the PHP scripts used to create, populate,
query, search, and add records to the Baseball_01 players table. The page includes instructions for first-time setup and links to each 
of the relevant PHP scripts for managing the database.
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Index page for the Baseball_01 database project.">
	<meta name="author" content="Wade Eckert">
	<title>Baseball_01 Database Project</title>

    <style> <!-- Simple CSS styling for the index page -->

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .container {
            width: 70%;
            margin: 80px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            color: #1f3c5c;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .setup-title {
            font-weight: bold;
            font-size: 20px;
            color: #1f3c5c;
            margin-top: 35px;
            margin-bottom: 15px;
        }

        .link-list {
            width: fit-content;
            margin: 45px auto 0 auto;
            padding-left: 0;
            text-align: left;
        }

        .link-list li {
            margin-bottom: 20px;
            font-size: 20px;
            list-style-position: inside;
        }

        a {
            color: #1f3c5c;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #4f7cac;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Baseball_01 Database Project Home Page</h1>

    <p>
        This page provides access to the PHP scripts used to create, populate,
        query, search, and add records to the Baseball_01 players table.
    </p>

    <P> 
        This database stores player season records for home runs hit by players in Major League Baseball through 2024.
    </p>

    <p class="setup-title">
        Recommended Order for First-Time Setup:
    </p>

    <p>
        If the players table has already been created and populated,
        you may skip steps 1 through 3 and proceed directly to the
        query, search, or add player pages.
    </p>

    <ol class="link-list">
        <li><a href="eckertDropTable.php">Drop Players Table</a></li>
        <li><a href="eckertCreateTable.php">Create Players Table</a></li>
        <li><a href="eckertPopulateTable.php">Populate Players Table</a></li>
        <li><a href="eckertQueryTable.php">View All Player Records</a></li>
        <li><a href="eckertSearch.php">Search Player Seasons</a></li>
        <li><a href="eckertAddPlayer.php">Add New Player Record</a></li>
    </ol>

</div>

</body>
</html>