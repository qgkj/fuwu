<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'ext_code'      => 'mp_zjd',
			
	'forms' => array(
		array('name' => 'point_status',       'type' => 'radiobox',    'value' => ''),
		array('name' => 'point_value',        'type' => 'text',        'value' => ''),
		array('name' => 'point_num',          'type' => 'text',        'value' => ''),
		array('name' => 'point_interval',     'type' => 'select',      'value' => ''),
			
		array('name' => 'prize_num',          'type' => 'text',        'value' => ''),
		array('name' => 'starttime',          'type' => 'text',        'value' => ''),
		array('name' => 'endtime',            'type' => 'text',        'value' => ''),
		array('name' => 'list',              'type' => 'textarea',    'value' => ''),
		array('name' => 'description',        'type' => 'textarea',    'value' => ''),
		array('name' => 'media_id',           'type' => 'text',        'value' => ''),
	),
);

// end