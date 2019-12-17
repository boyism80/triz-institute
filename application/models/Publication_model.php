<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/exceptions/RequireLoginException.php';
include_once APPPATH . 'core/exceptions/NoPrivilegeException.php';

class Publication_model extends CI_Model {

	private $_searchopt			= array(array('text' => '도서명', 'type' => 'name'),
										array('text' => '출판사', 'type' => 'publisher'),
										array('text' => '저자', 'type' => 'writer'));
	private $_pageMaxView		= 8;

	function __construct() {

		parent::__construct();
	}

	private function getsDefault($page) {

		if($page < 1)
			throw new Exception("잘못된 접근입니다. : " . $page);

		// Get data
		$offset					= ($page-1) * $this->_pageMaxView;
		$this->db->trans_start();
		$sql					= "SELECT * FROM publication WHERE deleted = 0 ORDER BY idx DESC LIMIT $offset, $this->_pageMaxView";
		$query					= $this->db->query($sql);
		$this->db->trans_complete();
		$data 					= $query->result_array();

		// Get total count
		$this->db->trans_start();
		$sql					= "SELECT * FROM publication WHERE deleted = 0";
		$query					= $this->db->query($sql);
		$this->db->trans_complete();		
		$count 					= $query->num_rows();
		return array('data' => $data, 'count' => $count);
	}

	private function getsFromName($name) {

		return "name LIKE '%$name%'";
	}

	private function getsFromPublisher($publisher) {

		return "publisher LIKE '%$publisher%'";
	}

	private function getsFromWriter($writer) {

		return "writer LIKE '%$writer%'";
	}

	public function searchopt() {

		return $this->_searchopt;
	}

	public function pageMaxView() {

		return $this->_pageMaxView;
	}

	public function get($index) {

		# Get software product data
		$this->db->trans_start();
		$sql					=  "SELECT idx, name, subtitle, writer, publisher, toc, intro, pubreview, page, price, ISBN, url, deleted, DATE(pubdate) as pubdate 
									FROM publication 
									WHERE idx = $index AND deleted = 0";
		$query					= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception("존재하지 않는 제품입니다.");

		$ret 					= $query->row_array();

		# Append software thumbnails
		$this->db->trans_start();
		$sql					= "SELECT * FROM publication_thumb WHERE pidx = $index AND deleted = 0";
		$query					= $this->db->query($sql);
		$this->db->trans_complete();


		$ret['thumb']			= array();
		foreach($query->result_array() as $row)
			array_push($ret['thumb'], base_url() . $row['path']);

		$ret['idx']				= intval($ret['idx']);
		$ret['page']			= intval($ret['page']);
		$ret['price']			= intval($ret['price']);
		$ret['ISBN']			= intval($ret['ISBN']);
		$ret['deleted']			= (boolean)$ret['deleted'];

		return $ret;
	}

	public function gets($keyword, $searchType, $page = 1) {

		$ret 					= array();
		$page 					= max(intval($page), 1);

		$this->db->trans_start();
		$sql					= "SELECT * FROM publication WHERE deleted = 0";
		switch($searchType) {

			case 'name':
			$sql				.= " AND " . $this->getsFromName($keyword);
			break;

			case 'publisher':
			$sql				.= " AND " . $this->getsFromPublisher($keyword);
			break;

			case 'writer':
			$sql				.= " AND " . $this->getsFromWriter($keyword);
			break;
		}

		// Get total count
		$query					= $this->db->query($sql);
		$count 					= count($query->result_array());


		// Get data
		$offset					= ($page-1) * $this->_pageMaxView;
		$sql					.= " ORDER BY idx DESC LIMIT $offset, $this->_pageMaxView";
		$query 					= $this->db->query($sql);
		$this->db->trans_complete();
		$rows 					= $query->result_array();

		

		// Append each thumbnail of publication
		$this->db->trans_start();
		for($i = 0; $i < count($rows); $i++) {

			$publicIndex 		= $rows[$i]['idx'];
			$sql				= "SELECT path FROM publication_thumb WHERE pidx = $publicIndex AND deleted = 0 LIMIT 1";
			$query				= $this->db->query($sql);

			if($query == false)
				continue;

			$row 				= $query->row_array();
			$rows[$i]['thumb']	= base_url() . $row['path'];
		}
		$this->db->trans_complete();

		return array('data' => $rows, 'count' => $count);
	}
}