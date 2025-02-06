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
	<title>Register</title>
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
	<form method="post" action="" enctype="multipart/form-data" class="form-small">
		<h1>REGISTER</h1>
		<p>
			<label>First Name</label>
			<input type="text" name="firstname" required>
		</p>
		<p>
			<label>Last Name</label>
			<input type="text" name="lastname" required>
		</p>
		<p>
			<label>Username</label>
			<input type="text" name="username" required>
		</p>
		<p>
			<label>Password</label>
			<input type="password" name="password" required>
		</p>

		<?php
		if (isset($_POST['submit'])) {
			require_once("class/member.php");
			extract($_POST);

			$newMember = new Member();
			$result = $newMember->register($firstname, $lastname, $username, $password);

			if (is_string($result)) {
				echo "<p style='color:red;'>$result</p>";
			} else {
				header("location: register.php?hasil=1");
				exit;
			}
		}

		if (isset($_GET['hasil']) && $_GET['hasil'] == 1) {
			echo "<p>Registrasi member berhasil. Silakan <a href='login.php'>Login</a></p>";
		}
		?>

		<button type="submit" name="submit">Register</button>

		<p>
			 <a href="login.php">Back</a>
		</p>
	</form>
	<script src="script.js"></script>
</body>
</html>