<?php
	$idgame = isset($_POST['idgame']) ? $_POST['idgame'] : 1;

	require_once("../class/game.php");

	$game = new Game();
	$jumlah_yang_dieksekusi = $game->deleteGame($idgame);
	$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

	if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>