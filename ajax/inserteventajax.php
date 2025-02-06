<?php
	require_once("../class/event.php");
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$date = isset($_POST['date']) ? $_POST['date'] : "";
	$description = isset($_POST['description']) ? $_POST['description'] : "";

	$event = new Event();
	$last_id = $event->insertEvent($name, $date, $description);
	$hasil = $last_id ? 1 : 0;

	if($hasil == 1){
		echo "berhasil";
	}
	else{
		echo "gagal";
	}
?>