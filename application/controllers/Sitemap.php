<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('category_model');
		$this->load->model('baseform_model');
	}

	public function index() {

		$customViews		= array('sitemap/sitemap_view');
		$mobileViews		= array('mobile/sitemap/sitemap_view');
		$parameters			= array('menu' => $this->category_model->gets(true, false));
		$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
	}
}