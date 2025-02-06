<?php
	session_start();
	require_once("class/member.php");

	$member = new member();
	$username = $_POST['username'];
	$password = $_POST['password'];

	if($member->doLogin($username, $password)){
		$mymember = $member->getMember($username);

		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;

		header("location: index.php");
	}
	else{
		header("location: login.php?error=1");
	}
?>