<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyPage extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('baseform_model');
	}

	public function index() {

		
	}

	public function leave() {

		$user 				= $this->session->userdata('user');
		if($user == null) {
			echo '<script type="text/javascript"> history.back(); </script>';
			return;
		}


		$parameters			= array();
		$parameters['user']	= $user;

		$customViews	 	= array('mypage/leave_view');
		$this->baseform_model->loadView($customViews, null, $parameters);
	}

	public function requestLeave() {

		try {

			$pw				= $this->input->post('pw');
			$reason			= $this->input->post('reason');
			$detail			= $this->input->post('detail');

			$this->load->model('member_model');
			$this->member_model->leave($pw, $reason, $detail);

			echo '<script type="text/javascript">alert("회원탈퇴가 정상적으로 완료되었습니다. 이용해주셔서 감사합니다."); location.href = "' . base_url() . '"; </script>';
		} catch(Exception $e) {

			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function modify() {

		$user 				= $this->session->userdata('user');
		if($user == null) {

			echo '<script type="text/javascript"> history.back(); </script>';
			return;
		}

		$customViews 		= array('mypage/modify_view');
		$parameters			= array('user' => $user);
		$this->baseform_model->loadView($customViews, null, $parameters);
	}

	public function requestModify() {

		try {

			$data						= $this->input->post();
			$isReceiveEmail				= $this->input->post('recvmail') != null ? 1 : 0;

			$this->load->model('member_model');
			$this->member_model->modify($data['pw'], $data['newpw'], $data['confirm'], $data['job'], $data['level'],
										sprintf("%s@%s", $data['email_account'], $data['email_domain']),
										$isReceiveEmail,
										sprintf("%s-%s-%s", $data['tel_id'], $data['tel_01'], $data['tel_02']),
										sprintf("%s-%s-%s", $data['hp_id'], $data['hp_01'], $data['hp_02']));

			echo '<script type="text/javascript">';
			echo 'alert("정보가 수정되었습니다.");';
			echo 'history.back();';
			echo '</script>';

		} catch(Exception $e) {

			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}
}