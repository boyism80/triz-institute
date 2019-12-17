<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/exceptions/RequireLoginException.php';
include_once APPPATH . 'core/exceptions/NoPrivilegeException.php';

class Software_model extends CI_Model {

	private $_searchopt			= array(array('text' => '제품명', 'type' => 'name'));
	private $_pageMaxView		= 12;

	function __construct() {

		parent::__construct();
	}

	private function getsFromName($name) {

		return "software_product.name LIKE '%$name%'";
	}

	public function pageMaxView() {

		return $this->_pageMaxView;
	}

	public function searchopt() {

		return $this->_searchopt;
	}

	public function get($index) {

		// Get software product data
		$this->db->trans_start();
		$sql					=  "SELECT software_product.*, manufacturer.name AS manufacturer 
									FROM software_product, manufacturer 
									WHERE software_product.idx = $index AND software_product.manuf = manufacturer.idx AND deleted = 0 LIMIT 1";
		$query					= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception("존재하지 않는 제품입니다.");

		$ret 					= $query->row_array();

		// Append software thumbnails
		$this->db->trans_start();
		$sql					= "SELECT * FROM software_thumb WHERE product = $index AND deleted = 0";
		$query					= $this->db->query($sql);
		$this->db->trans_complete();


		$ret['thumb']			= array();
		foreach($query->result_array() as $row)
			array_push($ret['thumb'], base_url() . $row['path']);

		return $ret;
	}

	public function gets($keyword, $searchType, $page) {

		$this->db->trans_start();
		$sql					=  "SELECT software_product.*, manufacturer.name AS manufacturer 
									FROM software_product, manufacturer 
									WHERE software_product.manuf = manufacturer.idx 
									AND deleted = 0";

		switch($searchType) {

			case 'name':
			$sql 				.= " AND " . $this->getsFromName($keyword);
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

		// Append each thumbnail of software
		$this->db->trans_start();
		for($i = 0; $i < count($rows); $i++) {

			$softwareIndex		= $rows[$i]['idx'];
			$sql				= "SELECT path FROM software_thumb WHERE product = $softwareIndex AND deleted = 0 LIMIT 1";
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