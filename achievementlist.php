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
    <title>Achievements</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="js/jquery-3.7.1.js"></script>
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
				<!-- <li><a href="login.php">Login</a></li> -->
				<!-- <li><a href="register.php">Register</a></li> -->
			</ul>
		</div>
	</div>

    <h1>Kelola Achievement</h1>
    <form method="GET" action="">
        <label>Masukan Nama Achievement :</label>
        <input type="text" name="cari" value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
        <input type="submit" value="Search">

        <?php
        require_once("class/achievement.php");

        if (isset($_GET['hasil'])) {
            if ($_GET['hasil']) {
                echo "<p>Data achievement berhasil disimpan</p>";
            } else {
                echo "<p>Data achievement gagal disimpan</p>";
            }
        }

        if (isset($_GET['hapus'])) {
            if ($_GET['hapus']) {
                echo "<p>Data berhasil dihapus</p>";
            } else {
                echo "<p>Data gagal dihapus</p>";
            }
        }

        if (isset($_GET['edit'])) {
            if ($_GET['edit']) {
                echo "<p>Data berhasil diubah</p>";
            } else {
                echo "<p>Data gagal diubah</p>";
            }
        }

        $limit = 5;
        $no_halaman = isset($_GET['page']) ? $_GET['page'] : 1;
        if (!is_numeric($no_halaman)) {
            $no_halaman = 1;
        }
        $offset = ($no_halaman * $limit) - $limit;
        $cari = isset($_GET['cari']) ? $_GET['cari'] : "";

        echo "<p>Anda mencari: " . htmlspecialchars($cari) . "</p>";

        $achievement = new Achievement();
        $res = $achievement->getAchievement($cari, $offset, $limit);

        //header table
        echo "<div class='table-wrapper'>
        <table border = '1'>
                <tr>
                    <th>Team</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th colspan = '2'>Aksi</th>
                </tr>
                ";

        while ($row = $res->fetch_assoc()) {
            $team = $achievement->getTeamNameById($row['idteam']);

            echo "<tr>";
            echo "<td>" . $team['team_name'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td><a href = editachievement.php?idupdate=" . $row['idachievement'] . ">Edit</a></td>";
            echo "<td><button type='button' class='btnHapus' value='" . $row['idachievement'] . "'>Hapus</td>";
            echo "</tr>";
        }
        echo "</table>
        </div>";


        $res2 = $achievement->getAchievement($cari);
        $total_data = $res2->num_rows;

        include "paging.php";
        echo generate_page($cari, $total_data, $limit, $no_halaman);
        ?>
        <p><a href="insertachievement.php">Insert Achievement >></a></p>
        <p><a href="adminpage.php">
                << Back</a>
        </p>
    </form>

    <script type="text/javascript">
        $('body').on("click", ".btnHapus", function() {
            var idachievement = $(this).val();
            $.post("ajax/deleteachievementajax.php", {
                    idachievement: idachievement
                }).done(function(response) {
                    console.log("Response: ", response);
                    if (response.trim() === "berhasil") {
                        window.location.href = "achievementlist.php?hapus=1";
                    } else {
                        window.location.href = "achievementlist.php?hapus=0";
                    }
                })
                .fail(function(xhr, status, error) {
                    console.log("Error: ", error);
                    console.log("Status: ", status);
                    console.log("Response Text: ", xhr.responseText);
                    alert("Terjadi kesalahan saat menghapus data.");
                });
        });
    </script>
    <script src="script.js"></script>
</body>
</html>