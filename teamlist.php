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
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="js/jquery-3.7.1.js"></script>
	<title>Team</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="nav-container">
		<div class="nav">
			<a href="adminpage.php" class="back-button"></a>
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
	<h1>Kelola Team</h1>

	<form method="GET" action="" class="form-large">
		<label>Masukan Nama Team :</label>
		<input type="text" name="cari" value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
		<input type="submit" value="Search">

		<?php
		if (isset($_GET['hapus'])) {
			if ($_GET['hapus']) {
				echo "<p>Data berhasil dihapus</p>";
			} else {
				echo "<p>Data gagal dihapus</p>";
			}
		}

		if (isset($_GET['hasil'])) {
			if ($_GET['hasil']) {
				echo "<p>Data berhasil ditambahkan</p>";
			} else {
				echo "<p>Data gagal ditambahkan</p>";
			}
		}

		if (isset($_GET['edit'])) {
			if ($_GET['edit']) {
				echo "<p>Data berhasil diubah</p>";
			} else {
				echo "<p>Data gagal diubah</p>";
			}
		}

		require_once("class/team.php");

		$team = new Team();

		$limit = 5;
		$no_halaman = (isset($_GET['page'])) ? $_GET['page'] : 1;
		if (!is_numeric($no_halaman)) {
			$no_halaman = 1;
		}

		$offset = ($no_halaman * $limit) - $limit;

		$cari = isset($_GET['cari']) ? $_GET['cari'] : "";

		echo "<p>Anda mencari: " . htmlspecialchars($cari) . "</p>";

		$res = $team->getTeam($cari, $offset, $limit);

		// Membuat header table
		echo "<div class='table-wrapper'>
				 <table border='1'>
					 <tr>
						 <th>Logo</th>
						 <th>Name</th>
						 <th>Game</th>
						 <th>Members</th>
						 <th colspan='2'>Aksi</th>
						 <th colspan='2'>Detail</th>
					 </tr>";

		while ($row = $res->fetch_assoc()) {
			require_once("class/teamevent.php");
			$teamevent = new TeamEvent();
			$teamevent_check = $teamevent->getEventByTeam($row['idteam']);

			require_once("class/achievement.php");
			$achievement = new Achievement();
			$achievement_check = $achievement->getAchievementByTeam($row['idteam']);

			require_once("class/joinproposal.php");
			$joinproposal = new JoinProposal();
			$jp_check = $joinproposal->getJoinProposalByTeam($row['idteam']);

			echo "<tr>";
			echo "<td><img src='img/" . $row['idteam'] . ".jpg' style='width: 50px; height: 50px; object-fit: cover;'></td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['game_name'] . "</td>";

			$mem = $team->getTeamMembers($row['idteam']);
			echo "<td>";
			while ($members = $mem->fetch_assoc()) {
				echo "- " . $members['fullname'] . "<br>";
			}
			echo "</td>";

			echo "<td><a href='#' onclick='konfirmasiHapus(" . $row['idteam'] . ")'>Hapus</a></td>";
			echo "<td><a href='editteam.php?idupdate=" . $row['idteam'] . "'>Edit</a></td>";
			echo "<td><a href='teamachievementlist.php?id=" . $row['idteam'] . "'>View Achievement</a></td>";
			echo "<td><a href='teameventlist.php?id=" . $row['idteam'] . "'>View Event</a></td>";
			echo "</tr>";
		}

		echo "</table>
		 </div>";

		$res2 = $team->getTeam($cari);
		$totaldata = $res2->num_rows;

		$max_hal = ceil($totaldata / $limit);

		include "paging.php";
		echo generate_page($cari, $totaldata, $limit, $no_halaman);

		// Proses delete data
		if (isset($_GET['idhapus'])) {
			$idhapus = $_GET['idhapus'];
			$jumlah_yang_dieksekusi = $team->deleteTeam($idhapus);
			$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

			header("location: ?hapus=" . $hasil);
		}
		?>
		<p><a href="insertteam.php">Insert team >></a></p>
		<p><a href="adminpage.php">
				<< Back</a>
		</p>
	</form>


	<script>
		function konfirmasiHapus(idteam) {
			var confirmation = confirm("Anda yakin ingin menghapus? Semua data terkait akan dihapus");
			if (confirmation) {
				window.location.href = "?idhapus=" + idteam;
			}
		}
	</script>
		<script src="script.js"></script>
</body>

</html>