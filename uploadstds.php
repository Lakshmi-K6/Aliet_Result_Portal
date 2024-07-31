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


// Check if a file is uploaded
if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_type = $_FILES["file"]["type"];
    
    // Verify file extension
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if(strtolower($ext) == "csv"){
        // Read the file
        $file = fopen($file_tmp, "r");
        
        // Skip the header row if needed
        // fgetcsv($file);

        // Insert data into database
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            //$sql = "INSERT INTO studentdetails (Htno,Studentname,Branch,Branchcode,DOB) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]')";
            $sql = "INSERT INTO studentdetails (Htno, Studentname, Branch, Branchcode, DOB) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]')";

            if ($conn->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        fclose($file);
        echo "CSV file uploaded and data inserted successfully.";
    } else {
        echo "Invalid file format. Please upload a CSV file.";
    }
} else {
    echo "Error uploading file.";
}

// Close connection
$conn->close();
?>
