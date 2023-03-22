<?php
include('../functions.php');

if (!isAdmin()) {
$_SESSION['msg'] = "You must log in first";
header('location: ../loginindex.php');
}

?>

<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>CBE</title>
<!-- Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<!-- Our Custom CSS -->
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="stylereg.css">
<link rel="stylesheet" href="../images/cbe.css">
<!-- Font Awesome JS -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<body>
<div class="wrapper">
<!-- Sidebar  --> 
<nav id="sidebar">
<div class="sidebar-header">
<h3><img src="../images/side2.png"></h3>
<a href = "index.php"> <strong style="color:black">  Online: &nbsp;&nbsp;<?php echo $_SESSION['user']['username']; ?></strong></a>
   
</div>
<?php include('admintree.php');?>
</nav>

<!-- Page Content  -->
<div id="content">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container-fluid"> 

<button type="button" id="sidebarCollapse" class="btn btn-info">
<i class="fas fa-align-left"></i>
<span>Menu</span>
</button>
&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <?php if (isset($_SESSION['user'])) : ?>
<i style="color: black; text-align:left;"><?php echo ucfirst($_SESSION['user']['user_type']); ?>&nbsp;Dashboard</i>  
<?php endif ?>
<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<i class="fas fa-align-justify"></i>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="nav navbar-nav ml-auto">
<?php if (isset($_SESSION['user'])) : ?>
<!-- <strong style="color:black"> Current User:- &nbsp;&nbsp;    <?php echo $_SESSION['user']['username']; ?></strong>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
<!-- <div class="dropdown">
<button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" style=" text-align: center; color:peru;">
<strong>Register</strong>
</button>
  <div class="dropdown-menu">
  <a class="dropdown-item" href="create_user.php"> User</a>
    <a class="dropdown-item" href="adddistrict.php"> Districrt</a>
  </div>
</div>  -->
&nbsp;&nbsp;&nbsp;&nbsp;
<strong><a href="index.php?logout='1'" style="  color: black;font-style:italic;">Logout</a></strong>



<?php endif ?>
<?php if (isset($_SESSION['success'])) : ?>
<div class="error success">
<h3>
<?php
echo $_SESSION['success'];
unset($_SESSION['success']);
?>
</h3>
</div>
<?php endif ?>
</ul>
</div>
</div>
</nav>
<!--  
<form class="d-flex">
<input class="form-control me-2" type="text" placeholder="Search" >
<button class="btn btn-primary" type="button">Search</button>
</form> -->
<h6 style="text-align: center; color:black; font-style:italic;">Register New Employee </h6>

<div class="reg">
<form method="post" action="create_user.php">

<?php echo display_error(); ?> 

<div class="input-group">
<label>Full Name</label>
<input type="text" name="username" value="<?php echo $username; ?>">
</div>
<div class="input-group">
<label>User email</label>
<input type="email" name="email" value="<?php echo $email; ?>">
</div>
<div class="input-group">
<label>User type</label>
<select name="user_type" id="user_type">
<option value=""></option>
<option value="admin">Admin</option> 
<option value="user">User</option>
</select>
</div>

<div class="input-group">
<label>District Name</label>
<?php
$sql="SELECT DISTRICT_NAME FROM district GROUP BY DISTRICT_NAME"; 
echo "<select name=district id='user_type' >DISTRICT_NAME</option>"; // list box select command
foreach ($db->query($sql) as $row){//Array or records stored in $row
echo "<option value=$row[DISTRICT_NAME]>$row[DISTRICT_NAME]</option>"; 
}
 echo "</select>";// Closing of list box
?>
</div>
<div class="input-group">
<label>Password</label>
<input type="password" name="password_1">
</div>
<div class="input-group">
<label>Confirm password</label>
<input type="password" name="password_2">
</div>
<div class="input-group">
<button type="submit" class="btn" name="register_btn"> Submit</button>
</div>
</form>
</div>
</div>
</div>

<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function() {
$('#sidebarCollapse').on('click', function() {
$('#sidebar').toggleClass('active');
});
});
</script>
</body>

</html>