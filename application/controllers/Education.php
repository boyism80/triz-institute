<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Education extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('baseform_model');
	}

	public function index() {

		$this->level1();
	}

	public function level1() {

		$customViews 			= array('education/level1_view');
		$this->baseform_model->loadView($customViews);
	}

	public function level2() {

		$customViews 			= array('education/level2_view');
		$this->baseform_model->loadView($customViews);
	}

	public function level3() {

		$customViews 			= array('education/level3_view');
		$this->baseform_model->loadView($customViews);
	}

	public function creative () {

		$customViews 			= array('education/creative_view');
		$this->baseform_model->loadView($customViews);
	}
}