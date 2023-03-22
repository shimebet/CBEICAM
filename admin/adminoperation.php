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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
<i ><a href="index.php" style="color: black; text-align:left;"><?php echo ucfirst($_SESSION['user']['user_type']); ?>&nbsp;Dashboard</a></i>  
<?php endif ?>
<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<i class="fas fa-align-justify"></i>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="nav navbar-nav ml-auto">
<?php if (isset($_SESSION['user'])) : ?>
<!-- <strong style="color:black"> Current User:- &nbsp;&nbsp;    <?php echo $_SESSION['user']['username']; ?></strong>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    -->
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
<h6 style="text-align: center; color:black; font-style:italic;">User Details </h6>
<div class="row"> 
<style>
.wrapper1{
width: 100%;
margin: 0 auto;
}
table tr td:last-child{
width: 120px;
}
</style>
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();   
});
</script>
<div class="wrapper1">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div style="overflow-x:auto;">
<?php
// Attempt select query execution
$sql = "SELECT * FROM users";
if($result = mysqli_query($db, $sql)){
if(mysqli_num_rows($result) > 0){
echo '<table class="table table-bordered table-striped" id="myTable">';
echo "<thead>";
echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Employee Name</th>";
    echo "<th>Email Address</th>";
    echo "<th>Employee Role</th>";
    echo "<th>District Name</th>";
    echo "<th>Action</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
while($row = mysqli_fetch_array($result)){
echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['user_type'] . "</td>";
    echo "<td>" . $row['district'] . "</td>";
    echo "<td>";
        echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
        echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fas fa-pencil-alt"></span></a>';
        echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
    echo "</td>";
echo "</tr>";
}
echo "</tbody>";                            
echo "</table>";
// Free result set
mysqli_free_result($result);
} else{
echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
}
} else{
echo "Oops! Something went wrong. Please try again later.";
}

// Close connection
mysqli_close($db);
?>
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
</div>

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