<?php
	require_once("koneksi.php");

	class Game extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getGame($cari="", $offset=null, $limit=null){
			$cari_persen = "%".$cari."%";

			if(is_null($limit)){
				$sql = "select * from game where name like ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("s", $cari_persen);
			}
			else{
				$sql = "select * from game where name like ? limit ?, ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("sii", $cari_persen, $offset, $limit);
			}
			
			$stmt->execute();
        	$res = $stmt->get_result();

        	return $res;
		}

		public function getGameById($idgame){
			$sql = "select * from game where idgame = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idgame);
			$stmt->execute();
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();

			return $row;
		}

		public function insertGame($name, $description){
			$sql = "insert into game(name, description) values(?, ?)";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('ss', $name, $description);
			$stmt->execute();

			return $last_id = $stmt->insert_id;
		}

		public function updateGame($name, $description, $idgame){
			$sql = "update game set name = ?, description = ? where idgame = ?";
        	$stmt = $this->mysqli->prepare($sql);
        	$stmt->bind_param('ssi', $name, $description, $idgame);
        	$stmt->execute();

        	return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function deleteGame($idgame){
			$sql = "delete from game where idgame = ?";
	    	$stmt = $this->mysqli->prepare($sql);
	    	$stmt->bind_param('i', $idgame);
	    	$stmt->execute();

	    	return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}
	}
?>