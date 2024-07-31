<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
 

  
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    justify-content: center;
    align-items: center;
    
  }

  .container {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding-left: 500px;
    padding-right:685px;
    padding-top:50px;
    padding-bottom:293px;
    width: 300px;
    
    background-color:white;
    border: 1px solid #ccc;
  } 
     

.button {
        position: absolute;
        top: 150px;
        left: 0px; 
        padding: 20px;
        background-color: #B9D9EB;
        color: black;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        position:12px;
        
    }

    .button:hover {
        background-color: white;
        
    }
  

  input[type="text"],
  input[type="password"],
  input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    background-color: #0c6c34;
    color: #fff;
    cursor: pointer;
    
  }

  input[type="submit"]:hover {
    background-color: #0c6c34;
    
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
  <div class="container">
    <a href="homepage.html" class="button">HOME</a>
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required maxlength="12"><br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required maxlength="10"><br>
      <input type="submit" value="Login">
    </form>
  </div>
</body>
</html>


<?php
include("init.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION['username'] = $username;
    $sql_admin = "SELECT * FROM admin WHERE id = '$username' AND pw = '$password'";
    $result_admin = mysqli_query($conn, $sql_admin);
    if (mysqli_num_rows($result_admin) > 0) {
        header("Location: upload.html");
        exit();
    }

    // Check if username and password match studentdetails table
    $sql_student = "SELECT * FROM studentdetails WHERE Htno = '$username' AND DOB = '$password'";
    $result_student = mysqli_query($conn, $sql_student);

    if (mysqli_num_rows($result_student) > 0) {
        // Redirect to details.php
        header("Location: details.php");
        exit();
    }

    // If credentials don't match either table, redirect to error.html
    header("Location: error.html");
    exit();
  }
?>