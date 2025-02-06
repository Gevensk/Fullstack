<?php
	session_start();
	if (isset($_SESSION['username'])) {
		include("class/member.php");
		$member = new Member();
		$role = $member->getMember($_SESSION['username']);
	}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Team Members</title>
</head>

<body class="home">
	<?php
	$idteam = isset($_GET['idteam']) ? $_GET['idteam'] : 0;

	require_once("class/team.php");
	$team = new Team();
	$resmember = $team->getTeamMembers($idteam);
	?>
	<div class="nav-container">
		<div class="nav">
			<a href="teamdetail.php?idteam=<?php echo ($idteam); ?>" class="back-button"></a>
			<div class="hamburger-button">
				<button>
					<span class="middle-line"></span>
				</button>
			</div>
			<ul id="menu-list" class="menu hidden">
				<li><a href="index.php">Home</a></li>
				<li><a href="scheduledetail.php?idteam=<?php echo ($idteam); ?>">View Schedules</a></li>
				<li><a href="teammembers.php?idteam=<?php echo ($idteam); ?>">View Members</a></li>
				<?php
					if (isset($_SESSION['username'])) {
						if ($role['profile'] == "user") {
							echo "<li><a href='userpage.php'>User Page</a></li>";
						} else {

							echo "<li><a href='adminpage.php'>Admin Page</a></li>";
						}
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
	<h1>Team Members</h1>
	<?php


	echo "<table border = '1'>
				<th>Fullname</th>
				<th>Description</th>";

	while ($rowmember = $resmember->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $rowmember['fullname'] . "</td>";
		echo "<td>" . $rowmember['description'] . "</td>";
		echo "</tr>";
	}

	echo "</table>";
	?>
	<script src="script.js"></script>
</body>

</html>