<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/exceptions/RequireLoginException.php';
include_once APPPATH . 'core/exceptions/NoPrivilegeException.php';
include_once APPPATH . 'core/exceptions/NoCertificateException.php';

class Board_model extends CI_Model {

	const NEW_DATE_LIMIT = 3;

	private $_searchopt		= array(array('text' => '글제목', 'type' => 'title'),
									array('text' => '작성자', 'type' => 'uname'),
									array('text' => '아이디', 'type' => 'uid'),
									array('text' => '이메일', 'type' => 'email'),
									array('text' => '글내용', 'type' => 'content'));

	private $exceptTagNames	= array('script', 'embed');

	private $mobileTabSize	= 5;
	private $pcTabSize		= 10;

	private $defcount		= 20;
	private $defTabSize		= 0;
	private $defViewSize	= 10;
	private $maxUploadSize	= array();

	function __construct() {

		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('comment_model');
		$this->load->model('file_model');

		$this->maxUploadSize		= array('attach' => 10 * pow(1024, 2), 'image' => 10 * pow(1024, 2), 'video' => 30 * pow(1024, 2));
		$this->defTabSize			= $this->agent->is_mobile() ? $this->mobileTabSize : $this->pcTabSize;
	}


	private function bname2Type($bname) {

		$this->db->trans_begin();
		$sql				= "SELECT idx FROM boardopt WHERE id = '$bname' AND deleted = 0 LIMIT 1";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception($sql);
			// throw new Exception('Cannot find DB : ' . $bname);

		$row 				= $query->row_array();
		$btype				= intval($row['idx']);

		return $btype;
	}

	private function btype2Name($btype) {

		$this->db->trans_begin();
		$sql				= "SELECT id FROM boardopt WHERE idx = $btype AND deleted = 0 LIMIT 1";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception('Cannot find DB : ' . $btype);

		$row 				= $query->row_array();
		$bname				= $row['id'];

		return $bname;
	}

	private function boardGetsState($btype, $offset, $count) {

		$user 				= $this->session->userdata('user');
		$privilege			= $this->inspect($btype, 'read');
		$state				= null;

		// Board type : private board
		if($privilege['private']) {

			if($user == null)
				throw new RequireLoginException();

			$state			= $user['admin'] === true ? 'all' : 'private';
		} else {

			$state			= 'all';
		}

		// Limit boards count
		if($offset != null)
			$state			.= ' -o';

		if($count != null)
			$state			.= ' -c';

		return $state;
	}

	private function addFile($bindex, $title, $path, $ident) {

		if($this->existsBoard($bindex) == false)
			return fasle;

		$this->db->trans_begin();
		$sql 				= "INSERT INTO files (title, path, ident, bindex) VALUES ('$title', '$path', '$ident', $bindex)";
		$query 				= $this->db->query($sql);
		$this->db->trans_complete();

		return true;
	}

	private function getsFromTitle($keyword) {

		return "title LIKE '%$keyword%'";
	}

	private function getsFromUname($uname) {

		$uidx				= $this->member_model->name2Index($uname);

		return "user = $uidx";
	}

	private function getsFromUid($uid) {

		$uidx				= $this->member_model->id2Index($uid);

		return "user = $uidx";
	}

	private function getsFromEmail($email) {

		$uidx				= $this->member_model->email2Index($email);

		return "user = $uidx";
	}

	private function getsFromContent($content) {

		return "content LIKE '%$content%'";
	}

	public function privilege($btype) {

		if(is_string($btype))
			$btype 			= $this->bname2Type($btype);

		$this->db->trans_begin();
		$sql 				= "SELECT * FROM boardopt WHERE idx = $btype AND deleted = 0 LIMIT 1";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception('Cannot find DB : ' . $bname);

		$row 				= $query->row_array();
		$row['rauth']		= intval($row['rauth']);
		$row['wauth']		= intval($row['wauth']);
		if($row['rauth'] == -1)
			$row['rauth']	= 2147483647; // max integer
		if($row['wauth'] == -1)
			$row['wauth']	= 2147483647; // max integer

		$ret 				= array();
		$user 				= $this->session->userdata('user');

		if($user == false) {

			$ret['read']	= ($row['rauth'] === 0) ? true : false;
			$ret['write']	= ($row['wauth'] === 0) ? true : false;
		} else if($user['admin'] === true) {

			$ret['read']	= true;
			$ret['write']	= true;
		} else {
			$ret['read']	= ($user['privilege'] >= $row['rauth']);
			$ret['write']	= ($user['privilege'] >= $row['wauth']);
		}

		if($ret['read'] == false || $ret['write'] == false) {

			if($user == false)
				$ret['exception']	= new RequireLoginException();
			else
				$ret['exception']	= new NoPrivilegeException();
		}

		// Is board private?
		$ret['private']		= (intval($row['private']) != 0) && ($user != false);

		return $ret;
	}

