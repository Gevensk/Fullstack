<?php
	function generate_page($cari="", $total_data, $limit, $no_halaman){
    	$hasil = "";
    	$max_hal = ceil($total_data / $limit);
    	for($hal = 1; $hal <= $max_hal; $hal++){
        	if($no_halaman == $hal){
            	$hasil .= "<b>$hal </b>";
        	} 
        	else {
				if(!is_null($cari)){
					$hasil .= "<a href='?page=$hal&cari=$cari'>$hal </a>";
				}
				else{
					$hasil .= "<a href='?page=$hal&id=$idteam'>$hal </a>";
				}
			}
    	}
    	return $hasil;
	}

	function generate_page_viewteam($idmember, $cari="", $total_data, $limit, $no_halaman){
		$hasil = "";
		$max_hal = ceil($total_data/$limit);
		for($hal = 1; $hal <= $max_hal; $hal++){
			if($no_halaman == $hal){
				$hasil .= "<b>$hal </b>";
			}
			else{
				if($cari != ""){
					$hasil .= "<a href='?idmember=$idmember&page=$hal&cari=$cari'>$hal </a>";
				}
				else{
					$hasil .= "<a href='?idmember=$idmember&page=$hal'>$hal </a>";
				}
			}
		}
		return $hasil;
	}

	function generate_page_mn($total_data, $limit, $no_halaman, $idteam){
	    $hasil = "";
	    $max_hal = ceil($total_data / $limit);
	    for ($hal = 1; $hal <= $max_hal; $hal++) {
	        if ($no_halaman == $hal) {
	            $hasil .= "<b>$hal </b>";
	        } else {
	            $hasil .= "<a href='?id=$idteam&page=$hal'>$hal </a>";
	        }
	    }
	    return $hasil;
	}
?>