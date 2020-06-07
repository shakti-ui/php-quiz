<?php
require('database.php');
session_start();
if(isset($_SESSION["email"]))
{
  session_destroy();
}

$ref=@$_GET['q'];		
if(isset($_POST['submit']))
{	
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $email = stripslashes($email);
  $email = addslashes($email);
  $pass = stripslashes($pass); 
  $pass = addslashes($pass);
  $email = mysqli_real_escape_string($connection,$email);
  $pass = mysqli_real_escape_string($connection,$pass);					
  $str = "SELECT * FROM user WHERE email='$email' and password='$pass'";
  $result = mysqli_query($connection,$str);
  if((mysqli_num_rows($result))!=1) 
  {
    echo "<center><h3><script>alert('Sorry.. Wrong Username (or) Password');</script></h3></center>";
    header("refresh:0;url=login.php");
  }
  else
  {
    $_SESSION['logged']=$email;
    $row=mysqli_fetch_array($result);
    $_SESSION['name']=$row[1];
    $_SESSION['id']=$row[0];
    $_SESSION['email']=$row[2];
    $_SESSION['password']=$row[3];
    header('location: welcome.php?q=1'); 					
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>Login</title>
</head>
<body>
<div class="row mt-5">
    <div class="col-md-6 m-auto">
      <div class="card card-body">
        <h1 class="text-center mb-3"><i class="fas fa-sign-in-alt"></i>  Login</h1>
       
        <form action="login.php" method="POST">
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              class="form-control"
              placeholder="Enter Email"
            />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control"
              placeholder="Enter Password"
            />
          </div>
          <button name ="submit" type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="lead mt-4">
          No Account? <a href="register.php">Register</a>
        </p>
      </div>
    </div>
  </div>
  
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
    
</body>
</html>

