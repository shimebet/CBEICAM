<?php //include('functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CBE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<nav class="navbar navbar-inverse" style="background-color:rgb(187, 52, 153);">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button> 
     <strong> <a class="navbar-brand" href="#" style="color: white;">CBE</a></strong>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar" >
      <ul class="nav navbar-nav">
        <li ><a href="index.php" style="color: white; font-size:larger;">Home</a></li>
        <li><a href="about.php" style="color: white; font-size:larger;">About Us</a></li>
        <li><a href="about.php" style="color: white; font-size:larger;">Contact Us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#"><span class="glyphicon glyphicon-user" style="color: white;"></span> Sign Up</a></li> -->
        <li><a href="loginindex.php"><span class="glyphicon glyphicon-log-in" style="color: white;"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav> 
  
<div>
 <?php include('login.php') ?>
</div>

</body>
</html>
