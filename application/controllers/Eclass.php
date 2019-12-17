<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'core/exceptions/NoCertificateException.php';

class Eclass extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('board_model');
		$this->load->model('eclass_model');
		$this->load->model('category_model');
		$this->load->model('baseform_model');
	}

	public function index () {

		$this->home();
	}

	public function add () {

		$ret 					= array('success' => true);
		try {

			$title				= $this->input->post('title');
			$name 				= $this->input->post('name');
			$pw					= $this->input->post('pw');

			$this->eclass_model->add($title, $name, $pw);
		} catch(Exception $e) {

			$ret['success']		= false;
			$ret['error']		= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function gets () {

		$ret 					= array('success' => true);
		try {

			$ret['data']		= $this->eclass_model->gets();
		} catch(Exception $e) {

			$ret['success']		= false;
			$ret['error']		= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function home () {

		$user 				= $this->session->userdata('user');
		$parameters			= array('currentTab' => $this->category_model->current(), 'data' => $this->eclass_model->gets());

		try {

			$this->baseform_model->loadView(array('e-class/home_view'), array('mobile/e-class/home_view'), array('data' => $this->eclass_model->gets()));
		} catch (Exception $e) {
			
			$this->board_model->inspectException($e);
		}
	}

	private function groupview ($name) {

		$parameters						= array('name' => $name);

		try {

			$customViews				= array('e-class/content_view');
			$parameters['board']		= json_encode(array('notice' => $this->eclass_model->board($name, 'notice', 5),
														'lecture' => $this->eclass_model->board($name, 'lecture', 5),
														'reference' => $this->eclass_model->board($name, 'reference', 5)));

			$this->baseform_model->loadView($customViews, null, $parameters);

			$parameters['name']			= $name;
			$parameters['board']		= json_encode(array('notice' => $this->eclass_model->board($name, 'notice', 5),
															'lecture' => $this->eclass_model->board($name, 'lecture', 5),
															'reference' => $this->eclass_model->board($name, 'reference', 5)));
			$parameters['customViews']	= array('e-class/content_view');

			// if(true) {

			// 	$this->load->view('mobile/baseform_view', $parameters);
			// } else {

			// 	$this->load->view('header_view', array('menu' => $this->menu));
			// 	$this->load->view('baseform_view', $parameters);
			// 	$this->load->view('footer_view');
			// }

		} catch(NoCertificateException $e) {

			$customViews				= array('e-class/certificate_view');
			$parameters['certifimap']	= json_encode($this->session->userdata('ec_certifmap'));

			$this->baseform_model->loadView($customViews, null, $parameters);
			
			// $this->load->view('header_view', array('menu' => $this->menu));
			
			// $customViews = array('e-class/certificate_view');
			// $this->load->view('baseform_view', array_merge(array('currentTab' => $this->category_model->current(), 'customViews' => $customViews), $parameters));
			
			// $this->load->view('footer_view');
		} catch (Exception $e) {
			$this->board_model->inspectException($e);
		}
	}

	public function board($name, $bname = null) {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);

		try {

			switch($bname) {

				case null:
					$this->groupview($name);
					break;

				case 'lecture':
					$this->lectureBoard($name, $mode, $index);
					break;

				default:
					$this->defaultBoard($name, $bname, $mode, $index);
					break;
			}

		} catch(NoCertificateException $e) {

			$parameters						= array('name' => $name, 'certifimap' => json_encode($this->session->userdata('ec_certifmap')));
			$customViews					= array('e-class/certificate_view');

			$this->baseform_view($customViews, null, $parameters);

		} catch (Exception $e) {
			$this->board_model->inspectException($e);
		}
	}

	private function lectureBoard($name, $mode, $index) {

		if($this->eclass_model->isCertificate($name) == false)
			throw new NoCertificateException();

		$dbname							= $name . '_lecture';
		$viewname						= array('read' => array('e-class/partition/read/ereadform_view', 'partition/readform/readform_view_js'), 
												'write' => array('e-class/partition/write/ewriteform_view', 'partition/writeform/writeform_fileset_js', 'e-class/partition/write/ewriteform_upload_board_js'),
												'modify' => array('e-class/partition/write/ewriteform_view', 'partition/writeform/writeform_fileset_js', 'partition/modifyform/modifyform_restore_js', 'e-class/partition/modify/emodifyform_upload_board_js'));
		$option							= array('viewname' => $viewname);
		$parameters						= array();


		// Set parameters
		$parameters['name']				= $name;
		switch($mode) {

			case 'read':
				$index 					= intval($this->input->get('index', true));
				$linfo					= $this->eclass_model->getLecture($index);
				$ldata 					= $this->eclass_model->getLectureData(intval($linfo['idx']));
				$parameters['linfo']	= $linfo;
				$parameters['ldata']	= $ldata;
				$parameters['bindex']	= $index;

				$user 					= $this->session->userdata('user');
				if($user['admin'] == true) {
					array_push($viewname['read'], 'e-class/lecture_manage_view');
				} else {
					$modify				= $this->input->get('modify', true);
					if($modify == 'true')
						$viewname['read'] = array_merge($viewname['read'], array('e-class/lecture_submit_view', 'e-class/lecture_modify_view_js'));
					else if($ldata != null)
						$viewname['read'] = array_merge($viewname['read'], array('e-class/lecture_read_view'));
					else
						$viewname['read'] = array_merge($viewname['read'], array('e-class/lecture_submit_view', 'e-class/lecture_submit_view_js'));
				}
				break;

			case 'modify':
				$linfo					= $this->eclass_model->getLecture($index);
				$parameters['linfo']	= $linfo;
				break;
		}

		// Show board
		$this->board_model->showBoard($dbname, $mode, $index, array('viewname' => $viewname), $parameters);
	}

	private function defaultBoard($name, $bname, $mode, $index) {

		if($this->eclass_model->isCertificate($name) == false)
			throw new NoCertificateException();

		$dbname				= $name . '_' . $bname;
		$this->board_model->showBoard($dbname, $mode, $index);
	}

	public function addLecture($name) {

		if($this->eclass_model->isCertificate($name) == false)
			throw new NoCertificateException();

		$ret 				= array('success' => true);
		$binfo				= $this->input->post('binfo');
		$linfo				= $this->input->post('linfo');
		$dbname				= $name . '_lecture';
		$bindex				= null;

		try {
			if($this->board_model->inspect($dbname, 'write') == false)
				return;

			if(isset($binfo['files']) == false)
				$binfo['files']			= null;

			if(isset($binfo['thumbnail']) == false)
				$binfo['thumbnail']		= null;

			if(isset($linfo['limit-date']) == false)
				$linfo['limit-date']	= null;

			$bindex			= $this->board_model->add($dbname, $binfo['title'], $binfo['content'], $binfo['files'], $binfo['thumbnail']);
			$this->eclass_model->addLecture($linfo['submit-date'], $linfo['limit-date'], $linfo['score'], $bindex);

			$ret['data']	= $bindex;

		} catch (Exception $e) {

			if($bindex != null)
				$this->board_model->delete($bindex);
			
			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function submitLecture($lindex) {

		// certification exception

		$content 				= $this->input->post('content');
		$files					= $this->input->post('files');
		$ret 					= array('success' => true);

		try {

			$ret['data']		= $this->eclass_model->submitLecture($lindex, $content, $files);
		} catch (Exception $e) {
			
			$ret['success']		= false;
			$ret['error']		= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function evaluateLecture($index) {

		// certification exception

		$score					= $this->input->post('score');
		$comment				= $this->input->post('comment');
		$ret 					= array('success' => true);

		try {

			$ret['data']		= $this->eclass_model->evaluate($index, $score, $comment);
			
		} catch (Exception $e) {
			
			$ret['success']		= false;
			$ret['error']		= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function isCertificate($name) {

		$ret 					= array('success' => true);
		try {
			
			$ret['data']		= $this->eclass_model->isCertificate($name);
		} catch (Exception $e) {
			
			$ret['success']		= false;
			$ret['error']		= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function certificate($name) {

		$pw						= $this->input->post('pw');
		try {
			
			if($ret['data'] = $this->eclass_model->certificate($name, $pw) == false)
				throw new Exception('비밀번호가 올바르지 않습니다.');

			redirect('eclass/board/' . $name);
		} catch (Exception $e) {
			
			echo '<script type="text/javascript">alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function modify($lindex) {

		$ret 					= array('success' => true);
		try {

			$binfo				= $this->input->post('binfo');
			$linfo 				= $this->input->post('linfo');

			$ret['data']		= $this->eclass_model->modify($lindex, $binfo, $linfo);
		} catch (Exception $e) {
			
			$ret['success']		= false;
			$ret['error']		= $e->getMessage();
		}

		echo json_encode($ret);
	}
}