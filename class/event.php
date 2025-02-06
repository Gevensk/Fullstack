<?php
	require_once("koneksi.php");

	class Event extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getEvent($cari="", $offset = null, $limit = null){
			$cari_persen = "%".$cari."%";

			if(is_null($limit)){
				$sql = "select * from event where name like ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("s", $cari_persen);
			}
			else{
				$sql = "select * from event where name like ? limit ?, ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("sii", $cari_persen, $offset, $limit);
			}
			
			$stmt->execute();
        	$res = $stmt->get_result();

        	return $res;
		}

		public function getEventById($idevent){
			$sql = "select * from event where idevent = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idevent);
			$stmt->execute();
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();

			return $row;
		}

		public function getEventByMember($idmember, $cari=""){
			$cari_persen = "%".$cari."%";

			$sql = "select t.name as team_name, e.* from team as t
						left join event_teams as et on t.idteam = et.idteam
						left join event as e on et.idevent = e.idevent
						inner join team_members as tm on t.idteam = tm.idteam
						where tm.idmember = ? and e.name like ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('is', $idmember, $cari_persen);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getEventByTeam($idteam){
			$sql = "select e.* from event as e
						inner join event_teams as et on e.idevent = et.idevent
						where et.idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function insertEvent($name, $date, $description){
			$sql = "insert into event(name, date, description) values (?, ?, ?)";
    		$stmt = $this->mysqli->prepare($sql);
   			$stmt->bind_param('sss', $name, $date, $description);
    		$stmt->execute();

    		return $last_id = $stmt->insert_id;
		}

		public function updateEvent($name, $date, $description, $idevent){
			$sql = "update event set name = ?, date = ?, description = ? where idevent = ?";
    		$stmt = $this->mysqli->prepare($sql);
    		$stmt->bind_param('sssi', $name, $date, $description, $idevent);
    		$stmt->execute();

    		return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function deleteEvent($idevent){
			$sql = "delete from event where idevent = ?";
    		$stmt = $this->mysqli->prepare($sql);
    		$stmt->bind_param('i', $idevent);
    		$stmt->execute();

    		return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}
	}
?>