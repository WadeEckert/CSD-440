<?php
/* 
Course: CSD 440: Server-Side Scripting
Assignment: Module 11 PDF Assignment
Original Author: Wade Eckert
Professor: Darrell Payne
Date: May 28, 2026
Description: Creates a PDF report using the players table from the Baseball_01 database. 
The report includes general information about the baseball home run data, a table header, a table footer, 
and a formatted data table of all player records from Module 8.
*/ 

// FPDF library is required to create the PDF file and can be downloaded from http://www.fpdf.org/
require('fpdf/fpdf.php');

// Database connection information for the Baseball_01 database created in Module 8
$servername = "localhost";
$username = "student1";
$password = "pass";
$dbname = "baseball_01";

// Create connection to the baseball_01 database using MySQLi and suppress error messages with @ to handle them manually
$conn = @new mysqli($servername, $username, $password, $dbname);

// Check the database connection and display a custom error message if the connection fails
if ($conn->connect_error) {
    die("Connection to the baseball_01 database failed: " . $conn->connect_error);
}

// Query all player records from the players table and sort the results by home runs in descending order and 
// season year in ascending order to show the most notable home run records first
$sql = "SELECT first_name, last_name, team, position, season_year, home_runs, batting_avg, active_player
        FROM players
        ORDER BY home_runs DESC, season_year ASC";

// Store the query result in a variable to be used later when building the PDF table
$result = $conn->query($sql);

// Custom PDF class used to add a consistent header and footer to each page
class PDF extends FPDF
{
    // Page header displayed at the top of each page. Includes the report title and a brief description of the data being displayed
    function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Baseball Home Run Records Report', 0, 1, 'C'); // Main title of the report centered at the top of the page 
        $this->SetFont('Arial', '', 10); 
        $this->Cell(0, 8, 'Generated from the Baseball_01 players table', 0, 1, 'C'); // Subtitle providing context about the source of the data, also centered below the main title
        $this->Ln(4);
    }

    // Page footer displayed at the bottom of each page. Includes the author's name, course information, and the current page number formatted as "Page X"
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Wade Eckert | CSD 440 | Page ' . $this->PageNo(), 0, 0, 'C'); // Footer text centered at the bottom of the page with the author's name, course information, and dynamic page number
    }
}

// Create a landscape PDF so the full table fits better across the page and set the page size to A4 (210mm x 297mm)
// This PDF will be generated in millimeters for precise layout control
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages(); // This allows the total number of pages to be displayed in the footer if needed, but in this case we are only showing the current page number
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 18); // Enable automatic page breaks with a bottom margin of 18mm to ensure the footer is not overlapped by content

// General report information displayed at the top of the first page before the data table
// This section provides an overview of what the report contains and the context of the data being presented
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Report Overview', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 6, 'This PDF displays baseball player data from the Module 8 database table. The data focuses on notable single-season home run records and includes each player name, team, position, season year, home run total, batting average, and whether the player is listed as active or retired.');
$pdf->Ln(4);

// Display the total number of records returned before the table
$totalRecords = ($result) ? $result->num_rows : 0; // This checks if the query result is valid and counts the number of records, otherwise it defaults to 0 if there was an issue with the query
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 7, 'Total Records Returned: ' . $totalRecords, 0, 1, 'L');
$pdf->Ln(2);

// Table header function so the header can be repeated if the table continues to a new page.
function printTableHeader($pdf)
{
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetFillColor(31, 60, 92); // A dark blue background color for the header cells to make them stand out from the data rows
    $pdf->SetTextColor(255, 255, 255); // Set the text color to white for better contrast against the dark blue background of the header cells
    $pdf->Cell(28, 8, 'First Name', 1, 0, 'C', true); 
    $pdf->Cell(30, 8, 'Last Name', 1, 0, 'C', true);
    $pdf->Cell(55, 8, 'Team', 1, 0, 'C', true);
    $pdf->Cell(38, 8, 'Position', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Season', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Home Runs', 1, 0, 'C', true);
    $pdf->Cell(28, 8, 'Batting Avg', 1, 0, 'C', true);
    $pdf->Cell(28, 8, 'Status', 1, 1, 'C', true);
    $pdf->SetTextColor(0, 0, 0); // Reset text color to black for the data rows after printing the header
}

// Print the first table header
printTableHeader($pdf);

// Check for records before building the data table
if ($result && $result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 8);

    // Loop through each database record and print it as one row in the PDF table
    while ($row = $result->fetch_assoc()) {
        // Add a new page and repeat the table header if the next row is too close to the footer
        if ($pdf->GetY() > 180) {
            $pdf->AddPage();
            printTableHeader($pdf);
            $pdf->SetFont('Arial', '', 8);
        }

        // Convert the active_player value to a more user-friendly status of "Active" or "Retired" for display in the PDF table
        $status = ($row['active_player'] == 1) ? 'Active' : 'Retired';

        // Print each cell of the current row with the appropriate formatting. The batting average is formatted to three decimal places 
        // for consistency with standard baseball statistics
        $pdf->Cell(28, 7, $row['first_name'], 1, 0, 'C');
        $pdf->Cell(30, 7, $row['last_name'], 1, 0, 'C');
        $pdf->Cell(55, 7, $row['team'], 1, 0, 'C');
        $pdf->Cell(38, 7, $row['position'], 1, 0, 'C');
        $pdf->Cell(25, 7, $row['season_year'], 1, 0, 'C');
        $pdf->Cell(25, 7, $row['home_runs'], 1, 0, 'C');
        $pdf->Cell(28, 7, number_format($row['batting_avg'], 3), 1, 0, 'C');
        $pdf->Cell(28, 7, $status, 1, 1, 'C');
    }

// If there are no records returned from the query, display a message in the PDF indicating that no data was found
} else {
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 8, 'No player records were found.', 1, 1, 'C');
}

// Close the database connection after the data has been added to the PDF
$conn->close();

// Display the PDF in the browser with the filename "WadeBaseballReport.pdf"
// The 'I' parameter tells FPDF to send the PDF inline to the browser for viewing rather than forcing a download
// The user can choose to save the PDF from the browser if they wish, but it will open in a new tab for immediate viewing when this code is executed
$pdf->Output('I', 'WadeBaseballReport.pdf');
?>
