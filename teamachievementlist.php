<?php
	session_start();
	if (!isset($_SESSION['username'])) {
	    header("location: index.php");
	    exit();
	}
	else{
		include("class/member.php");
        $member = new Member();
        $role = $member->getMember($_SESSION['username']);

        if($role['profile'] != "admin"){
            header("location: userpage.php?id=".$role['idmember']);
        }	
    }
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Achievement Details</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="nav-container">
		<div class="nav">
			<a href="teamlist.php" class="back-button"></a>
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
	<h1>VIEW ACHIEVEMENT</h1>
	<form>
	
		<?php
		if (isset($_GET['hapus'])) {
			if ($_GET['hapus']) {
				echo "<p>Data berhasil dihapus</p>";
			} else {
				echo "<p>Data gagal dihapus</p>";
			}
		}

		if (isset($_GET['id'])) {
			if ($_GET['id']) {

				require_once("class/achievement.php");
				$idteam = $_GET['id'];

				$achievement = new Achievement();

				$total_achievements = $achievement->HitungTotalAchievement($idteam);
				$limit = 5;
				$no_halaman = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
				$offset = ($no_halaman - 1) * $limit;

				$res = $achievement->getAchievementByTeam($idteam, $offset, $limit);
				$res2 = $achievement->getNameByTeam($idteam);
				$row2 = $res2->fetch_assoc();


				echo "<table border ='1'>
				<tr>
					<th colspan='3'>" . $row2['tname'] . "</th>
				<tr>
				<tr>
					<th>Name</th>
					<th>Date</th>
					<th>Description</th>
				<tr>";

				while ($row = $res->fetch_assoc()) {
					echo "<tr>";

					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['date'] . "</td>";
					echo "<td>" . $row['description'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";

				$max_hal = ceil($total_achievements / $limit);

				include "paging.php";
				echo generate_page_mn($total_achievements, $limit, $no_halaman, $idteam);
			}
		}
		?>

		<p><a href="teamlist.php">
				<< Back</a>
		</p>
	</form>

</body>

</html>