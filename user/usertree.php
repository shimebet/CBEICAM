<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
ul, #myUL {
list-style-type: none;
cursor: context-menu;
} 

#myUL {
margin: 0;
padding: 0;
}

.box {
cursor: pointer;
-webkit-user-select: none; /* Safari 3.1+ */
-moz-user-select: none; /* Firefox 2+ */
-ms-user-select: none; /* IE 10+ */
user-select: none;
font-size: larger;
}

.box::before {
content: "\2610";
color: black;
display: inline-block;
margin-right: 6px;
}

.check-box::before {
content: "\2611"; 
color: rgba(2, 4, 5, 0.979);
}

.nested {
display: none;
text-decoration: none;
}
a:hover{
cursor: pointer;

}
.active {
display: block;
}
</style>
</head>
<body>
<?php if (isset($_SESSION['user'])) : ?>
<strong><i style="text-align: center; color:black; "> <a href="userindex.php"> <?php echo ucfirst($_SESSION['user']['district']); ?>&nbsp;&nbsp;District </a></i></strong>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php endif ?>
<ul id="myUL">
<li><span class="box">Region/District</span>
<?php 
$list = $_SESSION['user']['district'];
$sql= "SELECT DISTRICT_NAME FROM district where DISTRICT_NAME = '$list'  GROUP BY DISTRICT_NAME";

if($result = mysqli_query($db, $sql)){
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)){

?>


<ul class="nested"> 
<li><a href="addisababa.php" style="color: black;"><?PHP 
 echo  $row['DISTRICT_NAME'] ;?> </a></li>
</ul>

<?PHP

      }
      mysqli_free_result($result);
    }
  }
?>

<li><span class="box">Account</span>
<ul class="nested">
<li><a href="change-password.php" style="color: black;">Change Password</a></li>
</ul>
</li>
<li><span class="box">EJ Report</span>
        <ul class="nested">
          <li><a href="ejdownload.php" style="color: black;">Download </a></li>
          <li><a href="ejview.php" style="color: black;">View</a></li>
        </ul>
       </li>
</li>
</ul>

<script>
var toggler = document.getElementsByClassName("box");
var i;

for (i = 0; i < toggler.length; i++) {
toggler[i].addEventListener("click", function() {
this.parentElement.querySelector(".nested").classList.toggle("active");
this.classList.toggle("check-box");
});
}
</script>

</body>
</html>
