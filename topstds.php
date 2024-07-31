<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALIET Result Portal</title>
    <style>
       

        /*img {
            display: block;
            width: 100%;
            height: auto; 
        }*/
        

        .button {
            display: inline-block;
            color: rgb(20, 20, 20);
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            font-size: 20px;
            padding: 10px 20px;
            margin: 0px;
            border: none;
            cursor: pointer;
            height: 35px;
            width:120px;
            padding-left: 100px;
            padding-top: 15px;
            padding-bottom: 15px;
            padding-right: 100px;
            
           
        }

        

        nav {
            background-color: #B9D9EB;
            /*#B0E0E6;*/
            display: flex;
            justify-content: center;
            width: 100%;
            height:60px;
        
        
            
            
        }
        .button:hover {
            
            background-image: linear-gradient(to right, #7CB9E8,#F0F8FF);
        color: black;
        height: 30px;
        
}
body {
            margin: 0;
            padding: 0;
        }
 

        .image {
            display: flex;
            width: 100%; 
            height: 150px; 
        }
        




        
    </style>
</head>
<body>
    <img src="header.png" class="image" alt="Header Image">
    <nav>
        <a href="upload.html" class="button"><b>Upload</b></a>
        <a href="toplistlogin.php" class="button"><b>Go Back</b></a>
        <a href="login.php" class="button"><b>LogOut</b></a>
    </nav>
    
</body>
</html>

<?php
include("init.php");
session_start();

// Assuming you've received branch, year, and semester as inputs
$branch = $_SESSION['branch'];
$year = $_SESSION['year'];
$sem = $_SESSION['semester'];
$username = $_SESSION['username'];

function getCreditValue($year, $semester, $branch, $conn) {
    $year = mysqli_real_escape_string($conn, $year);
    $semester = mysqli_real_escape_string($conn, $semester);
    $branch = mysqli_real_escape_string($conn, $branch);
    $query = "SELECT Credits FROM syllabus WHERE Year = '$year' AND Sem = '$semester' AND Branch = '$branch'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['Credits'];
        } else {
            
            return 0;
        }
    } else {
        return false;
    }
}
$creditValue = getCreditValue($year, $sem, $branch,$conn); // $connection is your database connection



// Calculate GPA for each student in the specified branch, year, and semester
$sql = "SELECT s.Htno, s.Studentname, ROUND(SUM(r.Credits * CASE r.Grade 
            WHEN 'A+' THEN 10 
            WHEN 'A' THEN 9 
            WHEN 'B' THEN 8 
            WHEN 'C' THEN 7 
            WHEN 'D' THEN 6 
            WHEN 'E' THEN 5 
            WHEN 'F' THEN 0
           ELSE 0
        END) /$creditValue , 2) AS GPA
        FROM studentdetails s
        INNER JOIN result r ON s.Htno = r.Htno
        WHERE r.Year = $year AND r.Sem = $sem AND s.Branch = '$branch'
        GROUP BY s.Htno, s.Studentname";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $rows[] = $row;
}


function sortByGPA($a, $b) {
    return $a['GPA'] < $b['GPA']; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Page</title>
    <style>
        /* Your CSS rules here */
        body {
            font-family: Arial, sans-serif;
        }
        th, td {
        padding: 8px;
        text-align: left;
         border-bottom: 1px solid #ddd;
        }
    th {
         background-color: #f2f2f2;
         text-align: center;
    }
</style>

</head>
<body>

</body>
</html>
<?php
usort($rows, 'sortByGPA');

$serialNumber = 1; // Initialize serial number counter

echo "<h2 style='text-align:center;'>RankBoard.. </h2>";
echo "<table style='width: 690px; border-collapse: collapse; margin: 0 auto;' border='1'>";

echo "<tr><th>S.No</th><th>HTNO</th><th>Student Name</th><th>GPA</th>";
//<th>GPA</th></tr>";
for ($i = 0; $i < min(5, count($rows)); $i++) {
    $row = $rows[$i];
    echo "<tr>";
    echo "<td>" . $serialNumber++ . "</td>"; 
    echo "<td>" . $row["Htno"] . "</td>";
    echo "<td>" . $row["Studentname"] . "</td>";
    echo "<td>" . number_format($row["GPA"], 2) . "</td>"; 
    echo "</tr>";
}


echo "</table>";


if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
        echo  $row["Htno"]. "       " . $row["Studentname"]. "<br>";
    }
    //echo  $row["Htno"]. "       " . $row["Studentname"]. " - GPA: " . $row["GPA"]. "<br>";
} else {
    echo "0 results";
}
$conn->close();
?>

