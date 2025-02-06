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
	<title>Event Details</title>
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
	<h1>VIEW EVENT</h1>
	<form>

		<?php
		if (isset($_GET['hasil'])) {
			if ($_GET['hasil']) {
				echo "<p>Data event berhasil disimpan</p>";
			} else {
				echo "<p>Data event gagal disimpan</p>";
			}
		}

		if (isset($_GET['hapus'])) {
			if ($_GET['hapus']) {
				echo "<p>Data berhasil dihapus</p>";
			} else {
				echo "<p>Data gagal dihapus</p>";
			}
		}

		require_once("class/teamevent.php");
		$idteam = isset($_GET['id']) ? $_GET['id'] : 1;
		$teamevent = new TeamEvent();
		$teamname = $teamevent->getNameByTeam($idteam);
		$rowtname = $teamname->fetch_assoc();

		echo "<table border = '1'>
				<tr>
					<th colspan='3'>" . $rowtname['tname'] . "</th>
				<tr>
				<tr>
					<th>Name</th>
					<th>Date</th>
					<th colspan = '2'>Aksi</th>
				</tr>";

		$limit = 5;
		$no_halaman = isset($_GET['page']) ? $_GET['page'] : 1;
		if (!is_numeric($no_halaman)) {
			$no_halaman = 1;
		}
		$offset = ($no_halaman * $limit) - $limit;

		$teamevent = new TeamEvent();
		$res = $teamevent->getEventByTeam($idteam, $offset, $limit);

		// Menampilkan data event
		while ($row = $res->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td><a href='?idhapus=" . $row['idevent'] . "&idteam=" . $idteam . "'>Hapus</a></td>";
			echo "</tr>";
		}
		echo "</table>";

		$res2 = $teamevent->getEventByTeam($idteam);
		$total_data = $res2->num_rows;

		include "paging.php";
		echo generate_page_mn($total_data, $limit, $no_halaman, $idteam);

		//proses delete data
		if (isset($_GET['idhapus'])) {
			extract($_GET);
			require_once("class/teamevent.php");

			$teamevent = new TeamEvent();
			$jumlah_yang_dieksekusi = $teamevent->deleteTeamEvent($idteam, $idhapus);
			$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

			header("Location: ?id=$idteam&hapus=" . $hasil);
		}
		?>

		<p><a href="insertteamevent.php?idteam=<?php echo intval($idteam); ?>">Insert Data >></a></p>
		<p><a href="teamlist.php"><< Back</a></p>
	</form>

</body>

</html>