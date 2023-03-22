

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
ul, #myUL {
  list-style-type: none; 
  cursor: context-menu;
  color: whitesmoke;
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
  color: white;
  margin-right: 6px;
}
 
.check-box::before {
  content: "\2611"; 
  color:white;
}

.nested {
  display: none;
  text-decoration: none;
  color: white;
}
.side a:hover{
    cursor: pointer;
    text-decoration: none;
   background-color: blueviolet;
  }
.active {
  display: block;
  font-size: medium;
}
</style>
</head>
<body>  

<ul id="myUL">
  <li><span class="box">Region/District</span>
    <ul class="nested">
  
    <?php
  $list = $_SESSION['user']['district'];
  $userlist = $_SESSION['user']['username'];

$sql= "SELECT DISTRICT_NAME, TERMINAL_ID FROM district GROUP BY DISTRICT_NAME";
if($result = mysqli_query($db, $sql)){
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)){

?>
<li><span class="box"><?PHP 
  echo  $row['DISTRICT_NAME'] ;?></span>
 <ul class="nested">
  <li><a href="addisababa.php" style="color: black;"> <?PHP 
  echo  $row['DISTRICT_NAME'] ;?></a></li>
 </ul>
</li>

<?PHP
      }
      mysqli_free_result($result);
    }
  }
?>  
      </li>  
    </ul>
    <li><span class="box">Manage</span>
        <ul class="nested">
          <li><a href="manageuser.php" style="color: black;">User Account</a></li>
          <li><a href="adminoperation.php" style="color: black;">User Information</a></li>
          <li><a href="change-password.php" style="color: black;">Change Password</a></li>
        </ul>
       </li>
       <li><span class="box">Register</span>
        <ul class="nested">
          <li><a href="create_user.php" style="color: black;">User </a></li>
          <li><a href="adddistrict.php" style="color: black;">Terminal/District</a></li>
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
<!-- <strong><a href="../ej/index.php" style=" text-align: center; color:white;" >Download/View</a></strong>
&nbsp;&nbsp;&nbsp; -->
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
