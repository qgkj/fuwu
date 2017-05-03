<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'ext_code'      => 'mp_userbind',
			
	'forms' => array(
	    array('name' => 'point_status',       'type' => 'radiobox',    'value' => ''),
	    array('name' => 'point_value',        'type' => 'text',        'value' => ''),
	    array('name' => 'point_num',          'type' => 'text',        'value' => ''),
	    array('name' => 'point_interval',     'type' => 'select',      'value' => ''),
		array('name' => 'bonus_status',       'type' => 'select',      'value' => ''),
		array('name' => 'bonus_id',     	  'type' => 'text',        'value' => ''),
	),
);

// end

