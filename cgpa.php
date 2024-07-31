

<?php
include("init.php");
session_start();
$Htno = $_SESSION['username'];


// HTno of the student
//$Htno = $_GET['htno']; // Assuming the HTno is passed as a parameter in the URL

// SQL query to retrieve grades and credits for the student
$sql = "SELECT Grade, Credits FROM result WHERE HTno = '$Htno'";
$result = $conn->query($sql);

$total_wgp = 0; // Total Weighted Grade Points
$total_credits = 0; // Total Credits

// Check if there are any results
if ($result->num_rows > 0) {
    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        // Calculate Grade Points based on the grade obtained
        switch ($row["Grade"]) {
            case "A+": $gp = 10; break;
            case "A": $gp = 9; break;
            case "B": $gp = 8.0; break;
            case "C": $gp = 7.0; break;
            case "D": $gp = 6.0; break;
            case "E": $gp = 5.0; break;
            case "F": $gp = 0.0; break;
            // Add more cases for other grades if needed
            default: $gp = 0.0;
        }

        // Calculate Weighted Grade Points
        $wgp = $gp * $row["Credits"];

        // Update total Weighted Grade Points and total Credits
        $total_wgp += $wgp;
        $total_credits += $row["Credits"];
    }

    // Calculate CGPA
    $cgpa = $total_wgp / $total_credits;

    // Output the CGPA as JSON
    echo json_encode(array("cgpa" => number_format($cgpa, 2)));
} else {
    // Output message if no results found
    echo json_encode(array("message" => "No results found for HTno $Htno"));
}

// Close connection
$conn->close();
?>
