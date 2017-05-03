<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'ext_code'      => 'mp_checkin',
			
	'forms' => array(
		array('name' => 'point_status',       'type' => 'radiobox',    'value' => ''),
		array('name' => 'point_value',        'type' => 'text',        'value' => ''),
		array('name' => 'point_num',          'type' => 'text',        'value' => ''),
		array('name' => 'point_interval',     'type' => 'select',      'value' => ''),
	),
);

// end