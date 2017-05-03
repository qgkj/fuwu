<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_nav_here {
    private $label;
    private $link;
    
    public function __construct($label, $link = null) {
        $this->label = $label;
        $this->link = $link;
    }
    
    public function get_label() {
        return $this->label;
    }
    
    public function get_link() {
        return $this->link;
    }
}


// end