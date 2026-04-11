<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 4.2: Programming Assignment
Original Author: Wade Eckert
Date: April 11, 2026
Description: This PHP script checks whether a given string is a palindrome by demonstrating the use 
of a PHP function to normalize the input by removing spaces and ignoring case, 
and then comparing the normalized string to its reversed version to determine if it is a palindrome.
It then displays the results in an HTML table showing the original string, the reversed string, and whether each string is a palindrome.
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content="A PHP script that checks whether a given string is a palindrome, using a function to perform the palindrome check.">
	<meta name="author" content="Wade Eckert">
	<title>CSD 440: Palindrome Checker</title>
	<style>
		body {
			font-family: Arial, sans-serif;
		}
		.centered {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
		table {
			margin: 0 auto;
		}
		h2 {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="centered">
        <?php
            // Function to check if a string is a palindrome
            function isPalindrome($str) {
                $normalized = strtolower(preg_replace('/\s+/', '', $str)); // Normalize: remove spaces, make lowercase
                return $normalized === strrev($normalized); // Compare the normalized string to its reversed version and return true if they match, false otherwise
            }

            $examples = [
                "racecar",           // palindrome
                "Level",             // palindrome (case-insensitive)
                "A man a plan a canal Panama", // palindrome (ignoring spaces)
                "hello",             // not palindrome
                "Palindrome",        // not palindrome
                "HTML"             // not palindrome (case-insensitive)
            ];

            // Generate the HTML table to display the results of the palindrome checks
            echo '<h2>Palindrome Checker Results</h2>';
            echo '<table border="1" cellpadding="8" style="border-collapse: collapse;">';
            echo '<tr><th>Original String</th><th>Reversed String</th><th>Is Palindrome?</th></tr>';

            foreach ($examples as $str) {
                $originalLower = strtolower($str); // Convert the original string to lowercase for comparison
                $reversedLower = strtolower(strrev($str)); // Convert the reversed string to lowercase for comparison
                $result = isPalindrome($str) ? "Yes" : "No"; // Determine if the string is a palindrome and set the result to "Yes" or "No" using ternary operator
                echo '<tr>';
                echo '<td>' . htmlspecialchars($originalLower) . '</td>'; //htmlspecialchars to display special characters safely in HTML
                echo '<td>' . htmlspecialchars($reversedLower) . '</td>'; //htmlspecialchars to display special characters safely in HTML
                echo '<td style="text-align:center;">' . $result . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        ?>
	</div>
</body>
</html>