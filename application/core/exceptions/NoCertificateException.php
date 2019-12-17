<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NoCertificateException extends Exception {

    public function __construct($message = '인증이 필요합니다.', $code = 0) {
        parent::__construct($message, $code);
    }
}

?>