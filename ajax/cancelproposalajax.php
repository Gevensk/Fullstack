<?php
	$idjp = isset($_POST['idjp']) ? $_POST['idjp'] : 1;

	require_once("../class/joinproposal.php");
	$join_proposal = new JoinProposal();
	$jumlah_yang_dieksekusi = $join_proposal->cancelProposal($idjp);
	$hasil = $jumlah_yang_dieksekusi ? 1 : 0;

	if($hasil == 1){
		echo "berhasil";
	}
	else{
		echo "gagal";
	}
?>