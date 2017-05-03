<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * API接口类
 * @author royalwang
 *
 */
interface ecjia_interface {
    // API执行方法
    public function run(ecjia_api & $api);
}

// end