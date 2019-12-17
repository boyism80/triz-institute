<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {

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
		$this->load->model('comment_model');
	}

	public function gets() {

		$ret 				= array('success' => true);
		try {

			$bindex			= $this->input->post('bindex');
			$ret['data']	= $this->comment_model->gets($bindex);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function add() {

		$ret 				= array('success' => true);
		try {

			$content		= $this->input->post('content');
			$bindex			= $this->input->post('bindex');
			$parent			= $this->input->post('parent');

			if($parent == false)		$parent = null;

			$this->comment_model->add($bindex, $content, $parent);
			$ret['data']	= $this->comment_model->update($bindex);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function delete () {

		$ret 				= array('success' => true);
		try {

			$index 			= $this->input->post('index');
			$bindex			= $this->input->post('bindex');

			$this->comment_model->delete($index);
			$ret['data']	= $this->comment_model->update($bindex);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function modify () {

		$ret 				= array('success' => true);
		try {

			$index 			= $this->input->post('index');
			$bindex			= $this->input->post('bindex');
			$content		= $this->input->post('content');

			$this->comment_model->modify($index, $content);
			$ret['data']	= $this->comment_model->update($bindex);
		} catch(Exception $e) {

			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function ibox() {

		$ret 				= array('success' => true);

		try {
			
			$index 			= $this->input->post('index');
			$user 			= $this->session->userdata('user');
			$ret['data']	= $this->load->view('partition/readform/readform_input_comment_view', array('user' => $user, 'target' => $index), true);
		} catch (Exception $e) {
			
			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function mbox() {

		$ret 				= array('success' => true);

		try {

			$index 			= $this->input->post('index');
			$user 			= $this->session->userdata('user');
			$uidx			= $user['idx'];

			$sql			= "SELECT content FROM comment WHERE idx = $index AND user = $uidx AND deleted = 0";
			$query			= $this->db->query($sql);
			if($query->num_rows() == 0)
				throw new Exception('잘못된 접근입니다.');

			$row 			= $query->row_array();
			$content		= $row['content'];
			$ret['data']	= $this->load->view('partition/readform/readform_modify_comment_view', array('user' => $user, 'content' => $content, 'target' => $index), true);
		} catch (Exception $e) {
			
			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}

	public function update() {

		$ret 				= array('success' => true);

		try {

			$bindex			= $this->input->post('bindex');
			$ret['data']	= $this->comment_model->update($bindex);
			
		} catch (Exception $e) {
			
			$ret['success']	= false;
			$ret['error']	= $e->getMessage();
		}

		echo json_encode($ret);
	}
}