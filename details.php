<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Details</title>
<style>
  /* CSS code for styling the form #e4faff*/
  body {
    font-family: Arial, sans-serif;
    background-color: #ECE2DF	;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .container {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 300px;
  }
  .container h2{
    width: 100%;
    height:auto;
    text-align:center;
    font-size:24px;
    font-weight:bold;
    color:#00415A;

  }
  input[type="text"],
  input[type="password"],
  input[type="submit"],
  select {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    background-color: #228B22;
    color: #fff;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #228B22;
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Enter Your Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      
      <label for="branch">Branch:</label>
      <select id="branch" name="branch" required>
        <option value="CIVIL">CIVIL</option>
        <option value="CSE">CSE</option>
        <option value="ECE">ECE</option>
        <option value="EEE">EEE</option>
        <option value="MECH">MECH</option>
        <option value="IT">IT</option>
        
        <!-- Add other branch options as needed -->
      </select><br>
      <label for="year">Year:</label>
      <select id="year" name="year" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3 </option>
        <option value="4">4</option>
        <!-- Add other year options as needed -->
      </select><br>
      <label for="semester">Semester:</label>
      <select id="semester" name="semester" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <!-- Add other semester options as needed -->
      </select><br>
      <input type="submit" value="Check Result">
      <a href='login.php'>Login</a>
    </form>
  </div>
</body>
</html>

<?php
include("init.php");
session_start();

$username = $_SESSION['username'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username (Htno), password (DOB), branch, year, and semester from form
    $username = $_SESSION['username'];
    $branch = $_POST["branch"];
    $year = $_POST["year"];
    $semester = $_POST["semester"];
    $_SESSION['year'] = $year;
    $_SESSION['semester'] = $semester;
    $_SESSION['branch'] = $branch;
    
          $sql_student = "SELECT r.*, s.Branch 
                          FROM result r
                          JOIN studentdetails s ON r.Htno = s.Htno
                          WHERE r.Htno = '$username' AND r.Year = '$year' AND r.Sem = '$semester' AND s.Branch = '$branch'";
          
          // Execute the query
          $result = $conn->query($sql_student);
          if ($result->num_rows > 0) {
              // Redirect the user to result.php
              header("Location: result.php");
              exit(); 
          } 
          else {
              
              header("Location: error2.html");
              exit();
          }
        }
?>