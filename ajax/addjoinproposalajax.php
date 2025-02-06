<?php
	require_once("../class/joinproposal.php");

	$idmember = isset($_POST['idmember']) ? $_POST['idmember'] : 1;
	$team = isset($_POST['team']) ? $_POST['team'] : 1;
	$desc = isset($_POST['description']) ? $_POST['description'] : "";

	$join_proposal = new JoinProposal();
	$last_id = $join_proposal->insertJoinProposal($idmember, $team, $desc);
	$hasil = $last_id ? 1 : 0;

	if($hasil == 1){
    	echo "berhasil";
    }
    else{
    	echo "gagal";
    }
?>