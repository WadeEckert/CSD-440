<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 6.2: Programming Assignment
Original Author: Wade Eckert
Date: April 23, 2026
Description: This PHP script defines a class called MyInteger that encapsulates an integer value and provides methods 
to determine if the value is even, odd, or prime. The class includes a constructor for initializing the value, getter 
and setter methods for accessing and modifying the value, and validation to ensure that the value is an integer. 
The script also includes test cases to demonstrate the functionality of the MyInteger class.
*/

class MyInteger {
    private $value;

    // Constructor to initialize the value
    public function __construct($value) {
        if (!is_int($value)) { 
            throw new InvalidArgumentException("Value must be an integer."); // Validate that the input is an integer and throw an exception if it's not
        }
        $this->value = $value;
    }

    // Method to check if the value is even
    public function isEven() {
        if (!is_int($this->value)) {
            throw new InvalidArgumentException("Value must be an integer."); // Validate that the value is an integer before performing the check and throw an exception if it's not
        }
        return $this->value % 2 === 0;
    }

    // Method to check if the value is odd
    public function isOdd() {
        if (!is_int($this->value)) {
            throw new InvalidArgumentException("Value must be an integer."); // Validate that the value is an integer before performing the check and throw an exception if it's not
        }
        return $this->value % 2 !== 0;
    }

    // Method to check if the value is prime
    public function isPrime() {
        if (!is_int($this->value)) {
            throw new InvalidArgumentException("Value must be an integer."); // Validate that the value is an integer before performing the check and throw an exception if it's not
        }
        if ($this->value <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($this->value); $i++) { // Check for factors from 2 to the square root of the value to determine if it's prime
            if ($this->value % $i === 0) { // If a factor is found, the value is not prime and the method returns false
                return false;
            }
        }
        return true; // If no factors are found, the value is prime and the method returns true
    }

    // Getter for the value
    public function getValue() {
        return $this->value;
    }

    // Setter for the value
    public function setValue($value) {
        if (!is_int($value)) {
            throw new InvalidArgumentException("Value must be an integer."); // Validate that the input is an integer and throw an exception if it's not
        }
        $this->value = $value;
    }
}

// Starting integers values for testing two different instances of MyInteger
$integerOne = 7;
$integerTwo = 10;

// Create two instances of MyInteger supplying integer values to the constructor
$testOne = new MyInteger($integerOne); 
$testTwo = new MyInteger($integerTwo); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<meta name="description" content="">
	<meta name="author" content="Wade Eckert">
	<title>CSD 440: Module 6.2 Assignment</title>
</head>
<body>
    <h1 align="center" style="font-weight: bold;">Wade Eckert's MyInteger Class Test</h1>
    <table align="center" border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Value</th>
            <th>Is Even?</th>
            <th>Is Odd?</th>
            <th>Is Prime?</th>
        </tr>
        <tr>
            <td><?php echo $testOne->getValue(); ?></td>
            <td><?php echo $testOne->isEven() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testOne->isOdd() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testOne->isPrime() ? 'Yes' : 'No'; ?></td>
        </tr>
        <tr>
            <td><?php echo $testTwo->getValue(); ?></td>
            <td><?php echo $testTwo->isEven() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testTwo->isOdd() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testTwo->isPrime() ? 'Yes' : 'No'; ?></td>
        </tr>
        <tr>
            <!-- Update the value in the first instance to 17, then display the new value and the results of the methods again -->
            <td><?php $testOne->setValue(17); echo $testOne->getValue(); ?></td>
            <td><?php echo $testOne->isEven() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testOne->isOdd() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testOne->isPrime() ? 'Yes' : 'No'; ?></td>
        </tr>
        <tr>
            <!-- Update the value in the second instance to 20, then display the new value and the results of the methods again -->
            <td><?php $testTwo->setValue(20); echo $testTwo->getValue(); ?></td>
            <td><?php echo $testTwo->isEven() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testTwo->isOdd() ? 'Yes' : 'No'; ?></td>
            <td><?php echo $testTwo->isPrime() ? 'Yes' : 'No'; ?></td>
    </table>
</body>
</html>