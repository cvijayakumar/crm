<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Controller {

    public $CRM_USER_SESSION;
    private $data = array();
    
    public function __construct() {
        parent::__construct();
        $this->clear_cache->back_button();
        $this->access_control->check_user_session();
    }

    public function index() {
        echo 'Common Controller';
    }

}

/* End of file common.php */
/* Location: ./application/controllers/common.php */
