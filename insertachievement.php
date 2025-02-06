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
	<title>Insert Achievement</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src = "js/jquery-3.7.1.js"></script>
</head>
<body>
<div class="nav-container">
		<div class="nav">
			<a href="achievementlist.php" class="back-button"></a>
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

	<form method="post" id = "form" enctype="multipart/form-data" class="form-small">
		<h1>INSERT ACHIEVEMENT</h1>
		<p>
			<label>Team</label>
			<select id="team" name="team">
				<?php
					require_once("class/team.php");

					$team = new Team();
					$res = $team->getTeam();

					while($row = $res->fetch_assoc()){
						echo "<option value='".$row['idteam']."'>".$row['name']."</option>";
					}
				?>
			</select>
		</p>
		<p>
			<label>Name</label><input type="text" name="name" id = "name" required>
		</p>
		<p>
			<label>Date</label><input type="date" name="date" id = "date" required>
		</p>
		<p>
			<label>Description</label><textarea name="description" id = "description" required></textarea>
		</p>
		<button type="button" id = "btnsubmit" name="submit" value="simpan">Simpan</button>
		<p><a href="achievementlist.php"><< Back</a></p>
	</form>
	<script type="text/javascript">
		$('body').on('click', '#btnsubmit', function(){
			var formData = new FormData($("#form")[0]);

			$.ajax({
				url: 'ajax/insertachievementajax.php',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response){
					console.log("Response: ", response);
                    if (response.trim() === "berhasil") {
                        window.location.href = "achievementlist.php?hasil=1";
                    }
                    else{
                        window.location.href = "achievementlist.php?hasil=0";
                    }
				},
				error: function(xhr, status, error) {
                    console.log("Error: " + error);
                    window.location.href = "achievementlist.php?hasil=0";
                }
			});
		});
	</script>
</body>
</html>