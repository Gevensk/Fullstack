<?php
	require_once("../class/team.php");
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$game = isset($_POST['game']) ? $_POST['game'] : 1;
	$foto = $_FILES['foto'];

	if ($foto['error'] === UPLOAD_ERR_OK) {
        $team = new Team();
        $last_id = $team->insertTeam($game, $name);
        $hasil = $last_id ? 1 : 0;
        if (move_uploaded_file($foto['tmp_name'], "../img/".$last_id.".jpg")) {
            echo "Data Team Berhasil Ditambahkan";
        } 
        else {
            echo "Gagal menyimpan gambar.";
        }
    } 
    else {
        echo "Data Team Gagal Ditambahkan";
   	}
?>