	public function inspect($dbname, $mode = null) {

		if($mode != 'write')
			$mode 			= 'read';

		if(is_integer($dbname))
			$dbname 		= $this->btype2Name($dbname);

		$privilege			= $this->privilege($dbname);
		if($privilege[$mode] == false)
			throw $privilege['exception'];

		return $privilege;
	}

	public function inspectException($e) {

		try {

			echo '<script type="text/javascript">';
			throw $e;
			
		} catch (RequireLoginException $e) {

			echo 'location.href = "' . base_url() . 'member/login';
			echo '?path=' . uri_string() . '";';
			
		} catch (Exception $e) {

			echo 'alert("' . $e->getMessage() . '");';
			echo 'history.back();';
		}
		
		echo '</script>';
	}

	public function exists($btype) {

		if(is_string($btype))
			$btype			= $this->bname2Type($btype);

		$this->db->trans_begin();
		$sql 				= "SELECT * FROM boardopt WHERE idx = $btype AND deleted = 0 LIMIT 1";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			return false;

		return true;
	}

	public function existsBoard($bindex) {

		$this->db->trans_begin();
		$sql 				= "SELECT * FROM boards WHERE idx = $bindex AND deleted = 0 LIMIT 1";
		$query				= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			return false;

		return true;
	}

	public function get($btype, $index) {

		if($this->exists($btype) == false)
			throw new Exception('존재하지 않는 게시판입니다.');

		if($this->existsBoard($index) == false)
			throw new Exception('존재하지 않는 게시글입니다.');

		if(is_string($btype))
			$btype			= $this->bname2Type($btype);

		$privilege				= $this->inspect($btype, 'read');

		// INCREMENT READ VALUE BY 1
		$this->db->trans_begin();
		$sql 				= "UPDATE boards SET hit = hit + 1 WHERE idx = $index";
		$query 				= $this->db->query($sql);

		$sql				= "SELECT boards.idx, boards.title, boards.content, boards.thumbnail, DATE(boards.date) as date, boards.user, boards.fix, boards.hit, user.name as uname
								FROM boards, user
								WHERE boards.idx = $index AND boards.user = user.idx AND boards.deleted = 0 LIMIT 1";
		$query 				= $this->db->query($sql);
		$this->db->trans_complete();
		$row 				= $query->row_array();
		if($privilege['private']) {

			$user 			= $this->session->userdata('user');
			if($user['idx'] != intval($row['user']) && $user['admin'] === false)
				throw new Exception('접근할 수 없습니다.');
		}

		$user 				= $this->session->userdata('user');
		$row['fix']			= (boolean)intval($row['fix']);
		$row['own']			= $user != null && ($user['idx'] == intval($row['user']));
		$row['files']		= $this->file_model->gets($index);
		return $row;
	}

	public function getsFixed($btype) {

		if(is_string($btype))
			$btype			= $this->bname2Type($btype);

		$this->db->trans_begin();
		$sql					= "SELECT boards.idx, boards.title, boards.content, DATE(boards.date) as date, boards.thumbnail, boards.fix, boards.hit, user.name as uname
									FROM boards, user
									WHERE boards.btype = $btype AND boards.user = user.idx AND boards.fix = 1 AND boards.deleted = 0
									ORDER BY boards.idx DESC";
		$query					= $this->db->query($sql);
		$this->db->trans_complete();

		$rows 					= $query->result_array();
		// Append count of comment
		for($i = 0; $i < count($rows); $i++) {

			$rows[$i]['idx']		= intval($rows[$i]['idx']);
			$rows[$i]['fix']		= (boolean)intval($rows[$i]['fix']);
			$rows[$i]['comments']	= count($this->comment_model->gets($rows[$i]['idx']));

			$now 					= new DateTime();
			$date 					= new DateTime($rows[$i]['date']);
			$rows[$i]['new']		= ($now->format('U') - $date->format('U')) / (60*60*24) < self::NEW_DATE_LIMIT;
			
			$files					= $this->file_model->gets($rows[$i]['idx']);
			$rows[$i]['files']		= isset($files['attach-files']) && count($files['attach-files']) != 0;
		}

		return $rows;
	}

