<?php
	session_start();
	if (isset($_SESSION['username'])) {
		include("class/member.php");
		$member = new Member();
		$role = $member->getMember($_SESSION['username']);
	}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Home Page</title>
</head>

<body>
	<!-- nav -->
	<div class="nav-container">
		<div class="nav">
			<a href="#" class="logo">
				<img src="img/ggj.png" alt="logo">
			</a>
			<div class="hamburger-button">
				<button>
					<span class="middle-line"></span>
				</button>
			</div>
			<ul id="menu-list" class="menu hidden">
				<li><a href="index.php">Home</a></li>
				<!-- <li><a href='gamepage.php'>Game</a></li> -->

				<?php
				if (isset($_SESSION['username'])) {
					if ($role['profile'] == "user") {
						echo "<li><a href='userpage.php'>User Page</a></li>";
					} else {

						echo "<li><a href='adminpage.php'>Admin Page</a></li>";
					}
				}
				if (isset($_SESSION['username'])) {

					echo "<li><a href='proseslogout.php'>Logout</a></li>";
				} else {
					echo "<li><a href='login.php'>Login</a></li>";
				}
				if (!isset($_SESSION['username'])) {

					echo "<li><a href='register.php'>Register</a></li>";
				}
				?>
			</ul>
		</div>
	</div>

	<div class="main" id="main">
		<div class="isi">
			<h3>Welcome to Gudang Garam Jaya E-Sport </h3>
			<p>Be A Champion</p>
		</div>

	</div>


	<?php
		require_once("class/frontend.php");
		$frontend = new Frontend();
		$res = $frontend->getTeam();

		$arr_team = [];

		while ($row = $res->fetch_assoc()) {
			$team_name = $row['name'];
			if (!isset($arr_team[$team_name])) {
				$arr_team[$team_name] = [];
			}
			$arr_team[$team_name][] = $row;
		}

		$res = $frontend->getGame();

        $arr_game=[];

        while($row = $res->fetch_assoc()){
            $game_name = $row['name'];
            if(!isset($arr_game[$game_name])){
                $arr_game[$game_name] = [];
            }
            $arr_game[$game_name][]=$row;
        }
	?>
	<!-- content -->
	<div class="content">
		<p>Team</p>
		<div class="slider-container">
			<!-- Tombol kiri -->
			<button class="slider-btn left" id="leftBtn">&lt;</button>

			<div class="slider-wrapper">
				<div class="wrapper" id="cardWrapper">
					<?php
					foreach ($arr_team as $team_name => $teams) {
						foreach ($teams as $team) {
							echo "<div class='card-home'>
                            <img src='img/" . $team['idteam'] . ".jpg' alt='Card Image'>
                            <div class='info'>
                                <p>" . $team['name'] . "</p>
                                <h4>" . $team['game_name'] . "</h4>
                                <a href='teamdetail.php?idteam=" . $team['idteam'] . "' class='btn'>Read More</a>
                            </div>
                        </div>";
						}
					}
					?>
				</div>
			</div>

			<!-- Tombol kanan -->
			<button class="slider-btn right" id="rightBtn">&gt;</button>
		</div>
	</div>

	<div class="content">
		<p>Game</p>

		<div class="slider-container">
			<!-- Tombol kiri -->
			<button class="slider-btn left" id="leftBtnGame">&lt;</button>

                <div class="slider-wrapper">
                    <div class="wrapper" id="cardWrapperGame">
	                    <?php
	                        foreach($arr_game as $game_name => $games){
	                            foreach($games as $game){
	                                echo"<div class='card-home'>
	                                        <img src='img/game/".$game['idgame'].".jpg' alt='Card Image'>
	                                        <div class='info'>
												<h4>".$game['name']."</h4>
	                                            <a href='gamedetail.php?idgame=".$game['idgame']."' class='btn'>Read More</a>
	                                        </div>
	                                    </div>";
	                            }
	                        }
	                    ?>
                    </div>
                </div>
                <button class="slider-btn right" id="rightBtnGame">&gt;</button>
        </div>
            
	</div>


	<div class="footer">
		<p>�� 2024 Gudang Garam Jaya Team. All Rights Reserved.</p>
		<p>Vilen Alycia Holly(160422173) | Grace Venska Sutanto(160422093) | Marshanda Phanliana (160422096)</p>
	</div>

	<script src="script.js"></script>
</body>

</html>