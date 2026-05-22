<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: PHP Form to JSON Output
Original Author: Wade Eckert
Date: May 21, 2026
Description: This program displays a travel registration form, validates user input,
             encodes valid submitted data into JSON format using json_encode(),
             and displays either the formatted JSON output or validation errors.
*/

// Initialize variables to store form data, errors, and JSON output
$errors = [];
$jsonOutput = "";

$formData = [
    "firstName" => "",
    "lastName" => "",
    "email" => "",
    "phone" => "",
    "destination" => "",
    "travelDate" => "",
    "travelers" => "",
    "tripType" => "",
    "specialRequests" => ""
];

// Function to sanitize user input to prevent XSS attacks and ensure clean data
function cleanInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Check if the form was submitted via POST method and process the input. If field is empty, it will be set to an empty string to avoid undefined index errors
if ($_SERVER["REQUEST_METHOD"] === "POST") {   
    foreach ($formData as $field => $value) {
        $formData[$field] = cleanInput($_POST[$field] ?? "");
    }

    // Validate each form field and populate the $errors array with appropriate messages if validation fails
    if ($formData["firstName"] === "") {
        $errors["firstName"] = "First name is required.";
    }

    if ($formData["lastName"] === "") {
        $errors["lastName"] = "Last name is required.";
    }

    // Validate email address using filter_var with FILTER_VALIDATE_EMAIL and ensure it's not empty
    if ($formData["email"] === "") {
        $errors["email"] = "Email address is required.";
    } elseif (!filter_var($formData["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email address with a proper format (e.g., user@example.com).";
    }

    // Validate phone number to ensure it's not empty and matches a common phone number pattern (e.g., 123-456-7890) using a regular expression
    if ($formData["phone"] === "") {
        $errors["phone"] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9\-\(\)\s\.]{10,20}$/', $formData["phone"])) {
        $errors["phone"] = "Please enter a valid phone number with a proper format (e.g., 123-456-7890).";
    }

    if ($formData["destination"] === "") {
        $errors["destination"] = "Destination is required.";
    }

    if ($formData["travelDate"] === "") {
        $errors["travelDate"] = "Travel date is required.";
    }

    // Validate number of travelers to ensure it's a whole number between 1 and 20 and is not empty
    if ($formData["travelers"] === "") {
        $errors["travelers"] = "Number of travelers is required.";
    } elseif (!filter_var($formData["travelers"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 20]])) {
        $errors["travelers"] = "Please enter a whole number between 1 and 20.";
    }

    if ($formData["tripType"] === "") {
        $errors["tripType"] = "Trip type is required.";
    }

    if ($formData["specialRequests"] === "") {
        $errors["specialRequests"] = "Special requests field is required. Enter 'None' if not applicable.";
    }

    // If there are no validation errors, prepare the data for JSON encoding and attempt to encode it into JSON format using json_encode()
    if (empty($errors)) {
        $travelData = [
            "firstName" => $formData["firstName"],
            "lastName" => $formData["lastName"],
            "email" => $formData["email"],
            "phone" => $formData["phone"],
            "destination" => $formData["destination"],
            "travelDate" => $formData["travelDate"],
            "numberOfTravelers" => (int)$formData["travelers"],
            "tripType" => $formData["tripType"],
            "specialRequests" => $formData["specialRequests"]
        ];

        // Encode the travel data into JSON format with pretty print for better readability
        $jsonOutput = json_encode($travelData, JSON_PRETTY_PRINT);

        // Check if json_encode() returned false, which indicates an encoding error, and add an error message to the $errors array if this occurs
        if ($jsonOutput === false) {
            $errors["json"] = "There was a problem encoding the form data into JSON format.";
        }
    }
}
?> 

<!-- Start of the HTML form document -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
    <meta name="description" content="PHP form program that validates travel registration data and displays the submitted information in JSON format.">
    <meta name="author" content="Wade Eckert">
    <title>Travel Registration Form</title>
    <link rel="stylesheet" href="eckertStyles.css">
