<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

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
		$this->load->model('file_model');
	}

	public function upload($path = null) {

		$ret 						= array('success' => true);
		$directory					= 'assets/uploads/';
		try {

			$fileinfo				= $this->file_model->upload('userfile', $path, $directory . $path);
			if($fileinfo == null)
				throw new Exception('파일이 존재하지 않습니다.');


			$ret['data']			= array();
			foreach($fileinfo as $info) {

				array_push($ret['data'], $info);
			}
		} catch(Exception $e) {

			$ret['success']			= false;
			$ret['error']			= $e->getMessage();
		}

		echo json_encode($ret);
	}
}