<?php
	$idachievement = isset($_POST['idachievement']) ? $_POST['idachievement'] : 1;

	require_once("../class/achievement.php");

	$achievement = new Achievement();
    $jumlah_yang_dieksekusi = $achievement->deleteAchievement($idachievement);
    $hasil = $jumlah_yang_dieksekusi ? 1 : 0;

    if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>