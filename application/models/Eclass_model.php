<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'core/exceptions/NoCertificateException.php';

class Eclass_model extends CI_Model {

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
        $this->load->model('board_model');
        $this->load->model('member_model');
    }

    private function existsLecture($lindex) {

        $this->db->trans_start();
        $sql                = "SELECT idx FROM lecture_info WHERE idx = $lindex AND deleted = 0 LIMIT 1";
        $query              = $this->db->query($sql);
        $this->db->trans_complete();

        return $query->num_rows() != 0;
    }

    private function createDefaultBoards($name) {

        $ret                = array();
        $ret['notice']      = $this->board_model->addBoard($name . '_notice', '공지사항', 1, -1);
        $ret['lecture']     = $this->board_model->addBoard($name . '_lecture', '과제', 1, -1);
        $ret['reference']   = $this->board_model->addBoard($name . '_reference', '자료실', 1, -1);

        return $ret;
    }

    public function exists($name) {

        $name               = preg_replace('/\s+/', '', $name);
        $this->db->trans_start();
        $sql                = "SELECT name FROM eclass WHERE name = '$name' AND deleted = 0";
        $query              = $this->db->query($sql);
        $this->db->trans_complete();

        return $query->num_rows() != 0;
    }

    public function add($title, $name, $pw) {

        if($title == null || mb_strlen($title) == 0)
            throw new Exception('과목 이름을 입력하세요.');

        if($name == null || mb_strlen($name) == 0)
            throw new Exception('URL 태그를 입력하세요.');

        if($pw == null || mb_strlen($pw) == 0)
            throw new Exception('비밀번호를 입력하세요.');

        if(mb_strlen($name) > 32)
            throw new Exception('URL 태그는 최대 32글자까지 입력할 수 있습니다.');

        $name               = preg_replace('/\s+/', '', $name);
        if($this->exists($name))
            throw new Exception('이미 존재하는 URL 태그입니다.');

        $defBoards          = $this->createDefaultBoards($name);
        $pw                 = md5($this->db->escape($pw));

        $this->db->trans_start();
        $sql                = sprintf( "INSERT INTO eclass (name, title, pw, notice, lecture, reference, date) 
                                        VALUES ('%s', '%s', '%s', %d, %d, %d, '%s')",
                                        $name, $title, $pw, $defBoards['notice'], $defBoards['lecture'], $defBoards['reference'], date("Y-m-d H:i:s"));
        $query              = $this->db->query($sql);
        $this->db->trans_complete();

        return true;
    }

    public function gets () {

        $this->db->trans_start();
        $sql                    = "SELECT date, deleted, lecture, name, notice, reference, title FROM eclass WHERE deleted = 0 ORDER BY date DESC";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();

        return $query->result_array();
    }

    private function isCertificateByLectureIndex($lindex) {

        $this->db->trans_start();
        $sql                    = "SELECT bindex FROM lecture_info WHERE idx = $lindex AND deleted = 0";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();
        if($query->num_rows() == 0)
            throw new Exception($sql);
        $row                    = $query->row_array();


        $boardIndex             = $row['bindex'];
        $this->db->trans_start();
        $sql                    = "SELECT btype FROM boards WHERE idx = $boardIndex AND deleted = 0";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();
        if($query->num_rows() == 0)
            throw new Exception($sql);

        $row                    = $query->row_array();

        $boardType              = $row['btype'];
        $this->db->trans_start();
        $sql                    = "SELECT name FROM eclass WHERE lecture = $boardType AND deleted = 0 LIMIT 1";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();
        if($query->num_rows() == 0)
            throw new Exception($sql);

        $row                    = $query->row_array();
        $name                   = $row['name'];
        return $this->isCertificate($name);
    }

    public function isCertificate($name) {

        $user                   = $this->session->userdata('user');
        if($user == null)
            throw new RequireLoginException();

        if($user['admin'] === true)
            return true;

        $certifMap              = $this->session->userdata('ec_certifmap');
        if($certifMap == null)
            $certifMap          = array();

        if(isset($certifMap[$name]) == false || $certifMap[$name] != true)
            return false;

        return true;
    }

    public function certificate($name, $pw) {

        $certifMap              = $this->session->userdata('ec_certifmap');
        if($certifMap == null)
            $certifMap          = array();

        $pw                     = md5($this->db->escape($pw));
        $this->db->trans_start();
        $sql                    = "SELECT pw FROM eclass WHERE name = '$name' AND pw = '$pw' AND deleted = 0";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();

        if($query->num_rows() == 0)
            return false;

        $certifMap[$name]       = true;
        $this->session->set_userdata('ec_certifmap', $certifMap);
        return true;
    }

    public function board ($name, $bname, $count = null) {

        if($this->isCertificate($name) == false)
            throw new NoCertificateException();

        $this->db->trans_start();
        $sql                    = "SELECT $bname FROM eclass WHERE name = '$name' AND deleted = 0 LIMIT 1";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();

        $row                    = $query->row_array();
        $noticeIndex            = intval($row[$bname]);

        return $this->board_model->gets($noticeIndex, $count);
    }

    private function isValidLectureData($submitDate, $limitDate, $score) {

        $ret                        = array('success' => true);
        try {
            $user                   = $this->session->userdata('user');
            if($user == null || $user['admin'] === false)
                throw new Exception('관리자가 아닙니다.');

            if($submitDate == null || mb_strlen($submitDate) == 0)
                throw new Exception('마감일을 설정하세요.');

            if($score == null || mb_strlen($score) == 0)
                throw new Exception('점수를 입력하세요.');

            if(is_numeric($score) == false)
                throw new Exception('잘못된 점수입니다.');

            $currentDate            = new DateTime();
            $submitDate             = new DateTime($submitDate);
            if($currentDate >= $submitDate)
                throw new Exception('마감일은 현재시각 이후의 시간만 입력이 가능합니다.');

            if($limitDate != null && $submitDate >= new DateTime($limitDate))
                throw new Exception('최종마감일은 마감일 이후의 시간만 입력이 가능합니다.');
        } catch (Exception $e) {
            
            $ret['success']         = false;
            $ret['error']           = $e->getMessage();
        }

        return $ret;
    }

    public function addLecture($submitDate, $limitDate, $score, $bindex) {

        // Request user's privilege

        $valid                  = $this->isValidLectureData($submitDate, $limitDate, $score);
        if($valid['success'] == false)
            throw new Exception($valid['error']);

        $submitDate             = new DateTime($submitDate);
        $this->db->trans_start();
        if($limitDate != null) {
            $limitDate          = new DateTime($limitDate);
            $sql                = sprintf("INSERT INTO lecture_info (submit_date, limit_date, score, bindex) VALUES ('%s', '%s', %d, %d)",  $submitDate->format('Y-m-d H:i:s'),
                                                                                                                                            $limitDate->format('Y-m-d H:i:s'),
                                                                                                                                            $score, $bindex);
        }
        else {
            $sql                = sprintf("INSERT INTO lecture_info (submit_date, score, bindex) VALUES ('%s', %d, %d)", $submitDate->format('Y-m-d H:i:s'), $score, $bindex);
        }

        $query                  = $this->db->query($sql);
        $lectureIndex           = $this->db->insert_id();
        $this->db->trans_complete();

        return $lectureIndex;
    }

    public function getLecture($bindex) {

        // Request user's privilege

        $this->db->trans_start();
        $sql                    = "SELECT * FROM lecture_info WHERE bindex = $bindex AND deleted = 0 LIMIT 1";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();

        if($query->num_rows() == 0)
            throw new Exception('데이터가 없습니다.');

        $row                    = $query->row_array();
        $lindex                 = $row['idx'];

        if($this->isCertificateByLectureIndex($lindex) == false)
            throw new NoCertificateException();

        return $row;
    }

    private function getLectureFiles($lindex, $userIndex = null) {

        if($this->isCertificateByLectureIndex($lindex) == false)
            throw new NoCertificateException();

        $user                   = $this->session->userdata('user');
        if($user == null) {

            return null;
        } else if($user['admin'] === false) {

            $userIndex          = $user['idx'];
            $this->db->trans_start();
            $sql                = "SELECT * FROM lecture_files WHERE lindex = $lindex AND user = $userIndex";
        } else if($userIndex != null) {

            $this->db->trans_start();
            $sql                = "SELECT * FROM lecture_files WHERE lindex = $lindex AND user = $userIndex";
        } else {

            $this->db->trans_start();
            $sql                = "SELECT * FROM lecture_files WHERE lindex = $lindex";
        }

        $query                  = $this->db->query($sql);
        $this->db->trans_complete();
        $rows                   = $query->result_array();

        for($i = 0; $i < count($rows); $i++) {

            $rows[$i]['size']   = filesize($rows[$i]['path']);
            $rows[$i]['url']    = base_url() . $rows[$i]['path'];
        }

        return $rows;
    }

    public function getLectureData($lindex) {

        if($this->isCertificateByLectureIndex($lindex) == false)
            throw new NoCertificateException();

        $user                   = $this->session->userdata('user');

        if($user == null) {

            throw new RequireLoginException();
        } else if($user['admin'] === false) {

            $userIndex          = $user['idx'];
            $this->db->trans_start();
            $sql                = "SELECT * FROM lecture_submit WHERE lindex = $lindex AND user = $userIndex AND deleted = 0 LIMIT 1";
            $query              = $this->db->query($sql);
            $this->db->trans_complete();

            if($query->num_rows() == 0)
                return null;

            $row                = $query->row_array();
            $row['files']       = $this->getLectureFiles($lindex);
            return $row;
        } else {

            $this->db->trans_start();
            $sql                = "SELECT * FROM lecture_submit WHERE lindex = $lindex AND deleted = 0";
            $query              = $this->db->query($sql);
            $this->db->trans_complete();

            $rows               = $query->result_array();

            for($i = 0; $i < count($rows); $i++) {

                $rows[$i]['uname']  = $this->member_model->index2Name($rows[$i]['user']);
                $rows[$i]['uid']    = $this->member_model->index2Id($rows[$i]['user']);
                $rows[$i]['files']  = $this->getLectureFiles($lindex, $rows[$i]['user']);
            }

            return $rows;
        }
    }

    public function submitable($lindex) {

        if($this->isCertificateByLectureIndex($lindex) == false)
            throw new NoCertificateException();

        $this->db->trans_start();
        $sql                    = "SELECT * FROM lecture_info WHERE idx = $lindex AND deleted = 0 LIMIT 1";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();

        $lectureRow             = $query->row_array();
        $submitDate             = $lectureRow['submit_date'];
        if($lectureRow['limit_date'] != null)
            $submitDate         = $lectureRow['limit_date'];

        $currentDate            = new DateTime();
        $submitDate             = new DateTime($submitDate);
        return $currentDate <= $submitDate;
    }

    public function submitLecture($lindex, $content, $files) {

        if($this->isCertificateByLectureIndex($lindex) == false)
            throw new NoCertificateException();

        if($this->existsLecture($lindex) == false)
            throw new Exception('접근할 수 없습니다.');

        $user                   = $this->session->userdata('user');
        if($user == null) // + session
            throw new RequireLoginException();

        if($user['admin'] === true)
            throw new Exception('회원 전용 메뉴입니다.');

        if($content == null || mb_strlen($content) == 0)
            throw new Exception('내용을 입력하세요.');

        $userIndex              = $user['idx'];
        $this->db->trans_start();
        $sql                    = "SELECT * FROM lecture_submit WHERE lindex = $lindex AND user = $userIndex AND deleted = 0 LIMIT 1";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();

        if($this->submitable($lindex) == false)
            throw new Exception('제출기간이 지났습니다.');


        // Register or update DB
        $currentDateTime        = date("Y-m-d H:i:s");
        $this->db->trans_start();
        if($query->num_rows() != 0)
            $sql            = "UPDATE lecture_submit SET content = '$content', date = '$currentDateTime' WHERE lindex = $lindex AND user = $userIndex LIMIT 1";
        else
            $sql            = "INSERT INTO lecture_submit (lindex, user, content, date) VALUES ($lindex, $userIndex, '$content', '$currentDateTime')";
        $query              = $this->db->query($sql);
        $submitIndex        = $this->db->insert_id();
        $this->db->trans_complete();

        // Update files
        $sql                = "DELETE FROM lecture_files WHERE lindex = $lindex AND user = $userIndex";
        $this->db->query($sql);
        if($files != null) {
            foreach($files as $file) {

                $fileTitle      = $file['title'];
                $filePath       = $file['path'];
                $sql            = "INSERT INTO lecture_files (lindex, user, title, path) VALUES ($lindex, $userIndex, '$fileTitle', '$filePath')";
                $query          = $this->db->query($sql);
            }
        }

        return $submitIndex;
    }

    private function inspectEvaluation($index, $score) {

        $this->db->trans_start();
        $sql                    = "SELECT lindex FROM lecture_submit WHERE idx = $index AND deleted = 0";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();
        
        if($query->num_rows() == 0)
            throw new Exception('제출한 과제가 없습니다.');

        $row                    = $query->row_array();
        $lindex                 = intval($row['lindex']);

        if($this->existsLecture($lindex) == false)
            throw new Exception('접근할 수 없습니다.');

        $user                   = $this->session->userdata('user');
        if($user == null) // + session
            throw new RequireLoginException();

        if($user['admin'] === false)
            throw new NoPrivilegeException();

        if($score == null || mb_strlen($score) == 0)
            throw new Exception('점수를 입력하세요.');

        $this->db->trans_start();
        $sql                    = "SELECT * FROM lecture_info WHERE idx = $lindex AND deleted = 0";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();
        if($query == false)
            throw new Exception($sql);

        $row                    = $query->row_array();
        $maxScore               = intval($row['score']);
        $score                  = intval($score);

        if($score > $maxScore)
            throw new Exception($maxScore . '점 이하로 입력하세요.');

        if($score < 0)
            throw new Exception('점수를 정확히 입력하세요.');

        return true;
    }

    public function evaluate($index, $score, $comment) {

        $user                   = $this->session->userdata('user');
        if($user['admin'] === false)
            throw new Exception('관리자가 아닙니다.');

        if(is_numeric($score) === false)
            throw new Exception('정확한 점수를 입력하세요.');
        
        $index                  = intval($index);

        // GET LINDEX WITH INDEX
        $this->inspectEvaluation($index, $score);

        $this->db->trans_start();
        $sql                    = "UPDATE lecture_submit SET score = $score, comment = '$comment' WHERE idx = $index AND deleted = 0 LIMIT 1";
        $query                  = $this->db->query($sql);
        $this->db->trans_complete();

        return array('index' => $index, 'score' => $score, 'comment' => $comment);
    }

    public function modify($lindex, $binfo, $linfo) {

        $valid                  = $this->isValidLectureData($linfo['submit_date'], $linfo['limit_date'], $linfo['score']);
        if($valid['success'] == false)
            throw new Exception($valid['error']);

        $sql                    = "SELECT bindex FROM lecture_info WHERE idx = $lindex AND deleted = 0 LIMIT 1";
        $query                  = $this->db->query($sql);

        $row                    = $query->row_array('bindex');
        $bindex                 = intval($row['bindex']);

        $sql                    = "SELECT btype FROM boards WHERE idx = $bindex LIMIT 1";
        $query                  = $this->db->query($sql);

        $row                    = $query->row_array();
        $btype                  = intval($row['btype']);

        $this->board_model->modify($btype, $bindex, $binfo['title'], $binfo['content'], $binfo['files'], null, $binfo['fix']);


        if($linfo['limit_date'] === '')
            $linfo['limit_date'] = null;

        $whereSet               = array('idx' => $lindex, 'deleted' => 0);
        $this->db->update('lecture_info', $linfo, $whereSet);

        return $this->db->last_query();
    }
}