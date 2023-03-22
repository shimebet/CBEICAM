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
<i style="color: black; text-align:left;"><a href="index.php"><?php echo ucfirst($_SESSION['user']['user_type']); ?>&nbsp;Dashboard</a></i>  
<?php endif ?>
<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<i class="fas fa-align-justify"></i>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="nav navbar-nav ml-auto">
<?php if (isset($_SESSION['user'])) : ?>
<!-- <strong style="color:black"> Current User:- &nbsp;&nbsp;    <?php echo $_SESSION['user']['username']; ?></strong>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   -->
<!-- <strong><a href="create_user.php" style=" text-align: center; color:peru;">AddUser</a></strong>
&nbsp;&nbsp;&nbsp; -->

<!-- <div class="dropdown" style="color:red">
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
<form class="d-flex">
<input class="form-control me-2" type="text" placeholder="Search" id= "searchBox" >
<button class="btn btn-primary" type="button">Search</button>
</form>
<h6 style="text-align: center; color:black; font-style:italic;">Manage User Account </h6>
<?php
$sql = "SELECT * FROM `users`";
$Sql_query = mysqli_query($db,$sql);
$All_users = mysqli_fetch_all($Sql_query,MYSQLI_ASSOC);
?>
<style>
.btn1{
background-color: red;
border: none;
color: white;
padding: 5px 5px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 20px;
margin: 4px 2px;
cursor: pointer;
border-radius: 20px;
}
.green{
background-color: #199319;
}
.red{
background-color: red;
}
table,th{
text-align :center;
}
td{
text-align :center;
}
</style>	
<div style="overflow-x:auto;">
<table border="1" id="myTable" style="width:100% ; " >
<tr>
<th>User Name</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>
<?php
foreach ($All_users as $users) { ?>
<tr>
<td><?php echo $users['username']; ?></td>
<td><?php echo $users['email']; ?></td>
<td><?php echo $users['user_type']; ?></td>
<td>
<?php
if($users['status']=="0")
echo
"<a href=deactivate.php?id=".$users['id']." class='btn1 red'>Deactivate</a>";
else
echo
"<a href=activate.php?id=".$users['id']." class='btn1 green'>Activate</a>";
?>
</td>
</tr>

<?php
}
// End the foreach loop
?>
</table>
</div>
<script>
function performSearch() {
var filter = searchBox.value.toUpperCase();
for (var rowI = 0; rowI < trs.length; rowI++) {
var tds = trs[rowI].getElementsByTagName("td");
trs[rowI].style.display = "none";
for (var cellI = 0; cellI < tds.length; cellI++) {
if (tds[cellI].innerHTML.toUpperCase().indexOf(filter) > -1) {
trs[rowI].style.display = "";
continue;

}
}
}
}
// declare elements
const searchBox = document.getElementById('searchBox');
const table = document.getElementById("myTable");
const trs = table.tBodies[0].getElementsByTagName("tr");
// add event listener to search box
searchBox.addEventListener('keyup', performSearch);
</script>

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