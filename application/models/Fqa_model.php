<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fqa_model extends CI_Model {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    function __construct() {

        parent::__construct();
    }

    public function gets() {

        $sql                = "SELECT * FROM fqa WHERE deleted = 0 ORDER BY idx DESC";
        $query              = $this->db->query($sql);
        if($query == false)
            throw new Exception($sql);

        $rows               = $query->result_array();
        return $rows;
    }

    public function add($question, $answer) {

        $sql                = "INSERT INTO fqa (question, answer) VALUES ('$question', '$answer')";
        $query              = $this->db->query($sql);
        if($query == false)
            throw new Exception($sql);

        return $this->db->insert_id();
    }

    public function delete($index) {

        $sql                = "UPDATE fqa SET deleted = 1 WHERE idx = $index LIMIT 1";
        $query              = $this->db->query($sql);
        if($query == false)
            throw new Exception($sql);

        return true;
    }
}