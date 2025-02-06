<?php
	require_once("../class/achievement.php");
	$team = isset($_POST['team']) ? $_POST['team'] : 1;
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$date = isset($_POST['date']) ? $_POST['date'] : "";
	$description = isset($_POST['description']) ? $_POST['description'] : "";

	$achievement = new Achievement();
	$last_id = $achievement->insertAchievement($team, $name, $date, $description);
	$hasil = $last_id ? 1 : 0;

	if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>