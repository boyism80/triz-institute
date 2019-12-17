<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/exceptions/NoPrivilegeException.php';

class Member_model extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	private $clausePath		= 'assets/txt/clause.txt';
	private $privacyPath	= 'assets/txt/privacy.txt';

	private function updateLoginSession($row) {

		// explode email (account and domain)
		$emailPieces				= explode('@', $row['email']);
		$row['email_account']		= $emailPieces[0];
		$row['email_domain']		= $emailPieces[1];

		// explode telephone number
		$telPieces					= explode('-', $row['tel']);
		$row['tel_id']				= $telPieces[0];
		$row['tel_01']				= $telPieces[1];
		$row['tel_02']				= $telPieces[2];

			// explode hp number
		$hpPieces					= explode('-', $row['hp']);
		$row['hp_id']				= $hpPieces[0];
		$row['hp_01']				= $hpPieces[1];
		$row['hp_02']				= $hpPieces[2];

		$row['idx']					= intval($row['idx']);
		$row['admin']				= (boolean)intval($row['admin']);
		$row['recvmail']			= (boolean)intval($row['admin']);
		$row['mileage']				= intval($row['mileage']);
		$row['privilege']			= intval($row['privilege']);

		$this->session->set_userdata('user', $row);
		return $row;
	}


	public function login($id, $pw) {

		$ret 				= array('success' => true);
		try {

			if($id == false || mb_strlen($id) == 0)
				throw new Exception('아이디를 입력하세요');

			if($pw == false || mb_strlen($pw) == 0)
				throw new Exception('비밀번호를 입력하세요');

			$id 			= $this->db->escape($id);
			$pw 			= md5($this->db->escape($pw));

			$this->db->trans_start();
			$sql			=  "SELECT idx, id, name, job, level, email, recvmail, tel, hp, register, last_login, mileage, privilege, admin 
								FROM user 
								WHERE id = $id AND password = '$pw' AND deleted = 0 LIMIT 1";
			$query			= $this->db->query($sql);
			$this->db->trans_complete();

			if($query->num_rows() == 0)
				throw new Exception('아이디 혹은 비밀번호가 올바르지 않습니다.');

			$user 						= $query->row_array();
			$ret['data']				= $this->updateLoginSession($user);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		return $ret;
	}

	private function updateCurrentUser() {

		try {

			$user 					= $this->session->userdata('user');
			$idx 					= $user['idx'];

			$this->db->trans_start();
			$sql					= "SELECT idx, id, name, job, level, email, recvmail, tel, hp, register, last_login, mileage, privilege, admin 
									   FROM user 
									   WHERE idx = $idx AND deleted = 0 LIMIT 1";
			$query					= $this->db->query($sql);
			$this->db->trans_complete();

			$user 					= $query->row_array();
			return $this->updateLoginSession($user);
			
		} catch (Exception $e) {
			
			return null;
		}
	}

	public function logout() {

		$this->session->sess_destroy();
	}

	//
	// 회원탈퇴하여 정보를 찾을 수 없는 경우도 고려해야함
	//
	public function index2Name($index) {

		$this->db->trans_start();
		$sql				= "SELECT name FROM user WHERE idx = $index";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		$row 				= $query->row_array();
		return $row['name'];
	}

	public function name2Index($name) {

		$this->db->trans_start();
		$sql				= "SELECT idx FROM user WHERE name = '$name'";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		$row 				= $query->row_array();
		return intval($row['idx']);
	}

	public function index2Id($index) {

		$this->db->trans_start();
		$sql				= "SELECT id FROM user WHERE idx = $index";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		$row 				= $query->row_array();
		return $row['id'];
	}

	public function id2Index($id) {

		$this->db->trans_start();
		$sql				= "SELECT idx FROM user WHERE id = '$id'";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		$row 				= $query->row_array();
		return intval($row['idx']);
	}

	public function email2Index($email) {

		$this->db->trans_start();
		$sql				= "SELECT idx FROM user WHERE email = '$email'";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		$row 				= $query->row_array();
		return intval($row['idx']);
	}

	public function agreementText() {

		$ret 				= array();

		$file 				= fopen($this->clausePath, 'rt');
		if($file == null)
			throw new Exception('파일을 읽지 못했습니다.');

		$ret['clause'] 		= fread($file, filesize($this->clausePath));
		if($ret['clause'] == null)
			throw new Exception('즐');

		// $ret['clause']		= filesize($this->clausePath);
		fclose($file);

		// read privacy file
		$file 					= fopen($this->privacyPath, 'rt');
		if($file == null)
			throw new Exception('파일을 읽지 못했습니다.');
		$ret['privacy'] 	= fread($file, filesize($this->privacyPath));
		if($ret['privacy'] == null)
			throw new Exception('즐');
		// $ret['privacy']		= filesize($this->privacyPath);
		fclose($file);

		return $ret;
	}

	private function inspectID($id) {

		if(preg_match('/^[\w-]{4,12}+$/D', $id)== false)
			return false;
		
		return true;
	}

	public function existsID($id) {

		if(isset($id) == false || mb_strlen($id) == 0)
			throw new Exception('ID를 정확히 입력하세요.');

		$id 					= $this->db->escape($id);
		$this->db->trans_start();
		$sql					= "SELECT idx FROM user WHERE id = $id AND deleted = 0";
		$query 					= $this->db->query($sql);
		$this->db->trans_complete();

		return $query->num_rows() != 0;
	}

	private function inspectForm($job, $email, $tel, $hp) {

		if(mb_strlen($job) == 0)
			throw new Exception('직업을 선택하세요.');

		if(mb_strlen($email) == 0)
			throw new Exception('이메일 주소를 입력하세요.');

		if(filter_var($email, FILTER_VALIDATE_EMAIL) == false)
			throw new Exception('이메일 형식이 올바르지 않습니다. : ' . $email);

		if(preg_match("/^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/", $tel) == false)
			throw new Exception('전화번호 형식이 올바르지 않습니다.');

		if(preg_match("/^[0-9]{3}-[0-9]{3,4}-[0-9]{4}$/", $hp) == false)
			throw new Exception('휴대폰 번호의 형식이 올바르지 않습니다.');
	}

	public function registration($name, $id, $pw, $confirm, $job, $level, $email, $tel, $hp, $recvmail = true) {

		$nameLen				= mb_strlen($name);
		if($nameLen < 2)
			throw new Exception('이름을 정확히 입력하세요.');

		if($this->inspectID($id) == false)
			throw new Exception('아이디는 영문, 숫자, _의 조합으로 4~12자 내로 사용이 가능합니다.');

		if($this->existsID($id) != false)
			throw new Exception('이미 존재하는 ID입니다.');

		$pwLen					= mb_strlen($pw);
		if($pwLen < 4 || $pwLen > 12)
			throw new Exception('비밀번호는 4~12자 이내로 입력하세요.');

		if(strcmp($pw, $confirm) != 0)
			throw new Exception('비밀번호를 다시 확인하세요.');

		$this->inspectForm($job, $email, $tel, $hp);

		$recvmail				= intval($recvmail);
		$pw 					= md5($this->db->escape($pw));
		$currentDateTime		= date("Y-m-d H:i:s");
		$this->db->trans_start();
		$sql					= "INSERT INTO user (name, id, password, job, level, email, recvmail, tel, hp, register) 
								   VALUES('$name', '$id', '$pw', '$job', '$level', '$email', $recvmail, '$tel', '$hp', '$currentDateTime')";

		$query 					= $this->db->query($sql);
		$memberIndex			= $this->db->insert_id();
		$this->db->trans_complete();

		return $memberIndex;
	}

	public function leave($pw, $reason, $detail) {

		$user 			= $this->session->userdata('user');
		if($user == null)
			throw new RequireLoginException();

		$userIndex 		= $user['idx'];
		$pw 			= md5($this->db->escape($pw));

		$this->db->trans_start();
		$sql			= "SELECT idx FROM user WHERE idx = $userIndex AND password = '$pw' AND deleted = 0 LIMIT 1";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception('비밀번호가 올바르지 않습니다.');

		$currentDateTime= date("Y-m-d H:i:s");
		$this->db->trans_start();
		$sql			= "INSERT INTO `leave` (uidx, reason, detail, date) VALUES($userIndex, '$reason', '$detail', '$currentDateTime')";
		$query 			= $this->db->query($sql);

		$sql			= "UPDATE user SET deleted = 1 WHERE idx = $userIndex";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		$this->session->unset_userdata('user');
	}

	public function modify($pw, $newpw, $confirm, $job, $level, $email, $recvmail, $tel, $hp) {

		$user 			= $this->session->userdata('user');
		if($user == null)
			throw new RequireLoginException();

		$userIndex		= $user['idx'];
		$currentPw 		= md5($this->db->escape($pw));

		$this->db->trans_start();
		$sql			= "SELECT idx FROM user WHERE idx = $userIndex AND password = '$currentPw' AND deleted = 0 LIMIT 1";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception('비밀번호가 올바르지 않습니다.');

		if(strcmp($newpw, $confirm) != 0)
			throw new Exception('비밀번호를 다시 확인해주세요.');

		$this->inspectForm($job, $email, $tel, $hp);

		$newpw			= mb_strlen($newpw) != 0 ? md5($this->db->escape($newpw)) : $currentPw;
		$ecvmail		= intval($recvmail);
		
		$this->db->trans_start();
		$sql			=  "UPDATE user 
							SET password = '$newpw', job = '$job', level = '$level', email = '$email', recvmail = $recvmail, tel = '$tel', hp = '$hp' 
							WHERE idx = $userIndex AND deleted = 0 
							LIMIT 1";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		return $this->updateCurrentUser();
	}

	public function inquiryId($name, $email) {

		$this->db->trans_start();
		$sql			= "SELECT id FROM user WHERE name = '$name' AND email = '$email' AND deleted = 0 LIMIT 1";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception('해당하는 ID가 존재하지 않습니다.');

		$row 			= $query->row_array();
		return $row['id'];
	}

	public function inquiryPw($name, $id, $email) {

		$this->db->trans_start();
		$sql			= "SELECT idx FROM user WHERE name = '$name' AND id = '$id' AND email = '$email' AND deleted = 0 LIMIT 1";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception('해당하는 결과가 없습니다.');

		$row 			= $query->row_array();
		$index 			= intval($row['idx']);
		
		$newpw			= strval(rand(1000, 99999999));
		$newpw			= md5($this->db->escape($newpw));

		$this->db->trans_start();
		$sql			= "UPDATE user SET password = '$newpw' WHERE idx = $index";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		$this->load->model('admin_model');
		$this->admin_model->sendmail($email, '트리즈혁신연구소 홈페이지 비밀번호가 변경되었습니다.', '<div>변경된 비밀번호는 ' . $newpw . ' 입니다. </div><div>홈페이지에서 반드시 비밀번호를 변경해주세요.</div>');

		return $newpw;
	}

	public function gets() {

		$user 			= $this->session->userdata('user');
		if($user == null || $user['admin'] == false)
			throw new NoPrivilegeException();

		$sql			= "SELECT idx, id, name, job, level, email, recvmail, tel, hp, register, admin FROM user WHERE deleted = 0 AND admin = 0 ORDER BY idx";
		$query			= $this->db->query($sql);
		$members		= $query->result_array();


		$sql			= "SELECT idx, id, name, job, level, email, recvmail, tel, hp, register, admin FROM user WHERE deleted = 0 AND admin = 1 ORDER BY idx";
		$query			= $this->db->query($sql);
		$admins			= $query->result_array();

		return array('members' => $members, 'admins' => $admins);
	}

	public function assignAdminPrivilege($memberIndex) {

		$user 			= $this->session->userdata('user');
		if($user == null || $user['admin'] == false)
			throw new NoPrivilegeException();

		$this->db->trans_start();
		$sql			= "UPDATE user SET admin = 1 WHERE idx = $memberIndex AND deleted = 0 LIMIT 1";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		return $this->db->affected_rows() > 0;
	}

	public function relieveAdminPrivilege($memberIndex) {

		$user 			= $this->session->userdata('user');
		if($user == null || $user['admin'] == false)
			throw new NoPrivilegeException();

		if($user['idx'] == intval($memberIndex))
			throw new Exception('권한을 해제할 수 없습니다.');

		$this->db->trans_start();
		$sql			= "UPDATE user SET admin = 0 WHERE idx = $memberIndex AND deleted = 0 LIMIT 1";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		return $this->db->affected_rows() > 0;
	}
}