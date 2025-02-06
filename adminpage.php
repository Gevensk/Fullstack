<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("location: index.php");
	exit();
} else {
	include("class/member.php");
	$member = new Member();
	$role = $member->getMember($_SESSION['username']);

	if ($role['profile'] != "admin") {
		header("location: userpage.php?id=" . $role['idmember']);
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="nav-container">
		<div class="nav">
			<a href="#" class="logo">
				<img src="img/ggj.png" alt="logo">
			</a>
			<div class="hamburger-button">
				<button>
					<span class="middle-line"></span>
				</button>
			</div>
			<ul id="menu-list" class="menu hidden">
				<li><a href="index.php">Home</a></li>

				<?php
				if (isset($_SESSION['username'])) {
					if ($role['profile'] == "user") {
						echo "<li><a href='userpage.php'>User Page</a></li>";
					} else {

						echo "<li><a href='adminpage.php'>Admin Page</a></li>";
					}
				} else {
					echo "<li><a href='gamelist.php'>Game</a></li>";
					echo "<li><a href='teamlist.php'>Team</a></li>";
				}
				if (isset($_SESSION['username'])) {

					echo "<li><a href='proseslogout.php'>Logout</a></li>";
				} else {
					echo "<li><a href='login.php'>Login</a></li>";
				}
				?>
				<!-- <li><a href="login.php">Login</a></li> -->
				<!-- <li><a href="register.php">Register</a></li> -->
			</ul>
		</div>
	</div>


	<h1>Home (Admin)</h1>

	<div class="card-container">
		<div class="card">
			<a href="teamlist.php">Kelola Data Team</a>
		</div>
		<div class="card">
			<a href="gamelist.php">Kelola Data Game</a>
		</div>
		<div class="card">
			<a href="achievementlist.php">Kelola Data Achievement</a>
		</div>
		<div class="card">
			<a href="eventlist.php">Kelola Data Event</a>
		</div>
		<div class="card">
			<a href="managejoinproposal.php">Kelola Join Proposal</a>
		</div>
	</div>
	<p><b><a href="index.php">
				<< Back</a></b></p>

	<script src="script.js"></script>
</body>

</html>