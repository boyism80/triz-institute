<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model {

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
	}

	private function extractThumbnail($src, $dest, $time = 1, $width = 120, $height = 90) {

		$cwd 				= getcwd();
		$ffmpeg 			= realpath('assets/FFMPEG/bin/ffmpeg.exe');
		if(file_exists($ffmpeg) == false)
			throw new Exception($ffmpeg . ' : Cannot find ffmpeg file');
		
		$size 				= sprintf('%dx%d', $width, $height);
		$source 			= $src;
		$destination 		= $dest;

		$directory			= dirname($destination);
		if(file_exists($directory) == false)
			mkdir($directory, 0777, true);
		
		if(file_exists($destination))
			unlink($destination);
		
		$cmd 				= sprintf('"%s" -i "%s" -an -ss %d -s %s "%s" 2>&1', $ffmpeg, $source, $time, $size, $destination);
		if(PHP_OS == 'WINNT' && version_compare(PHP_VERSION, '5.3.0', '<') )
			$cmd 			= sprintf('"%s"', $cmd);
		
		if(shell_exec($cmd) == null)
			return false;
		
		return base_url($dest);
	}

	public function upload($name, $ident, $path) {

		if(isset($_FILES[$name]) == false)
			return null;

		$this->load->library('upload');

		if(file_exists($path) == false)
			mkdir($path, 0777, true);

		$config = array();
		$config['upload_path'] 			= $path;
		$config['allowed_types'] 		= '*';
		$config['encrypt_name']			= true;
		$config['remove_spaces']		= false;

		$ret 							= array();
		$files 							= $_FILES;
		$count 							= count($_FILES[$name]['name']);

		for($i = 0; $i < $count; $i++)
		{
			$_FILES[$name]['name']		= $files[$name]['name'][$i];
			$_FILES[$name]['type']		= $files[$name]['type'][$i];
			$_FILES[$name]['tmp_name']	= $files[$name]['tmp_name'][$i];
			$_FILES[$name]['error']		= $files[$name]['error'][$i];
			$_FILES[$name]['size'] 		= $files[$name]['size'][$i];

			$this->upload->initialize($config);
			if($this->upload->do_upload($name) == false)
				continue;

			$uploaded					= $this->upload->data();
			$uploaded['title']			= $uploaded['orig_name'];
			$uploaded['size']			= $uploaded['file_size'] * 1024;
			$uploaded['path']			= $path . '/' . $uploaded['file_name'];
			$uploaded['ident']			= $ident;
			$uploaded['url']			= base_url() . $uploaded['path'];

			// if(strstr($uploaded['file_type'], 'video/')) {		// FFMPEG에서 썸네일을 추출해낸다.

			// 	$uploaded['thumb']		= $this->extractThumbnail($uploaded['path'], 'assets/uploads/thumbnails/' . $uploaded['file_name'] . '.png');
			// 	$uploaded['preview']	= $this->extractThumbnail($uploaded['path'], 'assets/uploads/thumbnails/' . $uploaded['file_name'] . '.png', 1, 480, 360);
			// }


			if(strstr($uploaded['file_type'], 'video/'))
				$uploaded['preview']	= base_url('assets/images/alter_video.png');

			array_push($ret, $uploaded);
		}

		return $ret;
	}

	public function gets($bindex) {

		$this->db->trans_start();
		$sql 				= "SELECT * FROM files WHERE bindex = $bindex";
		$query 				= $this->db->query($sql);
		$this->db->trans_complete();

		$rows				= $query->result_array();
		$result 			= array();
		foreach($rows as $row) {

			$ident 			= $row['ident'];
			if(isset($result[$ident]) == false)
				$result[$ident]		= array();

			if(file_exists($row['path']) == false)
				continue;

			$row['size']	= filesize($row['path']);
			$row['url']		= base_url() . $row['path'];
			
			array_push($result[$ident], $row);
		}

		return $result;
	}

	public function clear($bindex) {

		$this->db->trans_start();
		$sql 				= "DELETE FROM files WHERE bindex = $bindex";
		$query 				= $this->db->query($sql);
		$this->db->trans_complete();

		return true;
	}
}