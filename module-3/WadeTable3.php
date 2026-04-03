<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 3.2: Programming Assignment
Original Author: Wade Eckert
Date: April 2, 2026
Description: This PHP script generates a 5x5 table filled with the sums of two 
random numbers in each cell, using an external function to calculate the sums.
*/ 

require_once('functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
    <meta name="description" content="A PHP script that generates a 5x5 table filled with the sums of two random numbers in each cell.">
    <meta name="author" content="Wade Eckert">
	<title>CSD 440: Random Number Table</title>
	<style> <!-- Basic CSS styling for the table -->
		table { border-collapse: collapse; width: 50%; margin: 20px auto; }
		th, td { border: 1px solid #333; padding: 8px 12px; text-align: center; }
		th { background: #eee; }
	</style>
</head>
<body>
	<h2 style="text-align:center;">Wade Eckert's Random Number Table for CSD 440 Module 3.2</h2> <!-- Heading for the body of the page -->
		<div style="text-align:center;"> <!-- Centering the table on the page -->
			<table style="margin: 0 auto;"> <!-- Table element with CSS for centering -->
				<tr>
					<th>Col 1</th>
					<th>Col 2</th>
					<th>Col 3</th>
					<th>Col 4</th>
					<th>Col 5</th>
				</tr>
				<?php
				// Set the table size
				$rows = 5;
				$cols = 5;
				// Loop to create rows
				for ($i = 0; $i < $rows; $i++) {
				?>
					<tr>
						<!-- Loop to create columns with random numbers -->
						<?php for ($j = 0; $j < $cols; $j++) {
						?>
							<?php // Generate two random numbers and store them in variables
								$rand1 = rand(1, 100);
								$rand2 = rand(1, 100);
							?>
							<td><?php echo sumTwoNumbers($rand1, $rand2); ?></td> <!-- Use the external function and display the sum of the two random numbers -->
						<?php }
						?>
					</tr>
				<?php
				}
				?>
			</table>
		</div>
</body>
</html>