	public function gets($btype, $count = null, $offset = null, $keyword = null, $searchType = null) {

		if($this->exists($btype) == false)
			throw new Exception('존재하지 않는 게시판입니다.');

		if(is_string($btype))
			$btype			= $this->bname2Type($btype);

		if($offset < 0)
			throw new Exception('잘못된 접근입니다.');

		// Base sql
		$this->db->trans_begin();
		$sql				=  "SELECT boards.idx, boards.title, boards.content, DATE(boards.date) as date, boards.thumbnail, boards.fix, boards.hit, user.name as uname 
								FROM boards, user 
								WHERE boards.btype = $btype AND boards.user = user.idx AND boards.fix = 0 AND boards.deleted = 0";

		$privilege 			= $this->privilege($btype);
		if($privilege['private']) {

			$user 			= $this->session->userdata('user');
			if($user == null)
				throw new RequireLoginException();

			if($user['admin'] == false)
				$sql		.= ' AND boards.user = ' . $user['idx'];
		}

		// Conditional sql
		switch($searchType) {

			case 'title':
			$sql							.= ' AND ' . $this->getsFromTitle($keyword);
			break;

			case 'uname':
			$sql							.= ' AND ' . $this->getsFromUname($keyword);
			break;

			case 'uid':
			$sql							.= ' AND ' . $this->getsFromUid($keyword);
			break;

			case 'email':
			$sql							.= ' AND ' . $this->getsFromEmail($keyword);
			break;

			case 'content':
			$sql							.= ' AND ' . $this->getsFromContent($keyword);
			break;
		}

		$sql								.= " ORDER BY boards.idx DESC";

		// Limit
		if($offset != null && $count != null)
			$sql							.= " LIMIT $offset, $count";
		else if($count != null)
			$sql							.= " LIMIT $count";



		$query 								= $this->db->query($sql);
		$this->db->trans_complete();

		$rows 								= $query->result_array();


		for($i = 0; $i < count($rows); $i++) {

			$rows[$i]['idx']				= intval($rows[$i]['idx']);
			$rows[$i]['fix']				= (boolean)intval($rows[$i]['fix']);
			$rows[$i]['comments']			= count($this->comment_model->gets($rows[$i]['idx']));
			$now 							= new DateTime();
			$date 							= new DateTime($rows[$i]['date']);
			$rows[$i]['new']				= ($now->format('U') - $date->format('U')) / (60*60*24) < self::NEW_DATE_LIMIT;

			$files							= $this->file_model->gets($rows[$i]['idx']);
			$rows[$i]['files']				= isset($files['attach-files']) && count($files['attach-files']) != 0;

			$rows[$i]['preview']			= strip_tags($rows[$i]['content']);
			if(mb_strlen($rows[$i]['preview']) > 30)
				$rows[$i]['preview']		= mb_substr($rows[$i]['preview'], 0, 30) . '...';
		}
		
		return $rows;
	}

	public function count($btype, $keyword = null, $searchType = null) {

		if($this->exists($btype) == false)
			throw new Exception('존재하지 않는 게시판입니다.');

		$boards				= $this->gets($btype, null, null, $keyword, $searchType);
		return count($boards);
	}

	public function addBoard($id, $name, $rauth = 0, $wauth = 1, $private = 0) {

		$user 						= $this->session->userdata('user');
		if($user == null || $user['admin'] === false)
			throw new NoPrivilegeException();

		if($id == null || mb_strlen($id) == 0)
			throw new Exception('게시판 아이디를 입력하세요.');

		if($name == null || mb_strlen($name) == 0)
			throw new Exception('게시판 이름을 입력하세요.');

		$this->db->trans_begin();
		$sql 						= "INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES ('$name', '$id', $rauth, $wauth, $private)";
		$query 						= $this->db->query($sql);
		$boardIndex 				= $this->db->insert_id();
		$this->db->trans_complete();

		return $boardIndex;
	}

