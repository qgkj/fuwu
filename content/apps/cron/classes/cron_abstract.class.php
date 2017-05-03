<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
use Ecjia\System\Plugin\AbstractPlugin;

/**
 * 计划任务抽象类
 * @author royalwang
 */
abstract class cron_abstract extends AbstractPlugin {
    /**
     * 计划任务执行方法
     */
	abstract public function run();
	
}

// end