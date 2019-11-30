<?php
session_start();
include_once("./models/header.model.php");

function show_on_screen() {
	if(isset($_GET['user'])){
		$_SESSION['session_cpage'] = 'user';
		include_once("./pages/user/user.php");
	} else {
		$_SESSION['session_cpage'] = 'home';
		include_once("./pages/home/home.php");
	}
}

if(isset($_GET['logout'])){ // logout
	$_SESSION = array();
	session_destroy();
	header("Location:index.php");
} else if(isset($_POST['login'])) { // login by user and pass
	$result = Database::execute_query_with_prepared_statement(
		"select * from users where username = lower(?) and password = PASSWORD(?);",
		array($_POST['username'], md5($_POST['password'])));
	
	if($result->num_rows === 0) { // error password or username
		$_SESSION['session_connected'] = 2;
		include_once("./pages/error.html");
	} else if($row = $result->fetch_assoc()) {
		// setcookie(name, value, expire, path, domain, secure, httponly);
		$_SESSION['session_id_user'] = $row['id_user'];
		$_SESSION['session_username'] = $row['username'];
		$_SESSION['session_role'] = $row['role'];	
		$_SESSION['session_active'] = $row['active'];
		$_SESSION['session_connected'] = 1; // connexion OK
		$_SESSION['session_expire'] = time() + $session_duration;
		show_on_screen();
	}
} else if(isset($_SESSION['session_username']) && $_SESSION['session_expire'] > time()){
	show_on_screen();
} else{
	session_destroy();
	include_once('./pages/login.php');
}
?>
