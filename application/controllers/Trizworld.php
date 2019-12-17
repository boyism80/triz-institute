<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trizworld extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('baseform_model');
	}

	public function index() {

		$this->intro();
	}

	public function intro() {

		$customViews = array('trizworld/intro_view');
		$this->baseform_model->loadView($customViews);
	}

	public function solution() {

		$customViews = array('trizworld/solution_view');
		$this->baseform_model->loadView($customViews);
	}

	public function development() {

		$customViews = array('trizworld/development_view');
		$this->baseform_model->loadView($customViews);
	}

	public function creativity() {

		$customViews = array('trizworld/creativity_view');
		$this->baseform_model->loadView($customViews);
	}
}