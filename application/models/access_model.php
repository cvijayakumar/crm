<?php

class Access_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	


    public function usertype_module_access($usertype_id) {
		

        $query = $this->db->get_where('usertype_module_access', array('usertype_id' => $usertype_id));
        if ($query->num_rows()) {
            $result = array();
            foreach ($query->result_array() as $row) {
                $result[$row['module_id']] = $row['access_type'];
            }
            return $result;
        }
        return false;
    }

    public function usertype_page_access($usertype_id) {
        $query = $this->db->get_where('usertype_page_access', array('usertype_id' => $usertype_id));
        if ($query->num_rows()) {
            $result = array();
            foreach ($query->result_array() as $row) {
                $result[$row['page_id']] = $row['access_type'];
            }
            return $result;
        }
        return false;
    }

}