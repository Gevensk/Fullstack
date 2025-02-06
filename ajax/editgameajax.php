<?php
	require_once("../class/game.php");
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$description = isset($_POST['description']) ? $_POST['description'] : "";
	$idgame = isset($_POST['idgame']) ? $_POST['idgame'] : 1;

	$game = new Game();
	$jumlah_yang_dieksekusi = $game->updateGame($name, $description, $idgame);
	$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

	if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>