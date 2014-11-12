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
		if(!empty($this->CRM_USER_SESSION)){
			$this->data['page_to_load'] = 'pages/dashboard';
			$this->load->vars($this->data);
			$this->load->view('template');
		}else{
			$this->load->view('login');
		}
    }
    
    public function login() {
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$this->load->model('users_model');
                    $u = $this->input->post('username');
                    $p = $this->input->post('password');
                    $r = $this->users_model->is_login($u, $p);
			}
		}
		exit;
		$r = array(
				'id' => '1',
				'username' => 'admin'
			);
		$this->session->set_userdata('CRM_USER_SESSION', $r);
		redirect(base_url(), 'refresh');
    }

    public function logout() {
        if (!empty($this->CRM_USER_SESSION)) {
            $this->session->unset_userdata('CRM_USER_SESSION');
            $this->session->sess_destroy();
            redirect(base_url(), 'refresh');
        }
        redirect(base_url());
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
