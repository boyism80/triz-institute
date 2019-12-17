<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'core/exceptions/RequireLoginException.php';
include_once APPPATH . 'core/exceptions/NoPrivilegeException.php';

class Comment_model extends CI_Model {

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
		$this->load->model('member_model');
		$this->load->model('board_model');
		$this->load->model('baseform_model');
	}

	public function exists($index) {

		$this->db->trans_start();
		$sql				= "SELECT * FROM comment WHERE idx = $index AND deleted = 0";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			return false;

		return true;
	}

	private function comment_filter_recursive($src, $parent, &$array, $level = 0) {

		$linear				= array();
		foreach($src as $element) {

			if($element['parent'] != $parent)
				continue;

			array_push($linear, $element);
		}

		foreach($linear as $current) {

			$current['level'] = $level;
			array_push($array, $current);
			$this->comment_filter_recursive($src, $current['idx'], $array, $level + 1);
		}

		return $array;
	}

	private function comment_sort($src) {

		$root				= array();
		$root				= $this->comment_filter_recursive($src, null, $root);

		return $root;
	}

	public function gets($bindex) {

		$this->db->trans_start();
		$sql				= "SELECT * FROM comment WHERE bindex = $bindex";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		$user 				= $this->session->userdata('user');

		$rows				= $query->result_array();
		for($i = 0; $i < count($rows); $i++) {

			$rows[$i]['own']			= ($user != null && ($user['idx'] == intval($rows[$i]['user'])));
			$rows[$i]['deleted']		= intval($rows[$i]['deleted']) ? true : false;

			$rows[$i]['user']			= $this->member_model->index2Name($rows[$i]['user']);
			if($rows[$i]['deleted'])
				$rows[$i]['content']	= '삭제된 댓글입니다.';
		}

		$rows 				= $this->comment_sort($rows);
		return $rows;
	}

	public function add($bindex, $content, $parent = null) {

		$user 				= $this->session->userdata('user');
		if($user == false)
			throw new RequireLoginException();

		if($this->board_model->existsBoard($bindex) == false)
			throw new Exception('존재하지 않는 게시물입니다. : ' . json_encode($bindex));

		if(mb_strlen($content) == 0)
			throw new Exception('내용을 입력하세요.');

		$userIndex 			= $user['idx'];
		$currentDateTime	= date("Y-m-d H:i:s");
		$this->db->trans_start();
		if($parent != null)
			$sql			= "INSERT INTO comment (bindex, user, content, parent, date) VALUES ($bindex, $userIndex, '$content', $parent, '$currentDateTime')";
		else
			$sql			= "INSERT INTO comment (bindex, user, content, date) VALUES ($bindex, $userIndex, '$content', '$currentDateTime')";
		$query				= $this->db->query($sql);
		$commetIndex		= $this->db->insert_id();
		$this->db->trans_complete();

		return $commetIndex;
	}

	public function delete($index) {

		if($this->exists($index) == false)
			throw new Exception('존재하지 않는 댓글입니다.');

		$user 				= $this->session->userdata('user');
		if($user == false)
			throw new RequireLoginException();

		$userIndex 			= $user['idx'];
		$this->db->trans_start();
		$sql				= "UPDATE comment SET deleted = 1 WHERE user = $userIndex AND idx = $index AND deleted = 0";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();
	}

	public function modify($index, $content) {

		if($this->exists($index) == false)
			throw new Exception('존재하지 않는 댓글입니다.');

		$user 				= $this->session->userdata['user'];
		if($user == false)
			throw new RequireLoginException();

		$userIndex 			= $user['idx'];
		$this->db->trans_start();
		$sql				= "UPDATE comment SET content = '$content' WHERE user = $userIndex AND idx = $index AND deleted = 0";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();
	}

	public function update($bindex) {

		$ret 				= '';
		$comments			= $this->comment_model->gets($bindex);
		$commentViewName	= $this->baseform_model->isMobile() ? 'mobile/board/readform/readform_comment_element_view' : 'partition/readform/readform_comment_element_view';
		foreach($comments as $comment)
			$ret 		 	.= $this->load->view($commentViewName, array('comment' => $comment), true);

		return $ret;
	}
}