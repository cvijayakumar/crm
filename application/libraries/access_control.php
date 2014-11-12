<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Access_control {

    public $CRM_USER_SESSION;

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->CRM_USER_SESSION = $this->ci->session->userdata('CRM_USER_SESSION');        
    }

    public function check_user_session() {
        if (empty($this->ci->CRM_USER_SESSION)) {
            redirect(base_url());
        }
        return true;
    }
    
    public function check_module_access($user_type, $access_type) {
        if ($user_type == 1) {
            return true;
        }
        switch ($access_type) {
            case -1 :
                return true;
                break;
            case 0 :
                redirect(base_url() . 'module_restrict');
                break;
            case 5 :
                return true;
                break;
            default :
                redirect(base_url() . 'module_restrict');
                break;
        }
    }

    public function check_page_access($user_type, $access_type) {
        if ($user_type == 1) {
            return true;
        }
        switch ($access_type) {
            case '0' :
                redirect(base_url() . 'page_restrict');
                break;
            case '5' :
                return true;
                break;
            default :
                redirect(base_url() . 'page_restrict');
                break;
        }
    }

}

/* End of file access_control.php */
