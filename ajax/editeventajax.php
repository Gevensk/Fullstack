<?php
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$date = isset($_POST['date']) ? $_POST['date'] : "";
	$description = isset($_POST['description']) ? $_POST['description'] : "";
	$idevent = isset($_POST['idevent']) ? $_POST['idevent'] : 1;

	require_once("../class/event.php");

	$event = new Event();
	$jumlah_yang_dieksekusi = $event->updateEvent($name, $date, $description, $idevent);
	$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

	if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>