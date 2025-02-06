<?php
	require_once("koneksi.php");

	class Frontend extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getTeam($offset=null, $limit=null){
			if(is_null($limit)){
				$sql = "select g.idgame, g.name as game_name, t.* from team as t
					inner join game as g on t.idgame = g.idgame";
				$stmt = $this->mysqli->prepare($sql);
			}
			else{
				$sql = "select g.idgame, g.name as game_name, t.* from team as t
					inner join game as g on t.idgame = g.idgame
					limit ?,?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param("ii", $offset, $limit);
			}
			
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getGameDetail($idgame){
			$sql = "select g.idgame, t.name as team_name, e.* from game as g
						left join team as t on g.idgame = t.idgame
						left join event_teams as et on t.idteam = et.idteam
						inner join event as e on et.idevent = e.idevent
						where t.idgame = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idgame);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getGame(){
			$sql = "select * from game";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->execute();
			$res =  $stmt->get_result();

			return $res;
		}
	}
?>