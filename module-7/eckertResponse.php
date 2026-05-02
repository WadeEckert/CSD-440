<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 7.2 Programming Assignment
Original Author: Wade Eckert
Date: May 1, 2026
Description: This php/html script displays the results of the form submission from eckertForm.php. 
It retrieves the sanitized data stored in the session by eckertProcess.php and displays it in a structured format.
*/

// Start session to handle result data
session_start();
if (!isset($_SESSION['result'])) {
	header('Location: eckertForm.php');
	exit();
}

// Retrieve result data from session and clear it to prevent resubmission issues
$result = $_SESSION['result'];
unset($_SESSION['result']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A page that displays the submitted data from a user information form, including full name, age, email, date of birth, gender, newsletter subscription, and a short bio.">
	<meta name="author" content="Wade Eckert">
	<title>Form Submission Results</title>
	<style>
		table { border-collapse: collapse; margin-top: 20px; margin-left: auto; margin-right: auto; }
		th, td { border: 1px solid #333; padding: 8px 16px; }
		th { background: #f0f0f0; }
		a { text-decoration: none; color: #007BFF; }
		a:hover { text-decoration: underline; color: #0056b3; }
	</style>
</head>
<body>
	<h2 style="text-align: center;">Submitted Data for <?= htmlspecialchars($result['fullname']) ?></h2>
	<table>
		<tr><th>Field</th><th>Value</th></tr>
		<tr><td>Full Name</td><td><?= htmlspecialchars($result['fullname']) ?></td></tr>
		<tr><td>Age</td><td><?= htmlspecialchars($result['age']) ?></td></tr>
		<tr><td>Email</td><td><?= htmlspecialchars($result['email']) ?></td></tr>
		<tr><td>Date of Birth</td><td><?= htmlspecialchars($result['dob']) ?></td></tr>
		<tr><td>Gender</td><td><?= htmlspecialchars($result['gender']) ?></td></tr>
		<tr><td>Newsletter Sign Up?</td><td><?= htmlspecialchars($result['newsletter']) ?></td></tr>
		<tr><td>Short Bio</td><td><?= htmlspecialchars($result['bio']) ?></td></tr>
	</table>
	<br>
	<a href="eckertForm.php" style="display: block; text-align: center;">-- Submit Another Form --</a>
</body>
</html>