<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public $CRM_USER_SESSION;
    private $data = array();

    public function __construct() {
        parent::__construct();
        $this->clear_cache->back_button();
    }

    public function index() {
        //print_r($this->session->all_userdata());
        if (!empty($this->CRM_USER_SESSION)) {
            $this->data['page_to_load'] = 'modules/dashboard/index';
            $this->load->vars($this->data);
            $this->load->view('template');
        } else {
            $this->load->view('login');
        }
    }

    public function login() {
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $u = $this->input->post('username');
                $p = $this->input->post('password');
                if (strtolower($u) == 'admin' && strtolower($p) == 'admin123') {
                    $r = array(
                        'id' => '1',
                        'username' => 'admin'
                    );
                    $this->session->set_userdata('CRM_USER_SESSION', $r);
                }
            }
        }
        redirect(base_url(), 'refresh');
    }

    public function logout() {
        if (!empty($this->CRM_USER_SESSION)) {
            $this->session->unset_userdata('CRM_USER_SESSION');
            $this->session->sess_destroy();
        }
        redirect(base_url(), 'refresh');
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
