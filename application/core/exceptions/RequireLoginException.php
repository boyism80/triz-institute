<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RequireLoginException extends Exception {

    public function __construct($message = '로그인이 필요합니다.', $code = 0) {
        parent::__construct($message, $code);
    }
}

?>