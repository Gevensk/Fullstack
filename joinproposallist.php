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
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="js/jquery-3.7.1.js"></script>
	<title>Join Proposal List</title>
</head>

<body>
	<div class="nav-container">
		<div class="nav">
			<a href="userpage.php" class="back-button"></a>
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
	<form>
		<?php
		if (isset($_GET['hasil'])) {
			if ($_GET['hasil']) {
				echo "<p>Pengajuan Berhasil</p>";
			} else {
				echo "<p>Pengajuan Gagal. Silahkan coba lagi</p>";
			}
		}
		if (isset($_GET['hapus'])) {
			if ($_GET['hapus']) {
				echo "<p>Pengajuan Berhasil Dibatalkan</p>";
			} else {
				echo "<p>Pembatalan Pengajuan Gagal. Silahkan coba lagi</p>";
			}
		}

		$idmember = isset($_GET['idmember']) ? $_GET['idmember'] : 0;
		echo "<input type='hidden' name='idmember' id='idmember' value='$idmember'>";

		require_once("class/joinproposal.php");
		$join_proposal = new JoinProposal();
		$res = $join_proposal->getJoinProposalByMember($idmember);

		echo "<table border = '1'>
					<tr>
						<th>Team Name</th>
						<th>Description</th>
						<th>Status</th>
						<th colspan>Aksi</th>
					</tr>";

		while ($proposal = $res->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $proposal['team_name'] . "</td>";
			echo "<td>" . $proposal['description'] . "</td>";
			echo "<td>" . $proposal['status'] . "</td>";

			if ($proposal['status'] == "waiting") {
				echo "<td><button type='button' class='btnbatal' value='" . $proposal['idjoin_proposal'] . "'>Batal</td>";
			} else {
				echo "<td align = 'center'>-</td>";
			}
			echo "</tr>";
		}

		echo "</table>";
		?>
		<p><a href="addjoinproposal.php?idmember=<?php echo ($idmember) ?>">Bergabung Dalam Team</a></p>
		<p><a href="userpage.php">Back</a></p>
	</form>
	<script type="text/javascript">
		$('body').on("click", ".btnbatal", function() {
			var idmember = $("#idmember").val();
			var idjp = $(this).val();

			$.post("ajax/cancelproposalajax.php", {
					idjp: idjp
				}).done(function(response) {
					console.log("Response: ", response);
					if (response.trim() === "berhasil") {
						window.location.href = "joinproposallist.php?idmember=" + idmember + "&hapus=1";
					} else {
						window.location.href = "joinproposallist.php?idmember=" + idmember + "&hapus=0";
					}
				})
				.fail(function(xhr, status, error) {
					console.log("Error: ", error);
					console.log("Status: ", status);
					console.log("Response Text: ", xhr.responseText);
					window.location.href = "joinproposallist.php?idmember=" + idmember + "&hapus=0";
				});
		});
	</script>
	<script src="script.js"></script>
</body>

</html>