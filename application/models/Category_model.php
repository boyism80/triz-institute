<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	private $path			= 'assets/xml/menu.xml';

	function __construct() {

		parent::__construct();

		$this->load->model('baseform_model');
	}

	private function coverURL($item) {

		if(stristr($item->attributes()->link, 'javascript') == false)
			$item->attributes()->link 			= base_url() . $item->attributes()->link;

		foreach($item->subitem as $subitem) {
			if(stristr($subitem->attributes()->link, 'javascript') != false)
				continue;

			$subitem->attributes()->link 	= base_url($subitem->attributes()->link);
		}

		return $item;
	}

	public function isFiltered($item, $excludeHide) {

		$isMobile 			= $this->baseform_model->isMobile();
		$user				= $this->session->userdata('user');		
		$isAdminstrator		= $user != null && $user['admin'] === true;
		$attrs 				= $item->attributes();

		if($user == null && $attrs->condition == "login")
			return true;

		if($user != null && $attrs->condition == "logout")
			return true;

		if($isAdminstrator == false && $attrs->condition == 'admin')
			return true;

		if($excludeHide === true && $attrs->condition == 'hide')
			return true;

		if(($attrs->platform == 'desktop' && $isMobile) || ($attrs->platform == 'mobile' && $isMobile == false))
			return true;

		return false;
	}

	public function gets($filter = true, $excludeHide = false) {

		if(file_exists($this->path) == false)
			return null;

		$xml				= simplexml_load_file($this->path);
		$ret 				= array();

		foreach($xml as $name => $group) {

			$ret[$name]		= array();

			foreach($group->item as $item) {

				if($filter === true && $this->isFiltered($item, $excludeHide) === true)
					continue;

				for($i = count($item->subitem) - 1; $i > 0 ; $i--) {

					if($filter === true && $this->isFiltered($item->subitem[$i], $excludeHide) === true)
						unset($item->subitem[$i]);
				}

				$item		= $this->coverURL($item);
				array_push($ret[$name], $item);
			}
		}

		return $ret;
	}

	public function get($name) {

		$menus				= $this->gets(false);
		foreach($menus['navitab'] as $menu) {

			if($menu->attributes()->link == base_url($name))
				return $menu;
		}

		return null;
	}

	private function matchedItem($items, $isReverse = false) {

		$currentURI			= uri_string();
		$pureURI			= $_SERVER['QUERY_STRING'] == null ? $currentURI : $currentURI . '?' . $_SERVER['QUERY_STRING'];

		foreach($items as $item) {

			foreach($item->subitem as $subitem) {

				$attrs 		= $subitem->attributes();
				$matched	= $isReverse === true ? (strcmp($attrs['link'], $currentURI) === 0) || (strcmp($pureURI, $attrs['link']) === 0) : 
													(strcmp($currentURI, $attrs['link']) === 0) || (strcmp($attrs['link'], $pureURI) === 0);

				if($matched == true)
					return array('item' => $item, 'active' => $subitem);
			}
		}

		return null;
	}

	private function simularItem($items, $isReverse = false) {

		$currentURI			= uri_string();
		$pureURI			= $_SERVER['QUERY_STRING'] == null ? $currentURI : $currentURI . '?' . $_SERVER['QUERY_STRING'];

		$current 			= null;
		$maxval				= 0;

		foreach($items as $item) {

			foreach($item->subitem as $subitem) {

				$attrs 		= $subitem->attributes();
				$compval	= $isReverse === true ? max(strcmp($attrs['link'], $currentURI), strcmp($pureURI, $attrs['link'])) : 
													max(strcmp($currentURI, $attrs['link']), strcmp($attrs['link'], $pureURI));
				if($maxval > $compval)
					continue;

				$maxval		= $compval;
				$current 	= array('item' => $item, 'active' => $subitem);
			}
		}

		if(abs($maxval) == 1)
			return null;

		return $current;
	}

	public function current() {

		$currentURI			= uri_string();
		$pureURI			= $_SERVER['QUERY_STRING'] == null ? $currentURI : $currentURI . '?' . $_SERVER['QUERY_STRING'];

		$xml				= simplexml_load_file($this->path);

		foreach($xml->navitab->item as $item) {

			$attrs 			= $item->attributes();
			if(strcmp($attrs['link'], $currentURI) == 0 || strcmp($attrs['link'], $pureURI) == 0)
				return array('item' => $item, 'active' => $item->subitem[0]);
		}

		$ret 				= $this->matchedItem($xml->navitab->item);
		if($ret != null)
			return $ret;

		$ret 				= $this->matchedItem($xml->navitab->item, true);
		if($ret != null)
			return $ret;

		$ret 				= $this->simularItem($xml->navitab->item);
		if($ret != null)
			return $ret;

		$ret 				= $this->simularItem($xml->navitab->item, true);
		if($ret != null)
			return $ret;

		return null;
	}
}