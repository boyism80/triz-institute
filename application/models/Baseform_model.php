<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//
// 기본 폼을 구성해주는 모델 클래스
//
class Baseform_model extends CI_Model {

    function __construct() {

        parent::__construct();
        $this->load->model('category_model');
    }

    //
    // 기본 틀에 커스텀 뷰를 표현하는 메소드
    //
    // customViews
    //  기본 폼에 보여줄 뷰 리스트
    //
    // mobileCustomViews
    //  모바일의 경우 보여줄 뷰 리스트
    //
    // parameteres
    //  뷰에 넘겨줄 파라미터
    //
    public function loadView($customViews, $mobileCustomViews = null, $parameters = null) {

        try {

            $current = $this->category_model->current();

            if($this->category_model->isFiltered($current['item'], false))
                throw new Exception();

            if($this->category_model->isFiltered($current['active'], false))
                throw new Exception();

            $baseformView = $this->isMobile() ? 'mobile/baseform_view' : 'baseform_view';

            if($parameters == null)
                $parameters = array();

            $parameters['currentTab']  = $this->category_model->current();
            $parameters['customViews'] = $customViews;

            if($this->isMobile()) {

                if($mobileCustomViews != null)
                    $parameters['customViews'] = $mobileCustomViews;

                $this->load->view($baseformView, $parameters);
            } else {

                $this->load->view('header_view', array('menu' => $this->category_model->gets()));
                $this->load->view($baseformView, $parameters);
                $this->load->view('footer_view');
            }
        } catch (Exception $e) {
            
            echo '<script type="text/javascript">history.back();</script>';
        }
    }

    // 모바일 환경인지 여부
    public function isMobile() {

        return $this->agent->is_mobile();
    }
}