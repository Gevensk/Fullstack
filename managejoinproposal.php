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
	<title>Kelola Join Proposal</title>
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

	<h1>Join Proposal</h1>
	<form method="GET" action="">
		<label>Masukan Nama Member:</label>
		<input type="text" name="cari" value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
		<input type="submit" value="Search">

		<?php
		if (isset($_GET['hasil'])) {
			if ($_GET['hasil']) {
				echo "<p>Pengajuan Berhasil Disetujui</p>";
			} else {
				echo "<p>Pengajuan Gagal Disetujui</p>";
			}
		}

		if (isset($_GET['tolak'])) {
			if ($_GET['tolak']) {
				echo "<p>Pengajuan Berhasil Ditolak</p>";
			} else {
				echo "<p>Pengajuan Gagal Ditolak</p>";
			}
		}

		require_once("class/joinproposal.php");

		$limit = 5;
		$no_halaman = isset($_GET['page']) ? $_GET['page'] : 1;
		if (!is_numeric($no_halaman)) {
			$no_halaman = 1;
		}
		$offset = ($no_halaman * $limit) - $limit;
		$cari = isset($_GET['cari']) ? $_GET['cari'] : "";

		echo "<p>Anda mencari: " . htmlspecialchars($cari) . "</p>";

		$joinproposal = new JoinProposal();
		$res = $joinproposal->getJoinProposal($cari, $offset, $limit);

		echo "<div class='table-wrapper'>
			<table border = '1'>
					<tr>
						<th>Team</th>
						<th>Name</th>
						<th>Description</th>
						<th>Status</th>
						<th colspan = '2'>Aksi</th>
					</tr>";

		while ($row = $res->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['team_name'] . "</td>";
			echo "<td>" . $row['fname'] . "</td>";
			echo "<td>" . $row['description'] . "</td>";
			echo "<td>" . $row['status'] . "</td>";

			if ($row['status'] != 'waiting') {
				echo "<td align = 'center'>-</td>";
				echo "<td align = 'center'>-</td>";
			} else {
				echo "<td><a href = '?aksi=acc&idmember=" . $row['idmember'] . "&idteam=" . $row['idteam'] . "'>Setuju</a></td>";
				echo "<td><a href = '?aksi=decline&idmember=" . $row['idmember'] . "&idteam=" . $row['idteam'] . "'>Tolak</a></td>";
			}

			echo "</tr>";
		}

		echo "</table>
			</div>";

		$res2 = $joinproposal->getJoinProposal($cari);
		$total_data = $res2->num_rows;

		include "paging.php";
		echo generate_page($cari, $total_data, $limit, $no_halaman);

		if (isset($_GET['aksi'])) {
			$idmember = isset($_GET['idmember']) ? $_GET['idmember'] : 0;
			$idteam = isset($_GET['idteam']) ? $_GET['idteam'] : 0;

			if ($_GET['aksi'] == 'acc') {
				$jumlah_yang_dieksekusi = $joinproposal->accProposal($idmember, $idteam);
				$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

				header("location: ?hasil=" . $hasil);
			} else {
				$jumlah_yang_dieksekusi = $joinproposal->declineProposal($idmember, $idteam);
				$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

				header("location: ?tolak=" . $hasil);
			}
		}
		?>
		<p><a href="adminpage.php">
				<< Back</a>
		</p>
	</form>
	<script src="script.js"></script>
</body>
</html>