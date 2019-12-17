<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intro extends CI_Controller {

	private $historyXML		= 'assets/xml/history.xml';
	private $expertsXML		= 'assets/xml/experts.xml';

	function __construct() {

		parent::__construct();

		$this->load->model('baseform_model');
	}

	private function getHistory() {

		if(file_exists($this->historyXML) == false)
			return null;

		$xml 				= simplexml_load_file($this->historyXML);
		return $xml;
	}

	private function getExperts() {

		if(file_exists($this->expertsXML) == false)
			return null;

		$xml 				= simplexml_load_file($this->expertsXML);
		$ret 				= array();
		foreach($xml as $group) {

			array_push($ret, $group);

			foreach($group->item as $item)
				$item->attributes()->img = base_url() . $item->attributes()->img;
		}

		return json_encode($ret);
	}

	public function index()
	{
		$this->greeting();
	}

	public function greeting() {

		$customViews 			= array('intro/greeting_view');
		$mobileCustomViews		= array('mobile/intro/greeting_view');

		$this->baseform_model->loadView($customViews, $mobileCustomViews, null);
	}

	public function history() {

		$customViews 			= array('intro/history_view');
		$mobileCustomViews		= array('mobile/intro/history_view');
		$parameters				= array('history' => $this->getHistory());

		$this->baseform_model->loadView($customViews, $mobileCustomViews, $parameters);
	}

	public function organization() {

		$customViews 			= array('intro/organization_view');
		$mobileCustomViews		= null;
		$parameters				= null;

		$this->baseform_model->loadView($customViews, $mobileCustomViews, $parameters);
	}

	public function expert() {

		$customViews 			= array('intro/expert_view');
		$mobileCustomViews		= null;
		$parameters				= array('experts' => $this->getExperts());

		$this->baseform_model->loadView($customViews, $mobileCustomViews, $parameters);
	}

	public function location() {

		$customViews 			= array('intro/location_view');
		$mobileCustomViews		= array('mobile/intro/location_view');
		$parameters				= null;

		$this->baseform_model->loadView($customViews, $mobileCustomViews, $parameters);
	}
}