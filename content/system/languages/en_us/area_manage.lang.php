<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	/* Field information */
	'region_id'		=> 'Region id',
	'region_name'	=> 'Region name',
	'region_type'	=> 'Region type',
	
	'area'		=> 'Area',
	'area_next'	=> 'Following',
	'country'	=> 'Country',
	'province'	=> 'Province',
	'city'		=> 'City',
	'cantonal'	=> 'Cantonal',
	'back_page'	=> 'Previous',
	'manage_area'		=> 'Manage',
		
	'region_name_empty'	=> 'Please enter a region name!',
	'add_country'		=> 'Add new country',
	'add_province'		=> 'Add new province',
	'add_city'			=> 'Add new city',
	'add_cantonal'		=> 'Add new cantonal',
	
	/* JS language item */
	'js_languages' => array(
		'region_name_empty'	=> 'Please enter a region name!',
		'option_name_empty'	=> 'Please enter a option name of survey!',
		'drop_confirm'		=> 'Are you sure delete this record?',
		'drop'				=> 'Delete',
		'country'			=> 'Country',
		'province'			=> 'Province',
		'city'				=> 'City',
		'cantonal'			=> 'Cantonal'
	),

	/* Prompting message */
	'add_area_error'	=> 'Add new region failed!',
	'add_area_parentid_error'	=> 'Adding a new area of the parent id does not exist.',//追加
	'region_name_exist'	=> 'The region name already exists.',
	'parent_id_exist'	=> 'You can\'t delete it, because the region contains subregions!',
	'form_notic'		=> 'View subregion',
	'area_drop_confirm'	=> 'If the default order or the user mode using the following distribution areas, where information will be displayed as empty. Are you sure you want to delete this record?',
);

//end