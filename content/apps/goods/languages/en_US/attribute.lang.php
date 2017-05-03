<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品类型管理语言文件
 */
return array(
	/* List */
	'by_goods_type' 	=> 'Display by product type:',
	'all_goods_type' 	=> 'All products type',
	'attr_id' 			=> 'ID',
	'cat_id' 			=> 'Product type',
	'attr_name' 		=> 'Attribute name',
	'attr_input_type' 	=> 'Enter mode',
	'attr_values' 		=> 'Choice value list',
	'attr_type' 		=> 'Whether need select the value of attribute for shopping?',
	
	'value_attr_input_type' => array(
		ATTR_TEXT 		=> 'Manual enter',
		ATTR_OPTIONAL 	=> 'Select from list',
		ATTR_TEXTAREA 	=> 'Multirow textbox',
	),
		
	'drop_confirm' 	=> 'Are you sure delete the attribute?',
	'batchdrop' 	=> 'Batch drop',	//追加
		
	/* Add/Edit */
	'label_attr_name' 	=> 'Attribute name:',
	'label_cat_id' 		=> 'Category:',
	'label_attr_index' 	=> 'Index:',
	'label_is_linked' 	=> 'Relational products with same attribute?:',
	'no_index' 			=> 'Needn\'t index',
	'keywords_index' 	=> 'Keywords index',
	'range_index' 		=> 'Range index',
	'note_attr_index' 	=> 'Please select have no use for search if have no use for the attribute become a situation of search product condition. Please select keywords search if have use for the attribute carry through keywords search. Please select range search if the attribute search need to appoint a certain range.',
	'label_attr_input_type' => 'Attribute value enter mode:',
	'text' 				=> 'Manual enter',
	'select' 			=> 'Select from below (one line stand for one value)',
	'text_area' 		=> 'Multirow textbox',
	'label_attr_values' => 'Choice value list:',
	'label_attr_group' 	=> 'Property division:',
	'label_attr_type' 	=> 'Property is optional:',
	'note_attr_type' 	=> 'Select "Yes" when the merchandise can set up a number of property value, while property values specified for different different price increases, users need to purchase merchandise at selected specific property value. Choose "No" when the property value of the merchandise can only set a value, the user can only view the value.',
	'attr_type_values' 	=> array(
		0 => 'The only property',
		1 => 'Radio property',
		2 => 'Check property',
	),
	
	'add_next' 	=> 'Continue to add attribute',
	'back_list' => 'Return to goods attribute',
	'add_ok' 	=> 'Add attribute [%s] success',
	'edit_ok' 	=> 'Edit attribute [%s] success',
	
	/* Prompting message */
	'name_exist' 			=> 'The attribute name already exists, please change another one.',
	'drop_confirm' 			=> 'Are you sure delete the attribute?',
	'notice_drop_confirm' 	=> 'Already has %s the use of the property of merchandise, you sure you want to delete the right property?',
	'name_not_null' 		=> 'Attribute name can\'t be blank.',
	'no_select_arrt' 		=> 'You have no choice need to remove the attribute name',
	'drop_ok' 		 		=> 'Delete success',

	'js_languages' => array(
		'name_not_null' 	=> 'Please enter attribute name.',
		'values_not_null' 	=> 'Please enter the attribute\'s value.',
		'cat_id_not_null' 	=> 'Please select the attribute of product type.',
	),
	
	//追加
	'goods_attribute'	=> 'Goods Attribute',
	'add_attribute'		=> 'Add Attribute',
	'cat_not_empty'		=> 'Product type can not be empty',
	'edit_success'		=> 'Edit success',
	'format_error'		=> 'Please enter a number greater than 0',
	'drop_success'		=> 'Success delete',
	
	'drop_select_confirm'	=> 'Are you sure you want to delete the selected goods attributes?',
	'batch_operation'		=> 'Batch Operations',
	'name_not_null'			=> 'Please enter a property name',
	'order_not_null'		=> 'Please enter the sort number',
	
    'overview'              => 'Overview',
    'more_info'             => 'More information:',
	
	'goods_attribute_help'	=> 'Welcome to ECJia intelligent background goods properties list page, the system will display all the goods properties in this list.',
	'about_goods_attribute'	=> 'About the goods properties list help document',
	
	'add_attribute_help'	=> 'Welcome to ECJia intelligent background to add goods attributes page, you can add the goods attribute information on this page.',
	'about_add_attribute'	=> 'About add goods attributes help document',
	
	'edit_attribute_help'	=> 'Welcome to ECJia intelligent background editing goods properties page, you can edit the goods attribute information on this page.',
	'about_edit_attribute'	=> 'About edit goods attributes help document',
);

// end