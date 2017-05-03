<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 计划任务执行文件
 * @author royalwang
 */
class api {
    public function init() {
        RC_Package::package('app::cron')->loadClass('cron_run')->run();
    }
}