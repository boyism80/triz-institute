<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NoPrivilegeException extends Exception {

    public function __construct($message = '권한이 없습니다.', $code = 0) {
        parent::__construct($message, $code);
    }
}

?>