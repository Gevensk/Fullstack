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
	<script type="text/javascript" src="js/jquery-3.7.1.js"></script>
	<title>Join Proposal</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="js/jquery-3.7.1.js"></script>
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
				<!-- <li><a href="login.php">Login</a></li> -->
				<!-- <li><a href="register.php">Register</a></li> -->
			</ul>
		</div>
	</div>

	<form method="post" id="form" enctype="multipart/form-data" class="form-small">
		<h1>Bergabung Dalam Tim</h1>

		<?php $idmember = isset($_GET['idmember']) ? $_GET['idmember'] : 1; ?>
		<input type="hidden" name="idmember" id="idmember" value="<?php echo ($idmember) ?>">
		<p>
			<label>Team</label>
			<select id="team" name="team">
				<?php
					require_once("class/team.php");

					$team = new Team();
		            $res = $team->getExistTeam($idmember);

		            while ($row = $res->fetch_assoc()) {
		                echo "<option value='" . $row['idteam'] . "'>" . $row['name'] . "</option>";
		            }
				?>
			</select>
		</p>
		<p>
			<label>Description</label>
			<textarea id="description" name="description" required></textarea>
		</p>
		<button type="button" name="submit" id="btnsubmit" value="simpan">Simpan</button>

		<p>
			 <a href="userpage.php">Back</a>
		</p>
	</form>
	<script type="text/javascript">
		$('body').on('click', '#btnsubmit', function(){
			var formData = new FormData($("#form")[0]);
			var idmember = $("#idmember").val();

			$.ajax({
				url: 'ajax/addjoinproposalajax.php',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response){
					console.log("Response: ", response);
            		if (response.trim() === "berhasil") {
                		window.location.href = "joinproposallist.php?idmember=" + idmember + "&hasil=1";
            		}
            		else{
            			window.location.href = "joinproposallist.php?idmember=" + idmember + "&hasil=0";
            		}
				},
				error: function(xhr, status, error) {
                    console.log("Error: " + error);
                    window.location.href = "joinproposallist.php?idmember=" + idmember + "&hasil=0";
                }
			});
		});
	</script>
	<script src="script.js"></script>
</body>

</html>