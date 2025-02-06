<?php
	require_once("../class/achievement.php");
	$team = isset($_POST['team']) ? $_POST['team'] : 1;
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$date = isset($_POST['date']) ? $_POST['date'] : "";
	$description = isset($_POST['description']) ? $_POST['description'] : "";
	$idachievement = isset($_POST['idachievement']) ? $_POST['idachievement'] : 1;

	$achievement = new Achievement();
	$jumlah_yang_dieksekusi = $achievement->updateAchievement($team, $name, $date, $description, $idachievement);
	$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

	if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>