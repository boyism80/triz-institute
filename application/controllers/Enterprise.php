<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enterprise extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('baseform_model');
	}

	public function index() {

		$this->home();
	}

	public function home() {

		$customViews		= array('enterprise/home_view');
		$mobileViews		= array('mobile/enterprise/home_view');

		$this->baseform_model->loadView($customViews, $mobileViews);
	}

	public function supply() {

		$customViews		= array('enterprise/supply_view');
		$mobileViews		= array('mobile/enterprise/supply_view');

		$this->baseform_model->loadView($customViews, $mobileViews);
	}

	public function trainexp() {

		$customViews		= array('enterprise/trainexp_view');
		$mobileViews		= array('mobile/enterprise/trainexp_view');

		$this->baseform_model->loadView($customViews, $mobileViews);
	}

	public function consulting() {

		$customViews		= array('enterprise/consulting_view');
		$mobileViews		= array('mobile/enterprise/consulting_view');

		$this->baseform_model->loadView($customViews, $mobileViews);
	}

	public function creative() {

		$customViews		= array('enterprise/creative_view');
		$mobileViews		= array('mobile/enterprise/creative_view');

		$this->baseform_model->loadView($customViews, $mobileViews);
	}

	public function publishing() {

		$customViews		= array('enterprise/publishing_view');
		$mobileViews		= array('mobile/enterprise/publishing_view');

		$this->baseform_model->loadView($customViews, $mobileViews);
	}
}