<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/exceptions/RequireLoginException.php';
include_once APPPATH . 'core/exceptions/NoPrivilegeException.php';

class Admin_model extends CI_Model {

    private $adminEmail = 'admin@triz.kr';

    function __construct() {

        parent::__construct();

        $this->load->library('email');
    }

    // $nameRow, $emailRow : 'A' ~ 'Z'
    private function extractEmailListFromExcel($excel, $nameRow, $emailRow) {

        $ret            = array();

        $filename       = $excel['tmp_name'];
        $filetype       = PHPExcel_IOFactory::identify($filename);
        $reader         = PHPExcel_IOFactory::createReader($filetype);
        $pexcel         = $reader->load($filename);

        // Get excel sheet
        $sheet          = $pexcel->getSheet(0);
        $maxrow         = $sheet->getHighestRow();
        $maxcol         = $sheet->getHighestColumn();

        // Parse excel file
        for($row = 1; $row < $maxrow; $row++) {

            $item = array('name' => $sheet->getCell($nameRow.$row)->getValue(), 'email' => $sheet->getCell($emailRow.$row)->getValue());
            if($item['name'] == null || $item['email'] == null)
                continue;

            if(strpos($item['email'], '@') === false)
                continue;

            array_push($ret, $item);
        }

        return $ret;
    }

    private function extractEmailListFromMemberDB($filter) {

        $ret            = array();

        $this->db->trans_start();
        $sql            = "SELECT name, email FROM user WHERE recvmail != 0 AND deleted = 0";
        $query          = $this->db->query($sql);

        $this->db->select(array('name', 'email'));
        $this->db->where('recvmail !=', 0);
        $this->db->group_start();
        $this->db->group_start();
        foreach($filter['job'] as $job => $isReceive) {

            if($isReceive == false)
                continue;

            $this->db->or_where('job', $job);
        }
        $this->db->group_end();

        $this->db->group_start();
        foreach($filter['level'] as $level => $isReceive) {

            if($isReceive == false)
                continue;

            $this->db->or_where('level', $level);
        }
        $this->db->group_end();
        $this->db->group_end();

        $query          = $this->db->get('user');
        $this->db->trans_complete();

        foreach ($query->result_array() as $row)
            array_push($ret, array('name' => $row['name'], 'email' => $row['email']));

        return $ret;
    }

    public function sendmail2Excel($data, $excel) {

        $user               = $this->session->userdata('user');
        if($user == null)
            throw new RequireLoginException();

        if($user['admin'] === false)
            throw new NoPrivilegeException();

        if(mb_strlen($data['subject']) == 0)
            throw new Exception('제목을 입력하세요.');

        if(mb_strlen($data['content']) == 0)
            throw new Exception('본문 내용을 입력하세요.');

        if(isset($data['addr']) == true && $excel['error'] != 0)
            throw new Exception('주소록 파일을 첨부하세요.');

        $addrlist           = array();
        if(isset($data['addr']))
            $addrlist = array_merge($addrlist, $this->extractEmailListFromExcel($excel, $data['name_row'], $data['mail_row']));

        if(isset($data['member'])) {

            $filter = array('job'   => array('teaching'   => isset($data['job_teaching']),
                                             'student'    => isset($data['job_student']),
                                             'engineer'   => isset($data['job_engineer']),
                                             'office'     => isset($data['job_office']),
                                             'executive'  => isset($data['job_executive']),
                                             'other'      => isset($data['job_other'])), 
                            'level' => array('none'       => isset($data['level_none']),
                                             'level1'     => isset($data['level1']),
                                             'level2'     => isset($data['level2']),
                                             'level3'     => isset($data['level3']),
                                             'level4'     => isset($data['level4']),
                                             'level5'     => isset($data['level5'])));
            $addrlist       = array_merge($addrlist, $this->extractEmailListFromMemberDB($filter));
        }

        if(count($addrlist) == 0)
            throw new Exception('보낼 대상이 없습니다.');

        // Send mail
        for($i = 0; $i < count($addrlist); $i++) {

            $addrlist[$i]['success']    = $this->sendmail($addrlist[$i]['email'], $data['subject'], $data['content']);
            // if($addrlist[$i]['success'] == false)
            //  $addrlist[$i]['error']  = show_error($this->email->print_debugger());
        }

        return $addrlist;
    }

    public function sendmail($to, $subject, $content) {

        $this->email->clear();
        $this->email->subject($subject);
        $this->email->to($to);
        $this->email->from($this->adminEmail, '트리즈혁신연구소');
        $this->email->message($content);

        return $this->email->send();
    }

