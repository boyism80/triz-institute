<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onlineshop extends CI_Controller {

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

		$this->load->model('baseform_model');
	}

	public function index() {

		$this->software();
	}

	public function software() {

		try {

			// Load software model
			$index 				= $this->input->get('index');
			$this->load->model('software_model');

			$customViews		= array();
			$parameters			= array();

			// Render contents
			if($index == null) {

				// Post values
				$keyword			= $this->input->get('keyword');
				$searchType			= $this->input->get('searchType');
				$page 				= $this->input->get('page');
				if($page == null)
					$page 			= 1;


				// Set parameters
				$parameters 		= array('softwares' 	=> $this->software_model->gets($keyword, $searchType, $page),
											'keyword' 		=> $keyword,
											'searchType' 	=> $searchType,
											'searchopt' 	=> $this->software_model->searchopt(),
											'page'			=> $page,
											'pagetab'		=> array('maxView' => $this->software_model->pageMaxView()));

				$customViews		= array('online-shop/software_view');
			} else {

				$customViews		= array('online-shop/software_detail_view');
				$parameters['software']	= $this->software_model->get($index);
			}

			$this->baseform_model->loadView($customViews, null, $parameters);

		} catch(Exception $e) {

			echo '<script type="text/javascript"> alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}

	public function publication() {

		try {

			$index 				= $this->input->get('index');
			$this->load->model('publication_model');

			$customViews		= array();
			$parameters			= array();

			if($index == null) {

				// Post values
				$keyword			= $this->input->get('keyword');
				$searchType			= $this->input->get('searchType');
				$page 				= $this->input->get('page');
				if($page == null)
					$page 			= 1;
				

				// Set parameters
				$parameters			= array('publications' 	=> $this->publication_model->gets($keyword, $searchType, $page),
											'searchopt' 	=> $this->publication_model->searchopt(),
											'keyword' 		=> $keyword,
											'searchType' 	=> $searchType,
											'page' 			=> $page,
											'pagetab'		=> array('maxView' => $this->publication_model->pageMaxView()));

				$customViews 		= array('online-shop/publication_view');
				$mobileViews		= array('mobile/online-shop/publication_view');
			} else {

				$parameters['publication']	= $this->publication_model->get($index);
				$customViews 				= array('online-shop/publication_detail_view');
				$mobileViews 				= array('mobile/online-shop/publication_detail_view');
			}

			$this->baseform_model->loadView($customViews, $mobileViews, $parameters);
			
		} catch (Exception $e) {
			
			echo '<script type="text/javascript"> alert("' . $e->getMessage() . '"); history.back(); </script>';
		}
	}
}