</head>
<body>
    <main class="page-wrapper"> <!-- Main content wrapper for the page starts -->
        <section class="card"> <!-- Section for the form card starts -->
            <h1>Travel Registration Form</h1>
            <p class="intro-text">Complete the form below. All fields are required before the information can be converted to JSON format.</p>

            <!-- If the form was submitted successfully and there are no validation errors, display the formatted JSON output. Otherwise, display the form with any validation error messages. -->
            <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($errors) && $jsonOutput !== "") : ?>
                <div class="success-box"> <!-- Success message box starts -->
                    <h2>Formatted JSON Output</h2>
                    <p>The submitted form data was successfully encoded using <code>json_encode()</code>.</p>
                    <pre><?php echo $jsonOutput; ?></pre>
                    <a class="button-link" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">Return to Blank Form</a>
                </div> <!-- Success message box ends -->
            <?php else : ?>
                <?php if (!empty($errors)) : ?>
                    <div class="error-summary"> <!-- Error summary box starts -->
                        <h2>Please correct the following errors:</h2>
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div> <!-- Error summary box ends -->
                <?php endif; ?>
                
                <!-- Form starts here. The form uses the POST method and submits to the same PHP file. The novalidate attribute is used to disable HTML5 validation, allowing for custom server-side validation instead. -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                    <div class="form-row">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo $formData['firstName']; ?>">
                        <?php if (isset($errors["firstName"])) : ?><span class="field-error"><?php echo $errors["firstName"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo $formData['lastName']; ?>">
                        <?php if (isset($errors["lastName"])) : ?><span class="field-error"><?php echo $errors["lastName"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo $formData['email']; ?>">
                        <?php if (isset($errors["email"])) : ?><span class="field-error"><?php echo $errors["email"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="phone">Phone Number (xxx-xxx-xxxx)</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo $formData['phone']; ?>">
                        <?php if (isset($errors["phone"])) : ?><span class="field-error"><?php echo $errors["phone"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="destination">Destination</label>
                        <input type="text" id="destination" name="destination" value="<?php echo $formData['destination']; ?>">
                        <?php if (isset($errors["destination"])) : ?><span class="field-error"><?php echo $errors["destination"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="travelDate">Travel Date</label>
                        <input type="date" id="travelDate" name="travelDate" value="<?php echo $formData['travelDate']; ?>">
                        <?php if (isset($errors["travelDate"])) : ?><span class="field-error"><?php echo $errors["travelDate"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="travelers">Number of Travelers (1-20)</label>
                        <input type="number" id="travelers" name="travelers" min="1" max="20" value="<?php echo $formData['travelers']; ?>">
                        <?php if (isset($errors["travelers"])) : ?><span class="field-error"><?php echo $errors["travelers"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="tripType">Trip Type</label>
                        <select id="tripType" name="tripType">
                            <option value="">Select a trip type</option>
                            <option value="Relaxation" <?php if ($formData['tripType'] === 'Relaxation') echo 'selected'; ?>>Relaxation</option>
                            <option value="Adventure" <?php if ($formData['tripType'] === 'Adventure') echo 'selected'; ?>>Adventure</option>
                            <option value="Family" <?php if ($formData['tripType'] === 'Family') echo 'selected'; ?>>Family</option>
                            <option value="Business" <?php if ($formData['tripType'] === 'Business') echo 'selected'; ?>>Business</option>
                        </select>
                        <?php if (isset($errors["tripType"])) : ?><span class="field-error"><?php echo $errors["tripType"]; ?></span><?php endif; ?>
                    </div>

                    <div class="form-row">
                        <label for="specialRequests">Special Requests (Enter 'None' if no requests)</label>
                        <textarea id="specialRequests" name="specialRequests" rows="4"><?php echo $formData['specialRequests']; ?></textarea>
                        <?php if (isset($errors["specialRequests"])) : ?><span class="field-error"><?php echo $errors["specialRequests"]; ?></span><?php endif; ?>
                    </div>

                    <button type="submit">Submit Form</button>

                </form> <!-- Form ends here -->
            <?php endif; ?>
        </section> <!-- Section for the form card ends -->
    </main> <!-- Main content wrapper for the page ends -->
</body>
</html>
