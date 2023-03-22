<?php
include('../functions.php');
if (isset($_SESSION['user']['username']) ) {
    // Get hidden input value
	//echo ($id);
if (isset($_POST['op']) && isset($_POST['np'])
    && isset($_POST['c_np'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$op = validate($_POST['op']);
	$np = validate($_POST['np']);
	$c_np = validate($_POST['c_np']);
    
    if(empty($op)){
      header("Location: change-password.php?error=Old Password is required");
	  exit();
    }else if(empty($np)){
      header("Location: change-password.php?error=New Password is required");
	  exit();
    }else if($np !== $c_np){
      header("Location: change-password.php?error=The confirmation password  does not match");
	  exit();
    }else {
    	// hashing the password
    	$op = md5($op);
    	$np = md5($np);
        $id = $_SESSION['id'];
		// $id=$_GET['id'];
		$username=$_SESSION['user']['username'];
        $sql = "SELECT password
                FROM users WHERE 
                username='$username' AND password='$op'";
        $result = mysqli_query($db, $sql);
        if(mysqli_num_rows($result) === 1){
        	
        	$sql_2 = "UPDATE users
        	          SET password='$np' 
        	          WHERE username='$username'";
        	mysqli_query($db, $sql_2);
        	header("Location: index.php?success=Your password has been changed successfully");
	        exit();

        }else {
        	header("Location: change-password.php?error=Incorrect password");
	        exit();
        }

    }

    
}else{
	header("Location: change-password.php");
	exit();
}

}
else{
     header("Location: index.php");
     exit();
}
?>