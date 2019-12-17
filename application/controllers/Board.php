<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {

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

		$this->load->model('board_model');
		$this->load->model('comment_model');
	}

	public function privilege() {

		$dbname				= $this->input->post('dbname');
		$ret 				= array('success' => true);

		try {

			$ret['data']	= $this->board_model->privilege($dbname);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function get() {

		$dbname				= $this->input->post('dbname');
		$index 				= $this->input->post('index');

		$ret 				= array('success' => true);

		try {

			// board_model->get 함수를 통해 얻을 때 read 권한에 맞지 않으면 exception 발생
			$ret['data']	= array('board' => $this->board_model->get($dbname, intval($index)),
									'comments' => $this->comment_model->gets($index));

			// 자신의 게시물인지 여부 추가
			// 권한 추가
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function gets() {

		$dbname				= $this->input->post('dbname');
		$offset				= $this->input->post('offset');
		$count 				= $this->input->post('count');
		$keyword			= $this->input->post('keyword');
		$searchType			= $this->input->post('searchType');

		if($offset  		== false)	$offset			= null;
		if($count   		== false)	$count 			= null;
		if($keyword 		== false)	$keyword		= null;
		if($searchType 		== false)	$searchType		= null;


		$ret 				= array('success' => true);

		try {

			$ret['data']	= array('board' => $this->board_model->gets($dbname, $count, $offset, $keyword, $searchType),
									'count' => $this->board_model->count($dbname, $keyword, $searchType));
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function add($btype) {

		$ret 				= array('success' => true);
		try {

			$title 			= $this->input->post('title');
			$content 		= $this->input->post('content');
			$files			= $this->input->post('files');
			$thumbnail		= $this->input->post('thumbnail');
			$fix			= $this->input->post('fix') === 'true' ? true : false;

			$index 			= $this->board_model->add($btype, $title, $content, $files, $thumbnail, $fix);
			$ret['data']	= $index;
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function delete() {

		$ret 				= array('success' => true);
		try {

			$index 			= $this->input->post('index');
			$this->board_model->delete($index);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function modify($btype, $index) {

		$ret 				= array('success' => true);
		try {

			$title 			= $this->input->post('title');
			$content 		= $this->input->post('content');
			$files			= $this->input->post('files');
			$thumbnail		= $this->input->post('thumbnail');
			$fix			= $this->input->post('fix') === 'true' ? true : false;

			$ret['data']	= $this->board_model->modify($btype, $index, $title, $content, $files, $thumbnail, $fix);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}
}