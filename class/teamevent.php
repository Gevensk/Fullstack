<?php
	require_once("class/koneksi.php");

	class TeamEvent extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getTeamEvent($idevent){
			$sql = "select * from event_teams where idevent = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idevent);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getEventByTeam($idteam, $offset = null, $limit = null){
			if(is_null($limit)){
				$sql = "select e.idevent, e.name, e.date from event as e
						inner join event_teams as et on e.idevent = et.idevent
						where et.idteam = ?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param('i', $idteam);
			}
			else{
				$sql = "select e.idevent, e.name, e.date from event as e
						inner join event_teams as et on e.idevent = et.idevent
						where et.idteam = ?
						limit ?,?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param('iii', $idteam, $offset, $limit);
			}
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getNameByTeam($idteam){
			// Hanya mengambil nama tim dari tabel team
			$sql = "SELECT name AS tname FROM team WHERE idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();
			$res = $stmt->get_result();
		
			return $res;
		}

		public function getExistEvent($idteam){
			$sql = "select e.idevent, e.name from event e 
					where e.idevent not in (
						select et.idevent 
						from event_teams et
						where et.idteam = ?
					)";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();
			$res = $stmt->get_result();
		
			return $res; 
		}

		public function insertTeamEvent($idevent, $idteam){
			$sql = "insert into event_teams(idevent, idteam) values(?,?)";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('ii', $idevent, $idteam);
			$stmt->execute();

			return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function deleteTeamEvent($idteam, $idevent=null){
			if(!is_null($idevent)){
				$sql = "delete from event_teams where idevent = ? and idteam = ?";
    			$stmt = $this->mysqli->prepare($sql);
    			$stmt->bind_param('ii', $idevent, $idteam);
			}
			else{
    			$sql = "delete from event_teams where idteam = ?";
    			$stmt = $this->mysqli->prepare($sql);
    			$stmt->bind_param('i', $idteam);

			}
    		$stmt->execute();

    		return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}
	}
?>