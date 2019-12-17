<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Community extends CI_Controller {

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

		$this->load->model('board_model');
		$this->load->model('baseform_model');
	}

	public function index() {

		$this->notice();
	}

	public function notice() {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'notice';

		$this->board_model->showBoard($dbname, $mode, $index);
	}

	public function fqa() {

		$this->load->model('fqa_model');

		$customViews 		= array('community/fqa_view');
		$mobileViews		= array('mobile/community/fqa_view');
		$parameters			= array('fqalist' => $this->fqa_model->gets());
		$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
	}

	public function qna() {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'qna';

		$this->board_model->showBoard($dbname, $mode, $index);
	}

	public function communityRoom() {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'community-room';
		
		$this->board_model->showBoard($dbname, $mode, $index);
	}

	public function gallery() {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'gallery';
		$viewname			= $this->baseform_model->isMobile() ? array('default' => array('mobile/board/listform/listform_gallery_view')) : 
									 					  		  array('default' => array('listform_view', 'partition/listform/listform_gallery_view'));

		$this->board_model->showBoard($dbname, $mode, $index, array('thumbnail' => true, 
																	'viewname' => $viewname, 
																	'pagetab' => array('maxTabs' => 10, 'maxViews' => 8)));
	}
}