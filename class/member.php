<?php
	require_once("koneksi.php");

	class Member extends Koneksi{
		public function __construct(){
			parent::__construct();
		}

		public function getMember($username){
			$sql = "select * from member where username = ?";
			$stmt = $this->mysqli->prepare($sql);
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$res = $stmt->get_result();

			return $res->fetch_assoc();
		}

		public function doLogin($username, $plainpassword){
			$member = $this->getMember($username);
			if($member){
				$is_authenticate = password_verify($plainpassword, $member['password']);
				return $is_authenticate;
			}
			else{
				return false;
			}
		}

		public function register($fname, $lname, $username, $password){
		    $sql_check = "select idmember from member where username = ?";
		    $stmt_check = $this->mysqli->prepare($sql_check);
		    $stmt_check->bind_param('s', $username);
		    $stmt_check->execute();
		    $stmt_check->store_result();

		    if ($stmt_check->num_rows > 0) {
		        return "Username sudah tersedia. Silakan pilih username lain.";
		    } else {
		        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

		        $sql = "insert into member (fname, lname, username, password, profile) values (?, ?, ?, ?, 'user')";
		        $stmt = $this->mysqli->prepare($sql);
		        $stmt->bind_param('ssss', $fname, $lname, $username, $hashedpassword);
		        $stmt->execute();

		        return $last_id = $stmt->insert_id;
		    }
		}
	}
?>