<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clear_cache {

    public function __construct() {
        $this->ci = & get_instance();        
    }
    
    public function back_button(){
        $this->ci->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->ci->output->set_header("Pragma: no-cache");
    }

}

/* End of file clear_cache.php */