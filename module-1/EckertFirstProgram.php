<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 1.3: Programming Assignment
Original Author: Wade Eckert
Date: March 19, 2026
Description: Simple php script that shows the use of the echo construct to display
	     a string of text, and also shows the use of the date function to show dynamic output.
	     Also shows the use of variables.
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSD 440 - Module 1.3 - PHP Test Page</title>
</head>
<body>

    <h1>Wade Eckert's PHP Test Page</h1>

    <p>
        <?php
            // First PHP snippet
            echo "Hello! Apache and PHP are working correctly.";
        ?>
    </p>

    <p>
        <?php
            // Second PHP snippet
	    date_default_timezone_set("America/Denver");
            $currentDate = date("m-d-Y g:i A");
	    $location = "Denver, Colorado";
            echo "Current Date and Time is " . $currentDate . " in " . $location . ".";
        ?>
    </p>

</body>
</html>