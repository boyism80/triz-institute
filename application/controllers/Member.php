<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/exceptions/RequireLoginException.php';

class Member extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('member_model');
		$this->load->model('baseform_model');
	}

	public function index() {

		$this->login();
	}

	public function request() {

		$signinInfo			= $this->session->userdata('signin');
		if($signinInfo == null)
			$signinInfo		= array('step' => 'agreement');

		try {
			switch($signinInfo['step']) {

				case 'agreement':
					$agreeClause			= $this->input->post('agree-clause');
					$agreePrivacy			= $this->input->post('agree-privacy');
					if($agreeClause == null || $agreePrivacy == null)
						throw new Exception('약관에 동의하세요');
					$signinInfo['step']		= 'registration';
					break;

				case 'registration':
					$data 					= $this->input->post();
					$isReceiveEmail			= $this->input->post('member_recvmail') != null ? 1 : 0;
					$signinInfo['member']	= $signinInfo['member'] 	= array('name' 			=> $data['member_name'],
																				'id' 			=> $data['member_id'],
																				'pw' 			=> $data['member_pw'],
																				'confirm' 		=> $data['member_pw_confirm'],
																				'job'			=> $data['member_job'],
																				'level' 		=> $data['member_level'],
																				'email_account' => $data['member_mail_account'],
																				'email_domain' 	=> $data['member_mail_domain'],
																				'email_receive' => $isReceiveEmail,
																				'tel_id' 		=> $data['tel_id'],
																				'tel_01' 		=> $data['tel_01'],
																				'tel_02' 		=> $data['tel_02'],
																				'hp_id' 		=> $data['hp_id'],
																				'hp_01' 		=> $data['hp_01'],
																				'hp_02' 		=> $data['hp_02']);
					$memberID 				= $this->member_model->registration($data['member_name'], $data['member_id'], $data['member_pw'], 
																				$data['member_pw_confirm'],
																				$data['member_job'], 
																				$data['member_level'],
																				sprintf("%s@%s", $data['member_mail_account'], $data['member_mail_domain']), 
																				sprintf("%s-%s-%s", $data['tel_id'], $data['tel_01'], $data['tel_02']),
																				sprintf("%s-%s-%s", $data['hp_id'], $data['hp_01'], $data['hp_02']),
																				$isReceiveEmail);
					$signinInfo['step']		= 'complete';
					break;

				case 'complete':
					break;
			}

			$this->session->set_userdata('signin', $signinInfo);
			redirect('member/signin');

		} catch (Exception $e) {
			
			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function signin() {

		$signinInfo			= $this->session->userdata('signin');
		if($signinInfo == null)
			$signinInfo		= array('step' => 'agreement');

		$this->load->model('member_model');

		// Display view
		switch($signinInfo['step']) {

			case 'agreement':
				$customViews			= array('member/signin/agreement_view');
				$mobileViews			= array('mobile/member/signin/agreement_view');
				$parameters				= array('text' => $this->member_model->agreementText());

				$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
				break;

			case 'registration':
				$customViews			= array('member/signin/registration_view');
				$mobileViews			= array('mobile/member/signin/registration_view');
				$parameters				= null;

				$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
				break;

			case 'complete':
				$customViews			= array('member/signin/complete_view');
				$mobileViews			= array('mobile/member/signin/complete_view');
				$parameters				= array('name' => $signinInfo['member']['name']);

				$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
				$this->session->unset_userdata('signin');
				break;
		}
	}

	public function login() {

		$user 				= $this->session->userdata('user');
		if($user != null)
			redirect('home');

		$customViews 		= array('member/login_view');
		$mobileViews		= array('mobile/member/login_view');
		$this->baseform_model->loadView($customViews, $mobileViews);
	}

	public function logout() {

		$this->member_model->logout();
		echo '<script type="text/javascript">history.back();</script>';
	}

	public function requestLogin() {

		$id 			= $this->input->post('id');
		$pw				= $this->input->post('pw');
		$path			= $this->input->post('path');

		$result			= $this->member_model->login($id, $pw);
		if($result['success'] == false) {

			echo '<script type="text/javascript">';
			echo 'alert("' . $result['error'] . '");';
			echo 'history.back();';
			echo '</script>';
			return;
		}

		if($path == null)
			redirect('home');
		else
			redirect($path);
	}

	public function requestLogout() {

		$this->member_model->logout();
		echo json_encode(true);
	}

	public function exists($id = null) {

		$ret 				= array('success' => true);
		try {
			
			$ret['data']	= $this->member_model->existsID($id);

		} catch (Exception $e) {
			
			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function inquiry() {

		$user 							= $this->session->userdata('user');
		if($user != null)
			redirect('home');

		$customViews					= array('member/inquiry_view');
		$mobileViews 					= array('mobile/member/inquiry_view');
		$parameters						= null;
		$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
	}

	public function inquiryId() {

		try {
			
			$postval		= $this->input->post();
			$result 		= $this->member_model->inquiryId($postval['find-id-name'], $postval['find-id-email']);

			$customViews	= array('member/inquiry_id_view');
			$mobileViews 	= null;
			$parameters		= array('id' => $result);

			$this->baseform_model->loadView($customViews, $mobileViews, $parameters);

		} catch (Exception $e) {
			
			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function inquiryPw() {

		try {
			
			$postval		= $this->input->post();
			$result 		= $this->member_model->inquiryPw($postval['find-pw-name'], $postval['find-pw-id'], $postval['find-pw-email']);

			$customViews	= array('member/inquiry_pw_view');
			$mobileViews 	= null;
			$parameters		= array('pw' => $result);

			$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
		} catch (Exception $e) {
			
			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}
}