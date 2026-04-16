<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 5.2: Programming Assignment
Original Author: Wade Eckert
Date: April 15, 2026
Description: This program creates an array of customers and displays them in a table and a second table sorted by last name. 
It also allows searching for customers by phone number, finding all customers over the age of 30, finding customers with a specific 
area code, and finding customers whose last name starts with the letter 'G'.
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content="A PHP program that displays a list of customers and allows searching by phone number, age, area code, and last name.">
	<meta name="author" content="Wade Eckert">
	<title>Module 5.2: Customer List Program</title>
</head>
<body>
<?php
// create the customers array that stores each customer's first name, last name, age, and phone number
$customers = [
	["first_name" => "Alice", "last_name" => "Smith", "age" => 28, "phone" => "555-1234"],
	["first_name" => "Bob", "last_name" => "Johnson", "age" => 35, "phone" => "555-2345"],
	["first_name" => "Carol", "last_name" => "Williams", "age" => 42, "phone" => "555-3456"],
	["first_name" => "David", "last_name" => "Brown", "age" => 31, "phone" => "555-4567"],
	["first_name" => "Eve", "last_name" => "Jones", "age" => 24, "phone" => "555-5678"],
	["first_name" => "Frank", "last_name" => "Garcia", "age" => 29, "phone" => "222-6789"],
	["first_name" => "Grace", "last_name" => "Martinez", "age" => 37, "phone" => "222-7890"],
	["first_name" => "Hank", "last_name" => "Davis", "age" => 45, "phone" => "222-8901"],
	["first_name" => "Ivy", "last_name" => "Lopez", "age" => 33, "phone" => "222-9012"],
	["first_name" => "Jack", "last_name" => "Gonzalez", "age" => 27, "phone" => "222-0123"],
];



// --- Begin Table Layout ---
echo '<div style="display: flex; flex-wrap: nowrap; gap: 80px; margin-bottom: 40px; align-items: flex-start; justify-content: center;">';

// create a table to display all customer's information
echo '<div style="display: flex; flex-direction: column; align-items: center; min-width: 300px;">';
// create a table to display all customer's information
echo "<h2 style='text-align:center;'>All Customers</h2>";
echo "<table border='1' cellpadding='5'><tr><th>First Name</th><th>Last Name</th><th>Age</th><th>Phone</th></tr>";
foreach ($customers as $c) {
    echo "<tr><td>{$c['first_name']}</td><td>{$c['last_name']}</td><td>{$c['age']}</td><td>{$c['phone']}</td></tr>";
}
echo "</table>";
echo '</div>';

// create a second table sorted by Last Name using array_column and asort
echo '<div style="display: flex; flex-direction: column; align-items: center; min-width: 300px;">';
// create a second table sorted by Last Name using array_column and asort
$lastNames = array_column($customers, 'last_name'); // extract the last names from the customers array and store them in a separate array
asort($lastNames); // sorts $lastNames alphabetically ascending and preserves keys from the original $customers array
echo "<h2 style='text-align:center;'>All Customers (Sorted by Last Name)</h2>";
echo "<table border='1' cellpadding='5'><tr><th>First Name</th><th>Last Name</th><th>Age</th><th>Phone</th></tr>";
foreach ($lastNames as $key => $lastName) { // loop through the sorted last names array, using the preserved keys to access the corresponding customer in the original $customers array
    $c = $customers[$key];
    echo "<tr><td>{$c['first_name']}</td><td>{$c['last_name']}</td><td>{$c['age']}</td><td>{$c['phone']}</td></tr>";
}
echo "</table>";
echo '</div>';

echo '</div>';
// --- End Table Layout ---


// --- Begin Filter Layout ---
echo '<div style="display: flex; flex-wrap: wrap; gap: 32px;">';

// find a customer by a specific phone number
echo '<div style="flex: 1 1 320px; min-width: 300px; border: 1px solid #ccc; border-radius: 8px; padding: 16px;">';
$searchPhone = "222-7890";
$phones = array_column($customers, 'phone'); // extract the phone numbers from the customers array and store them in a separate array
$index = array_search($searchPhone, $phones); // find the index of the phone number in the array of phone numbers
echo "<h2 style='font-size:1.2em'>Search by Specific Phone Number: (222-7890)</h2>";
if ($index !== false) {
    $c = $customers[$index]; // search the customers array by the index of the phone number found in the phones array and store the matching customer in $c
    echo "<ul><li>{$c['first_name']} {$c['last_name']} ({$c['age']}) - {$c['phone']}</li></ul>";
} else {
    echo "<p>No customer found with phone $searchPhone.</p>";
}
echo '</div>';

// find all customers over 30
echo '<div style="flex: 1 1 320px; min-width: 300px; border: 1px solid #ccc; border-radius: 8px; padding: 16px;">';
$over30 = array_filter($customers, function($c) { return $c['age'] > 30; }); // use an anonymous function with array_filter to find all customers whose age is greater than 30 
echo "<h2 style='font-size:1.2em'>Customers Over 30</h2>";
if (count($over30) > 0) { // check if any customers over 30 were found, and if so, display them in a list
    echo "<ul>";
    foreach ($over30 as $c) {
        echo "<li>{$c['first_name']} {$c['last_name']} ({$c['age']}) - {$c['phone']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No customers over 30.</p>";
}
echo '</div>';

// find all customers with a specific area code
echo '<div style="flex: 1 1 320px; min-width: 300px; border: 1px solid #ccc; border-radius: 8px; padding: 16px;">';
$searchArea = "222";
$areaCustomers = array_filter($customers, function($c) use ($searchArea) {return strpos($c['phone'], $searchArea) === 0; }); // another anonymous function
echo "<h2 style='font-size:1.2em'>Customers with Area Code $searchArea</h2>";
if (count($areaCustomers) > 0) { // check if any customers with the specified area code were found, and if so, display them in a list
    echo "<ul>";
    foreach ($areaCustomers as $c) {
        echo "<li>{$c['first_name']} {$c['last_name']} ({$c['age']}) - {$c['phone']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No customers found with area code $searchArea.</p>";
}
echo '</div>';

// find all customers with last name starting with 'G'
echo '<div style="flex: 1 1 320px; min-width: 300px; border: 1px solid #ccc; border-radius: 8px; padding: 16px;">';
$lastNameG = array_filter($customers, function($c) { return strpos($c['last_name'], 'G') === 0; }); // another anonymous function 
echo "<h2 style='font-size:1.2em'>Customers with Last Name Starting with 'G'</h2>";
if (count($lastNameG) > 0) { // check if any customers with last name starting with 'G' were found, and if so, display them in a list
    echo "<ul>";
    foreach ($lastNameG as $c) {
        echo "<li>{$c['first_name']} {$c['last_name']} ({$c['age']}) - {$c['phone']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No customers with last name starting with 'G'.</p>";
}
echo '</div>';

echo '</div>';
// --- End Filter Layout ---
?>
</body>
</html>