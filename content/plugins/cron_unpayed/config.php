<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'cron_code'      => 'cron_unpayed',
	'forms' => array(
	    array('name' => 'unpayed_hours', 'type' => 'select', 'value' => '24'),
		array('name' => 'unpayed_count', 'type' => 'select', 'value' => '500'),
	),
);

// end