<?php
	session_start();
	if (isset($_SESSION['username'])) {
		include("class/member.php");
		$member = new Member();
		$role = $member->getMember($_SESSION['username']);

		if ($role['profile'] == 'admin') {
			header("location: adminpage.php");
		} else {
			header("location: userpage.php?id=" . $role['idmember']);
		}
	}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
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
				?>
				<!-- <li><a href="login.php">Login</a></li> -->
				<li><a href="register.php">Register</a></li>
			</ul>
		</div>
	</div>
	<form method="post" action="proseslogin.php" class="form-small">
		<h1>LOGIN</h1>
		<p>
			<label>Username</label>
			<input type="text" name="username" required>
		</p>
		<p>
			<label>Password</label>
			<input type="password" name="password" required>
		</p>
		<button type="submit">Login</button>

		<?php
		if (isset($_GET['error']) && $_GET['error'] == 1) {
			echo "<p style='color:red';>Login Gagal</p>";
		}
		?>

		<p>
			Belum punya akun? <a href="register.php">Register</a>
		</p>
	</form>
	<script src="script.js"></script>
</body>
</html>