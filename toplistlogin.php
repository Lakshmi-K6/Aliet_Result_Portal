<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Details</title>
<style>
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
        <label for="branchid">BranchId:</label>
      <input type="text" id="branchid" name="branchid" required maxlength="8"><br>
      <label for="branch">Branch:</label>
      <select id="branch" name="branch" required>
        <option value="CIVIL">CIVIL</option>
        <option value="CSE">CSE</option>
        <option value="ECE">ECE</option>
        <option value="EEE">EEE</option>
        <option value="MECH">MECH</option>
        <option value="IT">IT</option>
      </select><br>
      <label for="year">Year:</label>
      <select id="year" name="year" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3 </option>
        <option value="4">4</option>
      </select><br>
      <label for="semester">Semester:</label>
      <select id="semester" name="semester" required>
        <option value="1">1</option>
        <option value="2">2</option>
      </select><br>
      <input type="submit" value="Login">
      <a href='upload.html'>Go Back..</a>
    </form>
  </div>
</body>
</html>
<?php
include("init.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branchid = $_POST["branchid"];
    $branch = $_POST["branch"];
    $year = $_POST["year"];
    $semester = $_POST["semester"];
    $_SESSION['year'] = $year;
    $_SESSION['semester'] = $semester;
    $_SESSION['branch'] = $branch;
    $sql_student = "SELECT * FROM result WHERE Branchid = '$branchid' AND Year = '$year' AND Sem = '$semester' ";
    $result_student = mysqli_query($conn, $sql_student);
    if (mysqli_num_rows($result_student) > 0) {
        header("Location: topstds.php");
        exit();
    }
    else {
      header("Location: error2.html");
      exit();
    }
}
?>