<?php
	$idevent = isset($_POST['idevent']) ? $_POST['idevent'] : 1;

	require_once("../class/event.php");

	$event = new Event();
	$jumlah_yang_dieksekusi = $event->deleteEvent($idevent);
	$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

	if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>