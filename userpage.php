<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("location: index.php");
	exit();
} else {
	include("class/member.php");
	$member = new Member();
	$role = $member->getMember($_SESSION['username']);

	if ($role['profile'] != "user") {
		header("location:adminpage.php");
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Page</title>
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
			</ul>
		</div>
	</div>

	<h1>Home</h1>
		<?php
		echo "<p>Welcome! " . $role['fname'] . " " . $role['lname'] . "</p>";
		?>
		<div class="card-container">
			<div class="card">
				<p><a href="viewteams.php?idmember=<?php echo ($role['idmember']); ?>">View Teams</a></p>
			</div>
			<div class="card">
				<p><a href="joinproposallist.php?idmember=<?php echo ($role['idmember']); ?>">View Join Proposal</a></p>
			</div>
		</div>
	<p><b><a href="index.php">
				<< Back</a></b></p>
	<script src="script.js"></script>
</body>

</html>