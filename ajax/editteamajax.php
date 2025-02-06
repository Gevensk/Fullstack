<?php
	require_once("../class/team.php");
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$game = isset($_POST['idgame']) ? $_POST['idgame'] : 1;
	$foto = $_FILES['foto'];
	$idteam = isset($_POST['idteam']) ? $_POST['idteam'] : 1;

	if ($foto['error'] === UPLOAD_ERR_OK) {
        $team = new Team();
        $row = $team->getTeamById($idteam);
        $old_image_path = "../img/" . $idteam . ".jpg";

        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }

        $jumlah_yang_dieksekusi = $team->updateTeam($game, $name, $idteam);
        $hasil = $jumlah_yang_dieksekusi ? 1 : 0;

        if (move_uploaded_file($foto['tmp_name'], "../img/".$idteam.".jpg")) {
            echo "Data Team Berhasil Diubah";
        } else {
            echo "Gagal menyimpan gambar.";
        }
    } 
    else {
        echo "Data Team Gagal Diubah";
   	}
?>