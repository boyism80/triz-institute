<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Baseform_model extends CI_Model {

	function __construct() {

		parent::__construct();
		$this->load->model('category_model');
	}

	public function loadView($customViews, $mobileCustomViews = null, $parameters = null) {

		try {

			$current 			= $this->category_model->current();

			if($this->category_model->isFiltered($current['item'], false))
				throw new Exception();

			if($this->category_model->isFiltered($current['active'], false))
				throw new Exception();

			$baseformView		= $this->isMobile() ? 'mobile/baseform_view' : 'baseform_view';

			if($parameters == null)
				$parameters		= array();

			$parameters['currentTab']	= $this->category_model->current();
			$parameters['customViews']	= $customViews;

			if($this->isMobile()) {

				if($mobileCustomViews != null)
					$parameters['customViews']		= $mobileCustomViews;

				$this->load->view($baseformView, $parameters);
			} else {

				$this->load->view('header_view', array('menu' => $this->category_model->gets()));
				$this->load->view($baseformView, $parameters);
				$this->load->view('footer_view');
			}
		} catch (Exception $e) {
			
			echo '<script type="text/javascript">history.back();</script>';
		}
	}

	public function isMobile() {

		// return $this->input->get('desktop') == false;
		return $this->agent->is_mobile();
	}
}