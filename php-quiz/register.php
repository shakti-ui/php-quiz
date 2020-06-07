<?php
include("database.php");
session_start();

if(isset($_POST['submit']))
{	
  $name = $_POST['name'];
  $name = stripslashes($name);
  $name = addslashes($name);

  $email = $_POST['email'];
  $email = stripslashes($email);
  $email = addslashes($email);

  $password = $_POST['password'];
  $password = stripslashes($password);
  $password = addslashes($password);

  $college = $_POST['college'];
  $college = stripslashes($college);
  $college = addslashes($college);
  $str="SELECT email from user WHERE email='$email'";
  $result=mysqli_query($connection,$str);
  
  if((mysqli_num_rows($result))>0)	
  {
          echo "<center><h3><script>alert('Sorry.. This email is already registered !!');</script></h3></center>";
          header("refresh:0;url=login.php");
      }
  else
  {
          $str="insert into user set name='$name',email='$email',password='$password',college='$college'";
    if((mysqli_query($connection,$str)))	
    echo "<center><h3><script>alert('Congrats.. You have successfully registered !!');</script></h3></center>";
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
    <title>Register</title>
</head>
<body>
<div class="row mt-5">
  <div class="col-md-6 m-auto">
    <div class="card card-body">
      <h1 class="text-center mb-3">
        <i class="fas fa-user-plus"></i> Register
      </h1>
      
      <form action="register.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Name</label>
          <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            placeholder="Enter Name"
           
          />
        </div>
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
            placeholder="Create Password"
          />
        </div>
        <div class="form-group">
          <label for="college">College</label>
          <input
            type="college"
            id="college"
            name="college"
            class="form-control"
            placeholder="Enter College Name"
            
          />
        </div>
        <button  name ="submit" type="submit" class="btn btn-primary btn-block">
          Register
        </button>
      </form>
      <p class="lead mt-4">Have An Account? <a href="login.php">Login</a></p>
    </div>
  </div>
</div>
<script src="js/jquery.js">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
    
</body>
</html>