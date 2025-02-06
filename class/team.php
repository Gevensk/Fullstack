<?php
	require_once("koneksi.php");

	class Team extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getTeam($cari="", $offset=null, $limit=null){
			$cari_persen = "%".$cari."%";

			if(is_null($limit)){
				$sql = "select t.* from team as t
							inner join game as g on t.idgame = g.idgame
							where t.name like ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("s", $cari_persen);
			}
			else{
				$sql = "select t.*, g.name as game_name from team as t
							inner join game as g on t.idgame = g.idgame
							where t.name like ? limit ?, ?";
				$stmt = $this->mysqli->prepare($sql);
        		$stmt->bind_param("sii", $cari_persen, $offset, $limit);
			}
			
			$stmt->execute();
        	$res = $stmt->get_result();

        	return $res;
		}

		public function getTeamById($idteam){
			$sql = "select * from team where idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();

			return $row;
		}

		public function getTeamGame(){
			$sql = "select t.*, g.name as game_name from team as t
					inner join game as g on t.idgame = g.idgame";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->execute();
			$res = $stmt->get_result();

        	return $res;
		}

		public function getTeamMembers($idteam){
			$sql = "select concat(m.fname, ' ', m.lname) as fullname, tm.description from member as m
							inner join team_members as tm on m.idmember = tm.idmember
							where tm.idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getTeamByMember($idmember, $cari="", $offset=null, $limit=null){
			$cari_persen = "%".$cari."%";

			if(is_null($limit)){
				$sql = "select t.* from team as t
						inner join team_members as tm on t.idteam = tm.idteam
						inner join member as m on tm.idmember = m.idmember
						where m.idmember = ? and t.name like ?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param('is', $idmember, $cari_persen);
			}
			else{
				$sql = "select t.* from team as t
						inner join team_members as tm on t.idteam = tm.idteam
						inner join member as m on tm.idmember = m.idmember
						where m.idmember = ? and t.name like ? limit ?,?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param('isii', $idmember, $cari_persen, $offset, $limit);
			}
			
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getExistTeam($idmember){
		    $sql = "select t.* from team as t
		            where t.idteam not in (
		                select jp.idteam 
		                from join_proposal AS jp
		                where jp.idmember = ?
		            )";
		    $stmt = $this->mysqli->prepare($sql);
		    $stmt->bind_param('i', $idmember);
		    $stmt->execute();
		    $res = $stmt->get_result();
		    
		    return $res;
		}

		public function insertTeam($game, $name){
			$sql = "insert into team (idgame, name) values(?, ?)";
        	$stmt = $this->mysqli->prepare($sql);
        	$stmt->bind_param('is', $game, $name);
        	$stmt->execute();
    
        	return $last_id = $stmt->insert_id;
		}

		public function updateTeam($idgame, $name, $idteam){
			$sql = "update team set idgame=?, name=? where idteam=?";
        	$stmt = $this->mysqli->prepare($sql);
        	$stmt->bind_param('isi',$idgame,$name,$idteam);
        	$stmt->execute();

        	return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function deleteTeamMembers($idteam){
			$sql = "delete from team_members where idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();

			return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function deleteTeam($idteam){
			require_once("teamevent.php");
			$teamevent = new TeamEvent();
			$teamevent_check = $teamevent->getEventByTeam($idteam);
			$numrowteamevent = $teamevent_check->num_rows;

			require_once("achievement.php");
			$achievement = new Achievement();
			$achievement_check = $achievement->getAchievementByTeam($idteam);
			$numrowachievement = $achievement_check->num_rows;

			require_once("joinproposal.php");
			$joinproposal = new JoinProposal();
			$jp_check = $joinproposal->getJoinProposalByTeam($idteam);
			$numrowjp = $jp_check->num_rows;

			$teammember_check = $this->getTeamMembers($idteam);
			$numrowteammember = $teammember_check->num_rows;

			// cek apakah team tsb sudah punya data event/achievement/join_proposal
			if($numrowteamevent > 0 || $numrowachievement > 0 || $numrowjp > 0 || $numrowteammember > 0){
				//dilakukan delete untuk 3 tabel terkait terlebih dahulu
				$delteamevent = $teamevent->deleteTeamEvent($idteam);
				$delachievement = $achievement->deleteAchievement(null,$idteam);
				$deljp = $joinproposal->deleteJpByTeam($idteam);
				$deltm = $this->deleteTeamMembers($idteam);

				//jika sudah menghapus data team_event/achievement/join_proposal
				if($delteamevent || $delachievement || $deljp || $deltm){
					$this->deleteTeamImage($idteam);

					$sql = "delete from team where idteam = ?";
    				$stmt = $this->mysqli->prepare($sql);
    				$stmt->bind_param('i', $idteam);
    				$stmt->execute();

    				return $jumlah_yang_dieksekusi = $stmt->affected_rows;
				}
				else{
					return "Terjadi masalah saat penghapusan data terkait";
				}
			}
			// dijalankan jika team tsb belum punya data achievement, event_teams, dan join_proposal
			else{
				$this->deleteTeamImage($idteam);

				$sql = "delete from team where idteam = ?";
    			$stmt = $this->mysqli->prepare($sql);
    			$stmt->bind_param('i', $idteam);
    			$stmt->execute();

    			return $jumlah_yang_dieksekusi = $stmt->affected_rows;
			}
		}

		private function deleteTeamImage($idteam) {
		    $foto = "img/".$idteam.".jpg";

		    if (file_exists($foto)) {
		        unlink($foto);
		    }
		}
	}
?>