    public function registerSoftware($name, $manufacturer, $lease7d, $lease30d, $url, $content) {

        if($name == null || mb_strlen($name) == 0)
            throw new Exception('제품명을 입력하세요.');

        if(mb_strlen($name) > 64)
            throw new Exception('제품명은 64자 이내로 입력하세요.');

        if($manufacturer == null || mb_strlen($manufacturer) == 0)
            throw new Exception('제조사를 선택하세요.');

        if(is_numeric($manufacturer) == false)
            throw new Exception('제조사 정보가 올바르지 않습니다.');

        if($lease7d == null || mb_strlen($lease7d) == 0)
            throw new Exception('7일 대여 금액을 입력하세요.');

        if(is_numeric($lease7d) == false)
            throw new Exception('7일 대여 금액을 정확히 입력하세요.');

        if($lease30d == null || mb_strlen($lease30d) == 0)
            throw new Exception('한달 대여 금액을 입력하세요.');

        if(is_numeric($lease30d) == false)
            throw new Exception('한달 대여 금액을 정확히 입력하세요.');

        if($url == null || mb_strlen($url) == 0)
            throw new Exception('URL을 입력하세요.');

        if(filter_var($url, FILTER_VALIDATE_URL) == false)
            throw new Exception('URL 형식이 올바르지 않습니다.');

        if($content == null || mb_strlen($content) == 0)
            throw new Exception('제품 설명을 입력하세요.');

        # Upload thumbnail file
        $this->load->model('file_model');
        $directory                  = 'assets/uploads/';
        $path                       = 'software';
        $finfo                      = $this->file_model->upload('thumb', $path, $directory . $path);
        if(count($finfo) == 0)
            throw new Exception('썸네일 이미지 파일을 선택하세요.');

        $this->db->trans_start();
        $sql                        = "INSERT INTO software_product (name, manuf, lease7d, lease30d, url, content) VALUES('$name', $manufacturer, $lease7d, $lease30d, '$url', '$content')";
        $query                      = $this->db->query($sql);
        // Get software product id
        $id                         = $this->db->insert_id();
        $this->db->trans_complete();


        // Insert thumbnails of software product
        $this->db->trans_start();
        for($i = 0; $i < count($finfo); $i++) {

            $path                   = $finfo[$i]['path'];
            $sql                    = "INSERT INTO software_thumb (product, path) VALUES ($id, '$path')";
            $query                  = $this->db->query($sql);
        }
        $this->db->trans_complete();

        return $id;
    }

    public function registerPublish($name, $publisher, $writer, $price, $publicDate, $page, $isbn, $url, $intro, $toc, $pubReview, $subtitle) {

        if($name == null || mb_strlen($name) == 0)
            throw new Exception('책 이름을 입력하세요.');

        if(mb_strlen($name) > 128)
            throw new Exception('책 이름은 128자 이내로 입력하세요.');

        if($publisher == null || mb_strlen($publisher) == 0)
            throw new Exception('출판사를 입력하세요.');

        if(mb_strlen($publisher) > 64)
            throw new Exception('출판사는 64자 이내로 입력하세요.');

        if($writer == null || mb_strlen($writer) == 0)
            throw new Exception('저자를 입력하세요.');

        if($price == null || mb_strlen($price) == 0)
            throw new Exception('가격을 입력하세요.');

        if(is_numeric($price) == false)
            throw new Exception('올바른 가격을 입력하세요.');

        if($publicDate == null || mb_strlen($publicDate) == 0)
            throw new Exception('출판 날짜를 입력하세요.');

        if($page == null || mb_strlen($page) == 0)
            throw new Exception('페이지를 입력하세요.');

        if(is_numeric($page) == false)
            throw new Exception('올바른 페이지를 입력하세요.');

        if($isbn == null || mb_strlen($isbn) == 0)
            throw new Exception('ISBN을 입력하세요.');

        if(is_numeric($isbn) == false)
            throw new Exception('올바른 ISBN을 입력하세요.');

        if($url == null || mb_strlen($url) == 0)
            throw new Exception('URL을 입력하세요.');

        if(filter_var($url, FILTER_VALIDATE_URL) == false)
            throw new Exception('URL 형식이 올바르지 않습니다.');

        if($intro == null || mb_strlen($intro) == 0)
            throw new Exception('책 소개를 입력하세요.');

        if($toc == null || mb_strlen($toc) == 0)
            throw new Exception('목차를 입력하세요.');

        if($pubReview == null || mb_strlen($pubReview) == 0)
            throw new Exception('출판사 리뷰를 입력하세요.');

        if($subtitle == null || mb_strlen($subtitle) == 0)
            $subtitle       = 'NULL';
        else
            $subtitle       = "'$subtitle'";

        # Upload thumbnail file
        $this->load->model('file_model');
        $directory                  = 'assets/uploads/';
        $path                       = 'publication';
        $finfo                      = $this->file_model->upload('thumb', $path, $directory . $path);
        if(count($finfo) == 0)
            throw new Exception('썸네일 이미지 파일을 선택하세요.');


        $this->db->trans_start();
        $sql                        = "INSERT INTO publication (name, subtitle, writer, publisher, price, pubdate, page, isbn, url, toc, intro, pubreview) 
                                       VALUES('$name', $subtitle, '$writer', '$publisher', $price, '$publicDate', $page, $isbn, '$url', '$toc', '$intro', '$pubReview')";
        $query                      = $this->db->query($sql);
        $id                         = $this->db->insert_id();


        // Insert thumbnails of software product
        for($i = 0; $i < count($finfo); $i++) {

            $path                   = $finfo[$i]['path'];
            $sql                    = "INSERT INTO publication_thumb (pidx, path) VALUES ($id, '$path')";
            $query                  = $this->db->query($sql);
        }
        $this->db->trans_complete();

        return $id;
    }
}