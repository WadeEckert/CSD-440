<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 2.2: Programming Assignment
Original Author: Wade Eckert
Date: March 28, 2026
Description: This PHP script generates a simple HTML page that displays a table filled with random numbers. 
The table use a PHP nested loop structure consisting of 5 rows and 5 columns, with each cell containing a 
random number between 1 and 100.
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta tags for responsive design -->
	<title>CSD 440: Random Number Table</title>
	<style> <!-- Basic CSS styling for the table -->
		table { border-collapse: collapse; width: 50%; margin: 20px auto; }
		th, td { border: 1px solid #333; padding: 8px 12px; text-align: center; }
		th { background: #eee; }
	</style>
</head>
<body>
	<h2 style="text-align:center;">Wade Eckert's Random Number Table for CSD 440</h2> <!-- Heading for the body of the page -->
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
							<td><?php echo rand(1, 100); ?></td>
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