	private function isPostable($content) {

		$dom 				= new DOMDocument();
		$dom->loadHTML($content);
		foreach($this->exceptTagNames as $tagName) {

			if($dom->getElementsByTagName($tagName)->length != 0)
				return false;
		}

		return true;
	}

	public function add($btype, $title, $content, $files, $thumbnail = null, $fix = false) {

		$user 				= $this->session->userdata('user');
		if($user == null)
			throw new RequireLoginException();

		if(mb_strlen($title) == 0)
			throw new Exception('제목을 입력하세요');

		if(mb_strlen($content) == 0)
			throw new Exception('내용을 입력하세요');

		if(is_string($btype))
			$btype 			= $this->bname2Type($btype);

		$userIndex			= $user['idx'];
		$currentDateTime	= date("Y-m-d H:i:s");
		$fix 				= $user['admin'] ? intval($fix) : 0;

		if($this->isPostable($content) == false)
			throw new Exception('게시할 수 없습니다.');

		$this->db->trans_begin();
		$sql 				=  "INSERT INTO boards (btype, title, content, user, thumbnail, date, fix) 
								VALUES ($btype, '$title', '$content', $userIndex, '$thumbnail', '$currentDateTime', $fix)";

		$query 				= $this->db->query($sql);
		$bindex 			= $this->db->insert_id();
		$this->db->trans_complete();

		if($files != null) {

			foreach($files as $file)
				$this->addFile($bindex, $file['title'], $file['path'], $file['ident']);
		}

		return $bindex;
	}

	public function delete($index) {

		$user 				= $this->session->userdata('user');
		if($user == null)
			throw new RequireLoginException();

		$userIndex			= $user['idx'];
		$this->db->trans_begin();
		$sql 				= "SELECT * FROM boards WHERE idx = $index AND deleted = 0 LIMIT 1";
		$query 				= $this->db->query($sql);
		$this->db->trans_complete();

		if($query->num_rows() == 0)
			throw new Exception('게시글을 찾을 수 없습니다.');

		$row 				= $query->row_array();
		if(intval($row['user']) != $user['idx'] && $user['admin'] === false)
			throw new Exception('권한이 없습니다.');

		$this->db->trans_begin();
		$sql 				= "UPDATE boards SET deleted = 1 WHERE idx = $index AND deleted = 0 AND user = $userIndex LIMIT 1";
		$query 				= $this->db->query($sql);
		$this->db->trans_complete();

		return true;
	}

	public function modify($btype, $bindex, $title, $content, $files, $thumbnail = null, $fix = false) {

		$user 				= $this->session->userdata('user');
		if($user == null)
			throw new RequireLoginException();

		if(mb_strlen($title) == 0)
			throw new Exception('제목을 입력하세요');

		if(mb_strlen($content) == 0)
			throw new Exception('내용을 입력하세요');

		if($this->exists($btype) == false)
			throw new Exception('존재하지 않는 게시판입니다.');

		if($this->existsBoard($bindex) == false)
			throw new Exception('존재하지 않는 게시물입니다.');

		if(is_string($btype))
			$btype 			= $this->bname2Type($btype);

		$userIndex			= $user['idx'];
		$fix 				= $user['admin'] ? intval($fix) : 0;

		if($this->isPostable($content) == false)
			throw new Exception('게시할 수 없습니다.');

		$this->db->trans_begin();
		$sql 				=  "UPDATE boards SET title = '$title', content = '$content', thumbnail = '$thumbnail', fix = $fix
								WHERE idx = $bindex AND user = $userIndex LIMIT 1";
		$query 				= $this->db->query($sql);
		$this->db->trans_complete();

		$this->file_model->clear($bindex);
		if($files != null) {

			foreach($files as $file)
				$this->addFile($bindex, $file['title'], $file['path'], $file['ident']);
		}

		return $bindex;
	}

