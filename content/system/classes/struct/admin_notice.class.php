<?php
  
class admin_notice {
    private $content;
    private $type;
    private $allow_close = true;
    
    public function __construct($content, $type = 'alert', $allow_close = true) {
        $this->content      = $content;
        $this->type         = $type;
        $this->allow_close  = $allow_close;
    }
    
    public function get_content() {
        return $this->content;
    }
    
    public function get_type() {
        return $this->type;
    }
    
    public function get_allow_close() {
        return $this->allow_close;
    }
}

// end