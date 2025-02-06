<?php
	require_once("koneksi.php");

	class Achievement extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getAchievement($cari="", $offset=null, $limit=null){
			$cari_persen = "%".$cari."%";

			if(is_null($limit)){
				$sql = "select * from achievement where name like ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("s", $cari_persen);
			}
			else{
				$sql = "select * from achievement where name like ? limit ?, ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("sii", $cari_persen, $offset, $limit);
			}
			
			$stmt->execute();
        	$res = $stmt->get_result();

        	return $res;
		}

		public function getAchievementById($idachievement){
			$sql = "select * from achievement where idachievement = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idachievement);
			$stmt->execute();
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();

			return $row;
		}

		public function getTeamNameById($idteam){
			$sql = "select t.name as team_name from team as t
                        inner join achievement as a on t.idteam = a.idteam
                        where a.idteam = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $res = $stmt->get_result();
            $team = $res->fetch_assoc();

            return $team;
		}

		public function getAchievementByMember($idmember, $cari=""){
			$cari_persen = "%".$cari."%";

			$sql = "select t.name as team_name, a.* from team as t
						inner join achievement as a on t.idteam = a.idteam
						inner join team_members as tm on t.idteam = tm.idteam
						where tm.idmember = ? and a.name like ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('is', $idmember, $cari_persen);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function HitungTotalAchievement($idteam) {
			$sql = "SELECT COUNT(*) as total FROM achievement WHERE idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();
			$res = $stmt->get_result();
			return $res->fetch_assoc()['total'];
		}

		public function getAchievementByTeam($idteam, $offset = null, $limit = null) {
			if(is_null($limit)){
				$sql = "select a.idachievement, t.idteam, a.name, a.date, a.description 
					from achievement AS a 
					inner join team AS t on a.idteam = t.idteam 
					where t.idteam = ?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param('i', $idteam);
			}
			else{
				$sql = "select a.idachievement, t.idteam, a.name, a.date, a.description 
					from achievement AS a 
					inner join team AS t on a.idteam = t.idteam 
					where t.idteam = ? 
					limit ?, ?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param('iii', $idteam, $offset, $limit);
			}
			$stmt->execute();
			return $stmt->get_result();
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

		public function insertAchievement($idteam, $name, $date, $description){
			$sql = "insert into achievement(idteam, name, date, description) values(?, ?, ?, ?)";
    		$stmt = $this->mysqli->prepare($sql);
    		$stmt->bind_param('isss', $idteam, $name, $date, $description);
    		$stmt->execute();

    		return $last_id = $stmt->insert_id;
		}

		public function updateAchievement($idteam, $name, $date, $description, $idachievement){
			$sql = "update achievement set idteam = ?, name = ?, date = ?, description = ? where idachievement = ?";
    		$stmt = $this->mysqli->prepare($sql);
    		$stmt->bind_param('isssi', $idteam, $name, $date, $description, $idachievement);
    		$stmt->execute();

    		return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function deleteAchievement($idachievement=null, $idteam=null){
			if(!is_null($idachievement)){
				$sql = "delete from achievement where idachievement = ?";
    			$stmt = $this->mysqli->prepare($sql);
    			$stmt->bind_param('i', $idachievement);
			}
			else{
				$sql = "delete from achievement where idteam = ?";
    			$stmt = $this->mysqli->prepare($sql);
    			$stmt->bind_param('i', $idteam);
			}
    		$stmt->execute();

    		return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}
	}
?>