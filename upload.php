<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload CSV</title>
<style>
    body {
        margin: 0;
        padding: 0;
    }

    .image {
        display: flex;
        width: 100%;
        height: 150px;
    }

    h2{
        text-align: center;
    }

    .form{
        text-align: center;
    }    
</style>
</head>
<body>
    <img src="header.png" class="image" alt="Header Image">
   
    <h2>Upload CSV File</h2>
    <form method="post" enctype="multipart/form-data" class="form">
        <input type="file" name="file" accept=".csv" required>
        <button type="submit">Upload</button>
        <a href="upload.html" class="button">Go Back</a> 
    </form>
</body> 
</html>
<?php
include("init.php");
session_start();

// Function to handle the CSV file upload and update the database
function handleCSVUpload($csvFile, $conn) {
    // Open the CSV file
    $file = fopen($csvFile, "r");

    // Skip the header row
    fgetcsv($file);

    // Loop through each row in the CSV file
    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
        // Extract data from the CSV row
        $htno = $data[0]; // Assuming it's the first column
        $year= $data[2];
        $sem = $data[3];
        $subcode=$data[4];
        $subname=$data[5];
        $grade = $data[7]; // Assuming Grade column is at index 5
        $credits = $data[8]; // Assuming Credits column is at index 7

        // Update the database table based on Htno
        $sql = "UPDATE result SET Grade = '$grade', Credits = '$credits' WHERE Htno = '$htno' and Year='$year' and Sem='$sem' and Subcode='$subcode' and Subname='$subname'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully for $htno<br>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Close the file
    fclose($file);
}

// Check if a file is uploaded
if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_type = $_FILES["file"]["type"];
    
    // Verify file extension
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if(strtolower($ext) == "csv"){
        // Open the file for reading
        $file = fopen($file_tmp, "r");
        if ($file) {
            // Read the file line by line
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                // Insert data into the database
                $sql = "INSERT INTO result (Htno,Branchid,Year,Sem,Subcode,Subname,Internals,Grade,Credits) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]','$data[8]')";
                if ($conn->query($sql) === FALSE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            fclose($file); // Close the file handle
            echo "CSV file uploaded and data inserted successfully.";
        } else {
            echo "Error opening file.";
        }
    } else {
        echo "Invalid file format. Please upload a CSV file.";
    }
} else {
    echo "Error uploading file.";
}

// Check if the form is submitted
if(isset($_POST["submit"])) {
    // Get the uploaded file
    $file = $_FILES["file"]["tmp_name"];

    // Call the function to update results from CSV
    handleCSVUpload($file, $conn);
}

$conn->close();
?>

