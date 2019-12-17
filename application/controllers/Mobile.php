<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

	private $historyXML		= 'assets/xml/history.xml';
	private $menu;

	function __construct() {

		parent::__construct();

		$this->load->model('category_model');
		$this->load->model('member_model');

		$this->menu			= json_encode($this->category_model->gets());
	}

	public function index() {

		$this->load->view('mobile/home_view', array('menu' => $this->category_model->gets(true, true)));
	}

	public function login() {

		$this->load->view('mobile/member/login_view');
	}

	public function intro() {

		$this->load->view('mobile/intro/greeting_view', array('currentTab' => $this->category_model->current()));
	}

	public function history() {

		$this->load->view('mobile/intro/history_view', array('currentTab' => $this->category_model->current(), 'history' => $this->getHistory()));
	}

	private function getHistory() {

		if(file_exists($this->historyXML) == false)
			return null;

		$xml 				= simplexml_load_file($this->historyXML);
		return $xml;
	}

	public function complete() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/member/signin/complete_view', $parameters);
	}

	public function inquiry() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/member/inquiry_view', $parameters);
	}

	public function enterprise() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/enterprise/home_view', $parameters);
	}

	public function location() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/intro/location_view', $parameters);
	}

	public function trainexp() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/enterprise/trainexp_view', $parameters);
	}

	public function supply() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/enterprise/supply_view', $parameters);
	}

	public function consulting() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/enterprise/consulting_view', $parameters);
	}

	public function creative() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/enterprise/creative_view', $parameters);
	}

	public function publishing() {

		$parameters			= array('currentTab' => $this->category_model->current());
		$this->load->view('mobile/enterprise/publishing_view', $parameters);
	}

	public function readform() {

		$index 				= $this->input->get('index', true);
		$mode 				= $this->input->get('mode', true);
		$dbname				= 'notice';

		$this->load->model('board_model');		
		$this->board_model->showBoard($dbname, $mode, $index);
	}
}