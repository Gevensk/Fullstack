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

		if($role['profile'] != "user"){
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
	<title>View Teams</title>
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

	<h1>My Teams</h1>
	<form>
		<label>Masukan Nama Team :</label>
		<input type="text" name="cari" value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
		<input type="submit" value="Search">

		<?php
			$idmember = isset($_GET['idmember']) ? $_GET['idmember'] : 0;

			require_once("class/team.php");
			$team = new Team();

			$limit = 1;
			$no_halaman = isset($_GET['page']) ? $_GET['page'] : 1;
			if (!is_numeric($no_halaman)) {
				$no_halaman = 1;
			}
			$offset = ($no_halaman * $limit) - $limit;
			$cari = isset($_GET['cari']) ? $_GET['cari'] : "";

			$res = $team->getTeamByMember($idmember, $cari, $offset, $limit);

			echo "<table border = '1'>
					<th>Team</th>
					<th>Members</th>
					<th colspan='2'>Aksi</th>";

			while ($row = $res->fetch_assoc()){
				echo "<tr>";
					echo "<input type='hidden' id='team' value='".$row['idteam']."'></input>";
					echo "<td>".$row['name']."</td>";

					$mem = $team->getTeamMembers($row['idteam']);
					echo "<td>";
					while ($members = $mem->fetch_assoc()) {
						echo "- " . $members['fullname'] . "<br>";
					}
					echo "</td>";

					echo "<td><button class='event' type='button'>View Events</button></td>";

					echo "<td><button class='achievement' type='button'>View Achievements</button></td>";
				echo "</tr>";
			}

			echo "</table>";

			$res2 = $team->getTeamByMember($idmember, $cari);
			$total_data = $res2->num_rows;

			include "paging.php";
			echo generate_page_viewteam($idmember, $cari, $total_data, $limit, $no_halaman);

		?>
		<p id='hasil'>-</p>
		<p><a href = "userpage.php">Back</a></p>
	</form>
	
	<script type="text/javascript">
		$('body').on("click", ".event", function(){
			var idteam = $(this).closest('tr').find('#team').val(); //mencari value team dari tr terdekat dengan yang di klik
			$.post("ajax/vieweventajax.php", {idteam:idteam}).done(function(data){
				$("#hasil").html(data);
			});
		});
		$('body').on("click", ".achievement", function(){
			var idteam = $(this).closest('tr').find('#team').val(); //mencari value team dari tr terdekat dengan yang di klik
			$.post("ajax/viewachievementajax.php", {idteam:idteam}).done(function(data){
				$("#hasil").html(data);
			});
		});
	</script>

<script src="script.js"></script>
</body>
</html>