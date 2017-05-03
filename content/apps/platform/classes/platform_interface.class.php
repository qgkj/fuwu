<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

interface platform_interface {
    
    /**
     * 插件返回数据的点击事件处理
     */
    public function action();
    
}

// end