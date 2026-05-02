<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 7.2 Programming Assignment
Original Author: Wade Eckert
Date: May 1, 2026
Description: This php script processes the form data submitted from eckertForm.php. 
It validates the input, handles errors by redirecting back to the form with error messages and old input, 
and if the data is valid, it stores the sanitized data in the session and redirects to eckertResponse.php to display the results.
If the form is submitted with missing or invalid data, the user will be redirected back to the form with appropriate error messages 
displayed next to the relevant fields.
*/

// Start session to handle error messages and old input
session_start();

// Function for validating and processing form data
function sanitize($data) {
	return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize an array to hold error messages
$errors = [];

// Required fields
$fields = ['fullname', 'age', 'email', 'dob', 'gender', 'bio'];

// Check if field is empty, if so, add an error message to the errors array
foreach ($fields as $field) {
	if (empty($_POST[$field])) {
		$errors[$field] = ucfirst($field) . ' is required.';
    } 
}

//  Validate full name (must contain at least a first and last name)
if (!isset($errors['fullname']) && !preg_match('/^\w+\s+\w+/', $_POST['fullname'])) {
	$errors['fullname'] = 'Please enter a full name (first and last only).';
}

// Validate age 
if (!isset($errors['age']) && (!is_numeric($_POST['age']) || $_POST['age'] < 1 || $_POST['age'] > 120)) {
	$errors['age'] = 'Age must be a number between 1 and 120.';
}

// Validate email
if (!isset($errors['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$errors['email'] = 'Invalid email format.';
}

// Validate date using regex (MM-DD-YYYY)
if (!isset($errors['dob'])) {
	$date = $_POST['dob'];
	if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
		$errors['dob'] = 'Invalid date format. Please use MM-DD-YYYY.';
	}
}

// Gender selection validation
if (!isset($errors['gender']) && !in_array($_POST['gender'], ['Male', 'Female', 'Other'])) {
	$errors['gender'] = 'Please select a gender.';
}

// Newsletter checkbox handling - if not checked previously, it will be considered 'No', otherwise 'Yes'
$newsletter = isset($_POST['newsletter']) ? 'Yes' : 'No';

// If there are errors, redirect back to form with errors and old input
if (count($errors) > 0) {
	$_SESSION['errors'] = $errors;
	$_SESSION['old'] = $_POST;
	header('Location: eckertForm.php');
	exit();
}

// If all data is valid, store in session and redirect to response page
$_SESSION['result'] = [
	'fullname' => sanitize($_POST['fullname']),
	'age' => sanitize($_POST['age']),
	'email' => sanitize($_POST['email']),
	'dob' => sanitize($_POST['dob']),
	'gender' => sanitize($_POST['gender']),
	'newsletter' => $newsletter,
	'bio' => nl2br(sanitize($_POST['bio'])),
];
header('Location: eckertResponse.php');
exit();
?>