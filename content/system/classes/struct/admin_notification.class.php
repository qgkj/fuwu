<?php
  
/**
 * 消息通知提示
 * @author royalwang
 *
 */
class admin_notification {
    
    /**
     * top-right
     * top-center
     * top-left
     * bottom-right
     * bottom-left
     * @var string
     */
    private $position = 'top-right';
    
    const POSITION_TOP_RIGHT    = 'top-right';
    const POSITION_TOP_LEFT     = 'top-left';
    const POSITION_TOP_CENTER   = 'top-center';
    const POSITION_BOTTOM_RIGHT = 'bottom-right';
    const POSITION_BOTTOM_LEFT  = 'bottom-left';
    
    /**
     * st-error
     * st-success
     * st-info
     * @var string
     */
    private $type;
    
    const TYPE_ERROR    = 'st-error';
    const TYPE_SUCCESS  = 'st-success';
    const TYPE_INFO     = 'st-info';
    
    private $autoclose;
    
    /**
     * animations: 
     * fast
     * slow
     * integer
     * @var string
     */
    private $speed;
    
    /**
     * true or false
     * @var bool
     */
    private $duplicates;
    
    private $content;
    
    /**
     * Create instance
     *
     * @return  void
     */
    public static function make($content)
    {
        return new static($content);
    }
    
    public function __construct($content) {
        $this->content = $content;
    }
    
    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }
    
    public function setType($type) {
        $this->type = $type;
        return $this;
    }
    
    public function setAutoclose($autoclose) {
        $this->autoclose = $autoclose;
        return $this;
    }
    
    public function setSpeed($speed) {
        $this->speed = $speed;
        return $this;
    }
    
    public function setDuplicates($duplicates) {
        $this->duplicates = $duplicates;
        return $this;
    }
    
    public function getPosition() {
        return $this->position;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function getAutoclose() {
        return $this->autoclose;
    }
    
    public function getSpeed() {
        return $this->speed;
    }
    
    public function getDuplicates() {
        return $this->duplicates;
    }
    
    public function getContent() {
        return $this->content;
    }
}

