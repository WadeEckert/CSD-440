<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 7.2 Programming Assignment
Original Author: Wade Eckert
Date: May 1, 2026
Description: This php/html script displays a form for user input. It retrieves any error messages 
and old input from the session to provide feedback to the user if the form was previously submitted with errors. 
The form includes fields for full name, age, email address, date of birth, gender selection, newsletter subscription, and a short bio. 
When the form is submitted, it sends the data to eckertProcess.php for validation and processing.
*/

// Start session to handle error messages and old input
session_start();

// Retrieve errors and old input from session, then clear them to prevent resubmission issues
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$old = isset($_SESSION['old']) ? $_SESSION['old'] : [];
unset($_SESSION['errors'], $_SESSION['old']);

// Helper functions to retrieve old input and display them as default values in the form
function old($key, $default = '') {
	global $old;
	return isset($old[$key]) ? htmlspecialchars($old[$key]) : $default;
}

// Function to display error messages for a specific field
function error($key) {
	global $errors;
	return isset($errors[$key]) ? '<span style="color:red; font-size:0.9em;">' . $errors[$key] . '</span><br>' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content=" A user information form that collects data such as full name, age, email, date of birth, gender, newsletter subscription, and a short bio.">
	<meta name="author" content="Wade Eckert">
	<title>User Information Form</title>
</head>
<body>
	<div class="container" style="margin-left: auto; margin-right: auto; width: 60%; text-align: center;">
		<h2>User Information Form</h2>
		<h3 style="color:red; font-size:0.9em;">All fields with a * are required</h3>
	</div>
		<div class="form-body" style="width: 50%; margin-left: auto; margin-right: auto; border: 1px solid #ccc; padding: 20px;">
			<!-- Form that submits to eckertProcess.php -->	
			<form action="eckertProcess.php" method="post">
				<!-- Form field for full name with old input and error display -->
				<label for="fullname">Full Name (First/Last): <span style="color:red">*</span></label><br>
				<input type="text" id="fullname" name="fullname" value="<?= old('fullname') ?>"><br>
				<?= error('fullname') ?>
				<br>
				
				<!-- Form field for age with old input and error display -->
				<label for="age">Age: <span style="color:red">*</span></label><br>
				<input type="number" id="age" name="age" min="1" max="120" value="<?= old('age') ?>"><br>
				<?= error('age') ?>
				<br>

				<!-- Form field for email with old input and error display -->
				<label for="email">Email: <span style="color:red">*</span></label><br>
				<input type="email" id="email" name="email" value="<?= old('email') ?>"><br>
				<?= error('email') ?>
				<br>
				
				<!-- Form field for date of birth with old input and error display -->
				<label for="dob">Date of Birth (MM-DD-YYYY): <span style="color:red">*</span></label><br>
				<input type="text" id="dob" name="dob" value="<?= old('dob') ?>"><br>
				<?= error('dob') ?>
				<br>

				<!-- Form field for gender selection with old input and error display -->
				<label for="gender">Gender: <span style="color:red">*</span></label><br>
				<select id="gender" name="gender">
					<option value="" <?= old('gender') == '' ? 'selected' : '' ?>>Select</option>
					<option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
					<option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
					<option value="Other" <?= old('gender') == 'Other' ? 'selected' : '' ?>>Other</option>
				</select><br>
				<?= error('gender') ?>
				<br>

				<!-- Form field for short bio with old input and error display -->
				<label for="bio">Short Bio: <span style="color:red">*</span></label><br>
				<textarea id="bio" name="bio" rows="4" cols="40"><?= old('bio') ?></textarea><br>
				<?= error('bio') ?>
				<br>

				<!-- Form field for newsletter subscription with old input -->
				<label for="newsletter">Subscribe to newsletter:</label>
				<input type="checkbox" id="newsletter" name="newsletter" value="Yes" <?= old('newsletter') ? 'checked' : '' ?>><br><br>

				<!-- Submit button -->
				<input type="submit" value="Submit">
			</form>
		</div>
</body>
</html>