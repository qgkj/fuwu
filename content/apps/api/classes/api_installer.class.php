<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class api_installer  extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system'    => '1.0'
    );
    
    public function __construct() {
        $id = 'ecjia.api';
        parent::__construct($id);
    }
    
    public function install() {
        return ;
    }
    
    public function uninstall() {
        return ;
    }
    
}

// end