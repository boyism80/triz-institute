<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'core/exceptions/NoPrivilegeException.php';

class Admin extends CI_Controller {

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

	function __construct() {

		parent::__construct();

		$user 				= $this->session->userdata('user');
		if($user == null || intval($user['admin']) == 0) {

			echo '<script type="text/javascript"> history.back(); </script>';
		}

		$this->load->model('baseform_model');
	}

	public function index() {

		$this->mailing();
	}

	public function mailing() {

		$user 				= $this->session->userdata('user');
		$customViews		= array('admin/mailing_view');
		$parameters			= array('user' => $user);

		$this->baseform_model->loadView($customViews, null, $parameters);
	}

	public function mailing_result() {

		try {

			$user 				= $this->session->userdata('user');

			$this->load->library('PHPExcel');
			$data			= $this->input->post();
			
			$this->load->model('admin_model');
			$addrlist		= $this->admin_model->sendmail2Excel($data, $_FILES['excel_file']);

			$customViews 			= array('admin/mailing_result_view');
			$this->baseform_model->loadView($customViews, null, array('addrlist' => $addrlist));
		} catch (Exception $e) {

			echo '<script type="text/javascript"> alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function regsoft() {

		$this->load->model('manufacturer_model');

		try {

			$user 				= $this->session->userdata('user');
			if(intval($user['admin']) == 0)
				throw new NoPrivilegeException();

			$customViews		= array('admin/regsoft_view');
			$parameters			= array('manufacturers' => $this->manufacturer_model->gets());

			$this->baseform_model->loadView($customViews, null, $parameters);
		} catch(Exception $e) {

			echo '<script type="text/javascript"> alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function regsoft_result() {

		try {
			
			$user 				= $this->session->userdata('user');
			if($user == null || intval($user['admin']) == 0)
				throw new NoPrivilegeException();

			$data				= $this->input->post();

			$this->load->model('admin_model');
			$id 				= $this->admin_model->registerSoftware($data['name'], $data['manufacturer'], $data['lease_7d'], $data['lease_30d'], $data['url'], $data['content']);
			redirect('onlineshop/software?index=' . $id);

		} catch (Exception $e) {
			
			echo '<script type="text/javascript"> alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function regpub() {

		try {

			$user 			= $this->session->userdata('user');
			if(intval($user['admin']) == 0)
				throw new NoPrivilegeException();

			$customViews		= array('admin/regpub_view');
			$this->baseform_model->loadView($customViews);
			
		} catch (Exception $e) {
			
			echo '<script type="text/javascript"> alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function regpub_result() {

		try {
			
			$user 				= $this->session->userdata('user');
			if($user == null || intval($user['admin']) == 0)
				throw new NoPrivilegeException();

			$data			= $this->input->post();

			$this->load->model('admin_model');
			$id 				= $this->admin_model->registerPublish($data['name'], $data['publisher'], $data['writer'], 
																	  $data['price'], $data['pubdate'], $data['page'], 
																	  $data['ISBN'], $data['url'], $data['intro'], 
																	  $data['toc'], $data['pubreview'], $data['subtitle']);
			redirect('onlineshop/publication?index=' . $id);

		} catch (Exception $e) {
			
			echo '<script type="text/javascript"> alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function member() {

		try {

			$this->load->model('member_model');

			$customViews		= array('admin/member_view');
			$mobileViews		= array('mobile/admin/member_view');
			$parameters			= array('data' => $this->member_model->gets());
			$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
			
		} catch (Exception $e) {

			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back();</script>';
		}
	}

	public function assign($memberIndex) {

		try {

			$this->load->model('member_model');
			$this->member_model->assignAdminPrivilege($memberIndex);
			redirect('admin/member');
		} catch (Exception $e) {
			
			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back();</script>';
		}
	}

	public function relieve($memberIndex) {

		try {

			$this->load->model('member_model');
			$this->member_model->relieveAdminPrivilege($memberIndex);
			redirect('admin/member');
		} catch (Exception $e) {
			
			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back();</script>';
		}
	}
}