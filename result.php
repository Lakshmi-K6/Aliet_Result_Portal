<?php
include("init.php");
session_start();
$username = $_SESSION['username'];
$year = $_SESSION["year"];
$branch =$_SESSION["branch"];
$semester = $_SESSION["semester"];
$sql = "SELECT * FROM result WHERE Htno = '$username' AND Year = '$year' AND Sem = '$semester'";
$result = $conn->query($sql);
$sql1="SELECT  Studentname from studentdetails WHERE Htno = '$username'";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    // Fetch the name and store it in a variable
    $row = $result1->fetch_assoc();
    $student_name = $row['Studentname'];
} else {
    // Handle the case where no results are found
    $student_name = "Unknown";
}

// Function to retrieve credit value from syllabus table
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
// Call the function to get credit value
$creditValue = getCreditValue($year, $semester, $branch, $conn); // $connection is your database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Result</title>
<style>
       
    table {
    margin: 0 auto;
    border-collapse: collapse;
    }
    th, td {
    padding: 8px;
    border: 1px solid #ddd;
   }

    th {
    background-color: #f2f2f2;
    }
    
    .gap{
        display: inline-block;
        margin-right: 10px;
        margin-left:230px;
         /* Align the elements vertically */
    }
    .gap1{
        display: inline-block;
               
         /* Align the elements vertically */
    }
    .gap2{
        display: inline-block;
        margin-right: 10px;
        margin-left:320px;
         /* Align the elements vertically */
    }
    .divtag{
        margin-left:180px; 
               
         /* Align the elements vertically */
    }
   
  .gpa {
    padding: 10px 20px;
    background-color:#5DBB63;/*##6D8165;/*#54927d;/*#54927d;/*#4CAF50;  green */
    color: white;
    border: none;
    border-radius:10px;
    cursor: pointer;
    font-size: 28px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    transition-duration: 0.4s;
    font-size:bold;
    height:70px;
    width:160px;
  }
  .homebutton{
    padding: 10px 20px;
    background-color:#776F5F;/*#D48C8C;/*#4CAF50;  green */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    transition-duration: 0.4s;
    font-size:bold;
    margin-left:200px;
  }
  
  /*.button:hover {
    background-color: #45a049; /* darker green when hovered 
  }*/
  .score{
    text-align:center;
    display:inline-block;
    margin-left:180px;
    /*background-color: ;*/
    
  }
  .goback{
    padding: 10px 20px;
    background-color: #776F5F;/*#4CAF50;  green */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    transition-duration: 0.4s;
    font-size:bold;
    margin-left:50px;

  }
  .dept{
    margin-left:430px;
   
  }
  .button-container button {
            display: inline-block; /* Display buttons in the same line */
            margin: 50px; 
        }
    .cgpa{
        padding: 10px 20px;
        
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        transition-duration: 0.4s;
        background-color:#3e3041	;
        font-size:bold;
        margin-left:290px;
  }
  .rank{
           padding: 10px 20px;
        
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        transition-duration: 0.4s;
        background-color:#3e3041	;
        font-size:bold;
        margin-left:180px;
  }
  
  body {
            margin: 0;
            padding: 0;
        }
 

        .image {
            display: flex;
            width: 100%; 
            height: 150px; 
        }     .button {
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
  
</style>    
</head>
<body>
<img src="header.png" class="image" alt="Header Image">
<nav>
        <a href="login.php" class="button"><b>Home</b></a>
        <a href="details.php" class="button"><b>Go Back</b></a>
        <a href="homepage.html" class="button"><b>LogOut</b></a>
    </nav>
    
    <div class="divtag">
      
    <h2 class=dept>Department of 
        <?php echo $branch?>
           <!-- if ($branch == "IT") {
        echo "Electronics and Communication Enginnering";
    }Information Technology
    if ($branch == "CSE") {
        echo "Computer Science Engineering";
    }if ($branch == "CIVIL") {
        echo "Civil Engineering";
    }if ($branch == "ECE") {
        echo "Electronics and Communication Enginnering";
    }if ($branch == "EEE") {
        //echo "Electrical and Electronic Engineering";-->
    </h2>
    <h4 class="gap">HTNo:</h4>
    <p class="gap1"><?php echo $username; ?></p> 
    <h4 class="gap">Name:</h4>
    <p class="gap1"><?php echo $student_name; ?></p><br>
    <h4 class="gap">Year:</h4>
    <p class="gap1"><?php echo $year; ?></p>
    <h4 class="gap2">Semester:</h4>
    <p class="gap1"><?php echo $semester; ?></p> 
    </div><br><br>





<?php if ($result->num_rows > 0): ?>
    
    <table border="1">
        <thead>
            <tr>
                <th>Subcode</th>
                <th>Subname</th>
                <th>Internals</th>
                <th>Grade</th>
                <th>Credits</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_grade_points = 0;
            //$total_credits = 0.0;
            while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["Subcode"]; ?></td>
                <td><?php echo $row["Subname"]; ?></td>
                <td><?php echo $row["Internals"]; ?></td>
                <td><?php echo $row["Grade"]; ?></td>
                <td><?php echo $row["Credits"]; ?></td>
                <?php
                // Calculate grade points and total credits
                $grade_points = calculateGradePoints($row["Grade"]);
                $creditValue = getCreditValue($year, $semester, $branch, $conn);
                $total_grade_points += $grade_points *$row["Credits"];
                //$total_credits += $row["Credits"];
                //$creditValue = getCreditValue($year, $semester, $branch, $conn);
                ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php 
    // Calculate GPA
    if ($creditValue> 0) {
        $gpa = $total_grade_points /$creditValue ;
    } else {
        $gpa = 0;
    }
    ?>
 <?php
include("init.php");
$branch = $_SESSION['branch'];
$year = $_SESSION['year'];
$sem = $_SESSION['semester'];
$username = $_SESSION['username'];
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
$rows = array();
while($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
function sortByGPA($a, $b) {
    return $a['GPA'] < $b['GPA']; 
}
usort($rows, 'sortByGPA');
// Assuming $targetHtno is the HTNO of the student you want to find the rank for
$targetHtno = "$username";
$rank = 1; // Initialize rank counter
// Search for the target student in the sorted array
$targetRank = null;
foreach ($rows as $row) {
    if ($row["Htno"] === $targetHtno) {
        $targetRank = $rank;
        break;
    }
    $rank++;
}
?> 
  
</head>
<body>
    <div class="button-container">
         <!--<a href="homepage.html" class="homebutton">HOME</a>  
         <a href="details.php" class='goback'>Go Back</a> --> 
         <a href="script.html"  class=cgpa>CGPA Score..</a>
        <h3 class="score" ><button class="gpa">GPA:<?php echo number_format($gpa, 2); ?></button></h3>
        
        <a href="rank.php"  class=rank>Rank : <?php if ($targetRank !== null) { echo "$targetRank"; } 
                                                    else {echo "not found"; } ?>   </a>
    </div>
 
<?php else: ?>
    <p>No results found</p>
<?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>

<?php 
function calculateGradePoints($grade) {
    // Define your grade points mapping here
    $grade_points = [
        'A+' => 10,
        'A' => 9,
        'B' => 8,
        'C' => 7,
        'D' => 6,
        'E' => 5,
        'F' => 0,
        'COMPLE'=>0,
        'ABSENT'=>0
    ];

    // Return the grade points if available, otherwise return 0
    return isset($grade_points[$grade]) ? $grade_points[$grade] : 0;
}
?>