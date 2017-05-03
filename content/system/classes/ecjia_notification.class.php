<?php
  
/**
 * 消息通知提示
 * @author royalwang
 *
 */
class ecjia_notification {
    
    protected static $instance;
    
    protected $registered;
    
    /**
     * Create instance
     * 
     * @return  void
     */
    public static function make()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    /**
     * Get notification Object
     * @param string $handle Unique item name.
     * @return admin_notification class
     */
    public function query($handle) {
        if (! isset($this->registered[$handle]))
            return false;
        
        return $this->registered[$handle];
    }
    
    /**
     * register an item;
     * 
     * @param string $handle Unique item name.
     * @param admin_notification $notification
     * @return boolean
     */
    public function register($handle, admin_notification $notification) {
        if (isset($this->registered[$handle]))
            return false;
        $this->registered[$handle] = $notification;
    }
    
    /**
     * Un-register an item or items.
     *
     * @access public
     * @since 3.14.0
     *
     * @param mixed $handles Item handle and argument (string) or item handles and arguments (array of strings).
     * @return void
     */
    public function remove($handles)
    {
        foreach ((array) $handles as $handle)
            unset($this->registered[$handle]);
    }
    
    public function allNotification() {
        return $this->registered;
    }
    
    public function printScript() {
        if (! empty($this->registered)) {
            $script = '<script type="text/javascript">' . PHP_EOL;
            foreach ($this->registered as $notification) {
                $options = array();
                $notification->getAutoclose() and $options['autoclose'] = $notification->getAutoclose();
                $notification->getPosition() and $options['position'] = $notification->getPosition();
                $notification->getType() and $options['type'] = $notification->getType();
                $notification->getSpeed() and $options['speed'] = $notification->getSpeed();
                $notification->getDuplicates() and $options['duplicates'] = $notification->getDuplicates();
                !empty($options) and $options_json = json_encode($options); 
                
                $script .= '$.sticky("' . rc_addslashes($notification->getContent()) . '", ' . $options_json . ');' . PHP_EOL;
            }
            $script .= '</script>' . PHP_EOL;

            echo $script;
        }
    }
    
    
}

