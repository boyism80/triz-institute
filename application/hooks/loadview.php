<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loadview
{
	public static $MOBILE_PLATFORM = 'mobile';
	public static $DEFAULT_PLATFORM = 'default';

	public function load(){

        $this->CI =& get_instance();
        $view_type = $this->CI->agent->is_mobile() ? self::$MOBILE_PLATFORM : self::$DEFAULT_PLATFORM;
        // $this->CI->load->_ci_view_path = $this->CI->load->_ci_view_path . $view_type .'/';
        $this->CI->load->_ci_view_paths = null;
	}
}

?>