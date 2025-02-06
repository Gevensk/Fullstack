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
	<script type="text/javascript" src="js/jquery-3.7.1.js"></script>
	<title>Insert Team Event</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="body-style">
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
	<h1>Insert Team Event</h1>
	<form method="post" action="" enctype="multipart/form-data" class="form-small">
		<p>
			<label>Event</label>
			<select id="event" name="event">
				<?php
					require_once("class/event.php");
					require_once("class/teamevent.php");

					$teamevent=new TeamEvent();
					$idteam = isset($_GET['idteam'])? $_GET['idteam'] : null;

					$event = new Event();
					$res = $teamevent->getExistEvent($idteam);

					while ($row = $res->fetch_assoc()) {
						echo "<option value='".$row['idevent']."'>".$row['name']."</option>";
					}
				?>
			</select>
			<button type="button" id="tambah_event">Tambah Event</button>
			<div>
				<table id="daftar_team" border="1">
					<tr><th>Event</th><th>Aksi</th></tr>
				</table>
			</div>
		</p>
		<button type="submit" name="submit" value="simpan">Simpan</button>
	</form>

	<script type="text/javascript">
		$('body').on('click', '#tambah_event', function(){
			var event = $("#event option:selected").text();
			var idEvent = $('#event').val();
			
			var tambahan = "<tr>";
			tambahan += "<td>" + event + "<input type='hidden' name='event[]' value='" + idEvent + "'</td>";
			tambahan += "<td><button type='button' class='hapus_event'>Hapus</button></td>";
			tambahan += "</tr>";
			$('#daftar_team').append(tambahan);
		});

		$('body').on('click', '.hapus_event', function(){
			$(this).parent().parent().remove();
		});
	</script>

	<?php
		if (isset($_POST['submit'])) {
		    $team = isset($_GET['idteam']) ? $_GET['idteam'] : null;

		    if ($team) {
		        require_once("class/teamevent.php");
		        $arr_event = isset($_POST['event']) ? $_POST['event'] : array();

		        $teamevent = new TeamEvent();

		        foreach ($arr_event as $key => $idevent) {
		            $jumlah_yang_dieksekusi = $teamevent->insertTeamEvent($idevent, $team);
		        }

		        $hasil = $jumlah_yang_dieksekusi ? 1 : 0;
		        header("Location: teameventlist.php?id=".$team."&hasil=".$hasil);
		    } else {
		        echo "<p>Error: Team ID tidak ditemukan.</p>";
		    }
		}

	?>
</body>
</html>