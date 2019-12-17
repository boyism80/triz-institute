<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model('category_model');
		$this->load->model('board_model');
	}

	public function index()
	{
		$parameters				= array();
		$parameters['menu']		= json_encode($this->category_model->gets());

		$board 					= array();
		$board['notice']		= $this->board_model->gets('notice', 5);
		$board['community']		= $this->board_model->gets('community-room', 5);
		$board['gallery']		= $this->board_model->gets('gallery', 5);
		$parameters['board']	= json_encode($board);

		if($this->agent->is_mobile()) {

			$this->load->view('mobile/home_view', array('menu' => $this->category_model->gets(true, true)));
		} else {

			$this->load->view('home/home_view', $parameters);
			$this->load->view('home/footer_view.php');
		}
	}
}