	public function showBoard($dbname, $mode, $index, $option = array(), $parameters = array()) {

		if(isset($option['thumbnail']) == false)
			$option['thumbnail']				= false;

		if(isset($option['viewname']) == false)
			$option['viewname']					= array();

		if(isset($option['viewname']['read']) == false)
			$option['viewname']['read']			= $this->baseform_model->isMobile() ? array('mobile/board/readform/readform_view', 'partition/readform/readform_view_js') : 
																					  array('readform_view', 'partition/readform/readform_view_js');

		if(isset($option['viewname']['write']) == false)
			$option['viewname']['write']		= $this->baseform_model->isMobile() ? array('mobile/board/writeform/writeform_view', 'partition/writeform/writeform_fileset_js', 'partition/writeform/writeform_upload_board_js') : 
																					  array('writeform_view', 'partition/writeform/writeform_fileset_js', 'partition/writeform/writeform_upload_board_js');

		if(isset($option['viewname']['modify']) == false)
			$option['viewname']['modify']		= $this->baseform_model->isMobile() ? array('mobile/board/writeform/writeform_view', 'partition/writeform/writeform_fileset_js', 'partition/modifyform/modifyform_restore_js', 'partition/modifyform/modifyform_upload_board_js') : 
																					  array('writeform_view', 'partition/writeform/writeform_fileset_js', 'partition/modifyform/modifyform_restore_js', 'partition/modifyform/modifyform_upload_board_js');

		if(isset($option['viewname']['default']) == false)
			$option['viewname']['default']		= $this->baseform_model->isMobile() ? array('mobile/board/listform/listform_view') : 
																					  array('listform_view', 'partition/listform/listform_table_view');

		if(isset($option['pagetab']) == false)
			$option['pagetab']					= array();

		if(isset($option['pagetab']['maxViews']) == false)
			$option['pagetab']['maxViews']		= $this->defViewSize;

		if(isset($option['pagetab']['maxTabs']) == false)
			$option['pagetab']['maxTabs']		= $this->defTabSize;

		if(isset($option['search']) == false)
			$option['search']					= array();

		if(isset($option['search']['filter']) == false)
			$option['search']['filter']			= $this->_searchopt;


		$user 									= $this->session->userdata('user');
		$parameters['user']						= $user;
		$parameters['dbname']					= $dbname;


		try {
			if($this->inspect($dbname, $mode) == false)
				return;

			switch($mode) {

				case 'read':
					$index						= intval($this->input->get('index', true));
					$parameters['binfo']		= array('board' => $this->board_model->get($dbname, $index),
														'comments' => $this->comment_model->gets($index));

					$this->load->helper('simple_html_dom');
					$html 						= str_get_html($parameters['binfo']['board']['content']);
					foreach($html->find('.preview-videoimg') as $index => $element) {

						$element->outertext = $this->load->view($this->baseform_model->isMobile() ? 'mobile/board/readform/readform_video_view' : 'partition/readform/readform_video_view', 
																array('keycode' => $index, 'name' => $element->name, 'path' => base_url($element->path)), true);
					}
					$parameters['binfo']['board']['content'] = $html->save();
					break;

				case 'write':
					$parameters['thumbnail']	= $option['thumbnail'];
					$parameters['maxUploadSize']= $this->maxUploadSize;
					break;

				case 'modify':
					$index 						= intval($this->input->get('index', true));
					$board 						= $this->get($dbname, $index);
					if($this->session->userdata('user') == null)
						throw new RequireLoginException();
					if($board['own'] === false && $user['admin'] === false)
						throw new Exception('수정할 수 없습니다.');

					$parameters['board']		= $board;
					$parameters['index']		= $index;
					$parameters['thumbnail']	= $option['thumbnail'];
					$parameters['maxUploadSize']= $this->maxUploadSize;
					break;

				default:
					$keyword					= $this->input->get('keyword', true);
					$searchType					= $this->input->get('searchType', true);
					$page 						= $this->input->get('page', true);
					if($page == false)
						$page 					= 1;

					$parameters['page']			= json_encode($page);
					$parameters['boards']		= array_merge($this->getsFixed($dbname), 
															  $this->gets($dbname, $option['pagetab']['maxViews'], ($page-1) * $option['pagetab']['maxViews'], $keyword, $searchType));
					$parameters['count']		= json_encode($this->count($dbname, $keyword, $searchType));
					$parameters['maxViews']		= json_encode($option['pagetab']['maxViews']);
					$parameters['maxTabs']		= json_encode($option['pagetab']['maxTabs']);
					$parameters['searchopt']	= $option['search']['filter'];
					$parameters['privilege']	= json_encode($this->privilege($dbname));
					$parameters['keyword']		= $keyword;
					$parameters['searchType']	= $searchType;

					$mode 						= 'default';
					break;
			}

			$customViews 						= $option['viewname'][$mode];
			$this->baseform_model->loadView($customViews, null, $parameters);
		} catch (Exception $e) {
			
			$this->inspectException($e);
		}
	}
}