<?php
include_once("./classes/header.class.php");
if(isset($_GET['logout'])){
	$_SESSION = array();
	session_destroy();
	setcookie("token_sundev_vadmin", "", time()+3600, null, null, false, true);
	unset($user);
	header("Location:index.php");
} else if(isset($_POST['login'])){
	$user = new User($_POST['username'], $_POST['password']);
} else if(isset($_COOKIE['token_sundev_vadmin']) && $_COOKIE['token_sundev_vadmin']!=""){
	$user = new User($_COOKIE['token_sundev_vadmin']);
} else{
	$user = new User();
}

$screen = new Screen($user);
echo $screen;
?>
