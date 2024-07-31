<?php
// Assuming you have already established the database connection
include("init.php");
session_start();
// Function to handle the CSV file upload and update the database
function updateResultsFromCSV($csvFile, $conn) {
    // Open the CSV file
    $file = fopen($csvFile, "r");
    fgetcsv($file);
    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
        $htno = $data[0]; 
        $year= $data[2];
        $sem = $data[3];
        $subcode=$data[4];
        $subname=$data[5];
        $grade = $data[7]; 
        $credits = $data[8];
        $sql = "UPDATE result 
        SET 
            Grade = CASE 
                        WHEN '$grade' <> 'No change' THEN '$grade' 
                        ELSE Grade 
                    END,
            Credits = CASE 
                        WHEN '$grade' <> 'No change' THEN '$credits' 
                        ELSE Credits 
                    END
        WHERE 
            Htno = '$htno' 
            AND Year='$year' 
            AND Sem='$sem' 
            AND Subcode='$subcode' 
            AND Subname='$subname'";
        // Update the database table based on Htno
       // $sql = "UPDATE result SET Grade = '$grade', Credits = '$credits' WHERE Htno = '$htno' and Year='$year' and Sem='$sem' and Subcode='$subcode' and Subname='$subname'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully for $htno<br>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    fclose($file);
}
if(isset($_POST["submit"])) {
    $file = $_FILES["file"]["tmp_name"];
    updateResultsFromCSV($file, $conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Supplementary Results</title>
</head>
<body>
    <h2>Upload Supplementary Results CSV</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" name="submit" value="Upload">
    </form>
    <a href =upload.html >Home</a>
</body>
</html>