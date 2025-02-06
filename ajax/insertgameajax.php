<?php
	require_once("../class/game.php");
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	$description = isset($_POST['description']) ? $_POST['description'] : "";

    $game = new Game();
    $last_id = $game->insertGame($name, $description);
    $hasil = $last_id ? 1 : 0;
    
    if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>