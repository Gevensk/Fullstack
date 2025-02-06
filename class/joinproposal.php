<?php
	require_once("koneksi.php");

	class JoinProposal extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getJoinProposal($cari="", $offset=null, $limit=null){
			$cari_persen = "%".$cari."%";

			if(is_null($limit)){
				$sql = "select jp.*, m.fname, t.name as team_name from join_proposal as jp
							inner join member as m on jp.idmember = m.idmember
							inner join team as t on jp.idteam = t.idteam
							where m.fname like ?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param("s", $cari_persen);
			}
			else{
				$sql = "select jp.*, m.fname, t.name as team_name from join_proposal as jp
							inner join member as m on jp.idmember = m.idmember
							inner join team as t on jp.idteam = t.idteam
							where m.fname like ? limit ?,?";
				$stmt = $this->mysqli->prepare($sql);
				$stmt->bind_param("sii", $cari_persen, $offset, $limit);
			}

			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getJoinProposalByMember($idmember){
			$sql = "select jp.*, t.name as team_name from join_proposal as jp
						inner join team as t on jp.idteam = t.idteam
						where idmember = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idmember);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function getJoinProposalByTeam($idteam){
			$sql = "select jp.*, t.name as team_name from join_proposal as jp
						inner join team as t on jp.idteam = t.idteam
						where jp.idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res;
		}

		public function insertJoinProposal($idmember, $idteam, $description){
			$sql = "insert into join_proposal(idmember, idteam, description, status) values(?,?,?,'waiting')";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param("iis", $idmember, $idteam, $description);
			$stmt->execute();

			return $last_id = $stmt->insert_id;
		}

		public function cancelProposal($idproposal){
			$sql = "delete from join_proposal where idjoin_proposal = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idproposal);
			$stmt->execute();

			return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function deleteJpByTeam($idteam){
			$sql = "delete from join_proposal where idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('i', $idteam);
			$stmt->execute();

			return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}

		public function accProposal($idmember, $idteam){
			$sql = "update join_proposal set status = 'setuju'
					where idmember = ? and idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('ii', $idmember, $idteam);
			$stmt->execute();

			$datenow = date('Y-F-d');
			$description = "Bergabung pada " . $datenow;

			$sql2 = "insert into team_members(idteam, idmember, description) values(?,?,?)";
			$stmt2 = $this->mysqli->prepare($sql2);
			$stmt2->bind_param('iis', $idteam, $idmember, $description);
			$stmt2->execute();

			return $jumlah_yang_dieksekusi = $stmt2->affected_rows;
		}

		public function declineProposal($idmember, $idteam){
			$sql = "update join_proposal set status = 'tolak'
					where idmember = ? and idteam = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('ii', $idmember, $idteam);
			$stmt->execute();

			return $jumlah_yang_dieksekusi = $stmt->affected_rows;
		}
	}
?>