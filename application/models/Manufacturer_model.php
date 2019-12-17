<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer_model extends CI_Model {

	function __construct() {

		parent::__construct();
	}

	public function gets() {

		$this->db->trans_start();
		$sql			= "SELECT * FROM manufacturer";
		$query			= $this->db->query($sql);
		$this->db->trans_complete();

		return $query->result_array();
	}
}