<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    'cron_code'      => 'cron_bill_day',
	'forms' => array(
		array('name' => 'bill_day_count', 'type' => 'select', 'value' => '5'),
	),
    'lock_time' => true,//锁定任务时间，不可修改
    'default_time' => array('day' => '0', 'week' => '', 'hour' => '4', 'minute' => ''),
    
);

// end