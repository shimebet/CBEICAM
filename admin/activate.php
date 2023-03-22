<?php
include('../functions.php');
	if (isset($_GET['id'])){
		$user_id=$_GET['id'];
		$sql="UPDATE `users` SET
			`status`=0 WHERE id='$user_id'";
		mysqli_query($db,$sql);
	}
	header('location: manageuser.php');
?>
