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
	<title>Edit Team</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<?php
		require_once("class/team.php");

		if(isset($_GET['idupdate'])){
			$idteam = $_GET['idupdate'];

			$team = new Team();
			$row = $team->getTeamById($idteam);

			$idgame = $row['idgame'];
		}
	?>
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
	<h1>Edit Team</h1>
	<form method="post" id="form" enctype="multipart/form-data" class="form-small">
		<input type="hidden" name="idteam" id="idteam" value="<?php echo($idteam); ?>">
        <p>
            <label>Name</label><input type="text" name="name" value="<?php echo($row['name']); ?>" required>
        </p>
        <p>
        	<label>Game</label>
        	<select id="idgame" name="idgame">
        		<?php
        			require_once("class/game.php");

        			$game = new Game();
        			$gameres = $game->getGame();

        			while($gamerow = $gameres->fetch_assoc()){
        				$selected = $gamerow['idgame'] == $idgame ? 'selected' : '';
						echo "<option value='".$gamerow['idgame']."' ".$selected.">".$gamerow['name']."</option>";
        			}
        		?>
        	</select>
        </p>
        <p>
            <label>Picture : </label><input type="file" name="foto" id="foto" accept=".jpg" required>
        </p>
        <button type="button" name="submit" id="submit" value="simpan">Simpan</button>
		<p><a href="teamlist.php"><< Back</a></p>
    </form>
   	<script type="text/javascript">
   		$('body').on("click", "#submit", function(){
            var formData = new FormData($('#form')[0]);

            $.ajax({
                url: "ajax/editteamajax.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    window.location.href = "teamlist.php?edit=1";
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                    alert("Error: " + error);
                }
            });
        });
   	</script>
</body>
</html>