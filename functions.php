<?php 
	session_start();

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'cbe_db');

	// variable declaration
	$username = "";
	$email    = "";
	$errors   = array(); 

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn1'])) {
		add();
	}
	if (isset($_POST['register_btn'])) {
		register();
	}
	// call the login() function if login_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../loginindex.php");
	}
	//add district
	function add(){
		global $db, $errors;

		// receive all input values from the form
		$districtname    =  e($_POST['districtname']);
		$atmname       =  e($_POST['atmname']);
		$terminalid       =  e($_POST['terminalid']);
		$atmtype       =  e($_POST['atm_type']);
		$ipaddress  =  e($_POST['ipaddress']);

		// form validation: ensure that the form is correctly filled
		if (empty($districtname)) { 
			array_push($errors, "district name is required"); 
		}
		if (empty($atmname)) {  
			array_push($errors, "atm name is required"); 
		}
		if (empty($terminalid)) { 
			array_push($errors, "terminalid is required"); 
		}
		if (empty($atmtype)) { 
			array_push($errors, "atm type is required"); 
		}
		if (empty($ipaddress)) { 
			array_push($errors, "IP Address is required"); 
		}
		// register user if there are no errors in the form 
		if (count($errors) == 0) {
				$query = "INSERT INTO district (DISTRICT_NAME, ATM_NAME,TERMINAL_ID, ATM_TYPE, IP_ADDRESS) 
						  VALUES('$districtname', '$atmname', '$terminalid','$atmtype','$ipaddress')";
				mysqli_query($db, $query);
				echo '<script>alert("information inserted successfully")</script>';
				header('location: index.php');				
			}
	}

	// REGISTER USER
	function register(){
		global $db, $errors;

		// receive all input values from the form
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$usertype       =  e($_POST['user_type']);
		$district  = e($_POST['district']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { 
			array_push($errors, "Username is required"); 
		}
		if (empty($email)) { 
			array_push($errors, "Email is required"); 
		}
		if (empty($usertype)) { 
			array_push($errors, "user type is required"); 
		}
		if (empty($district)) { 
			array_push($errors, "district is required"); 
		}
		if (empty($password_1)) { 
			array_push($errors, "Password is required"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form 
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database

			if (isset($_POST['user_type'])) {
				$user_type = e($_POST['user_type']);
				$query = "INSERT INTO users (username, email, user_type, district, password) 
						  VALUES('$username', '$email', '$user_type', '$district', '$password')";
				mysqli_query($db, $query);
				$_SESSION['success']  = "New user successfully created!!";
				echo(" rehdoicoijs success");
				header('location: index.php');
			}else{
				$query = "INSERT INTO users (username, email, user_type, district, password) 
						  VALUES('$username', '$email', 'user', '$district','$password')";
				mysqli_query($db, $query);

				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($db);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "You are now logged in";
				echo '<script>alert("information inserted successfully")</script>';
				header('location: index.php');				
			}

		}

	}

	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	// LOGIN USER
	function login(){
		global $db, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['user_type'] == 'admin' && $logged_in_user['status'] == '1') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['id'] = $logged_in_user;
					$_SESSION['success'];
					header('location: admin/index.php');		  
				}
				elseif($logged_in_user['status'] == '0'){
					array_push($errors, "your account is deactivated contact admin!");
				}
				else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success'];

					header('location: user/userindex.php');
				}
			}
			else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}
	function isUser()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'user' ) {
			return true;
		}else{
			return false;
		}
	}
	// escape string
	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

?>