<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class E_learning extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('board_model');
		$this->load->model('baseform_model');
	}

	public function index() {

		$this->basic();
	}

	public function basic() {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'e_triz';

		$viewname			= $this->baseform_model->isMobile() ? array('default' => array('mobile/board/listform/listform_gallery_view')) : 
									 					  		  array('default' => array('listform_view', 'partition/listform/listform_video_view'));

		$this->board_model->showBoard($dbname, $mode, $index, array('thumbnail' => true, 'viewname' => $viewname));
	}

	public function education () {

		$level 				= $this->input->get('level', true);
		if($level == null)
			$level 			= 1;

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'e_level' . $level;
		$viewname			= $this->baseform_model->isMobile() ? array('default' => array('mobile/board/listform/listform_gallery_view')) : 
									 					  		  array('default' => array('listform_view', 'partition/listform/listform_video_view'));

		$this->board_model->showBoard($dbname, $mode, $index, array('thumbnail' => true, 'viewname' => $viewname));
	}

	public function reference () {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'e_reference';

		$this->board_model->showBoard($dbname, $mode, $index);
	}
}