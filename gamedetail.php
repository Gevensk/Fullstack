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
	<title>Team Detail</title>
</head>

<body>
<div class="nav-container">
		<div class="nav">
			<a href="index.php" class="back-button"></a>
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
					} 
					
					if (isset($_SESSION['username'])) {

						echo "<li><a href='proseslogout.php'>Logout</a></li>";
					} else {
						echo "<li><a href='login.php'>Login</a></li>";
						echo "<li><a href='register.php'>Register</a></li>";
					}
				?>
			</ul>
		</div>
	</div>
	<h1>Game Detail</h1>
	<form>


		<?php
		$idgame = isset($_GET['idgame']) ? $_GET['idgame'] : 0;

		require_once("class/frontend.php");
		$frontend = new Frontend();
		$res = $frontend->getGameDetail($idgame);

		require_once("class/game.php");
		$game = new Game();
		$resgame = $game->getGameById($idgame);

		$arr_event = [];

		while ($row = $res->fetch_assoc()) {
			$team_name = $row['team_name'];
			if (!isset($arr_event[$team_name])) {
				$arr_event[$team_name] = [];
			}
			$arr_event[$team_name][] = $row;
		}

		echo "<table border = '1'>
				<tr>
					<th colspan = '2'>" . $resgame['name'] . "</th>
				</tr>
				<tr>
					<th>Team</th>
					<th>Event</th>
				</tr>";


		foreach ($arr_event as $team_name => $events) {
			$rowspan = count($events);
			$first_row = true;

			foreach ($events as $event) {
				echo "<tr>";
				if ($first_row) {
					echo "<td rowspan = '$rowspan'>" . $team_name . "</td>";
					$first_row = false;
				}
				echo "<td>" . $event['name'] . "</td>";
				echo "</tr>";
			}
		}

		echo "</table>";
		?>
	</form>
</body>
<script src="script.js"></script>
</html>