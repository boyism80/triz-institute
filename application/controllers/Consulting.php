<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consulting extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('board_model');
		$this->load->model('comment_model');
		$this->load->model('baseform_model');
	}

	public function index() {

		$this->howto();
	}

	public function howto() {

		$customViews = array('consulting/howto_view');
		$this->baseform_model->loadView($customViews, null, null);
	}

	public function algorithm () {

		$customViews = array('consulting/algorithm_view');
		$this->baseform_model->loadView($customViews, null, null);
	}

	public function advice () {

		$dbname				= 'advice';
		$mode 				= $this->input->get('mode', true);
		$index 				= $this->input->get('index', true);

		$this->board_model->showBoard($dbname, $mode, $index);
	}
}