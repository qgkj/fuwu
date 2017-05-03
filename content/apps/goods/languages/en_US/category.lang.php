<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品分类管理语言文件
 */
return array(
	/* Commodity category field information */
	'goods_category'=> 'Goods Category',
	'cat_id' 		=> 'ID',
	'cat_name' 		=> 'Name',
	'isleaf' 		=> 'Disallow',
	'noleaf' 		=> 'Allow',
	'keywords' 		=> 'Keywords',
	'cat_desc' 		=> 'Description',
	'parent_id' 	=> 'Parent',
	'sort_order' 	=> 'Sort',
	'measure_unit' 	=> 'Quantity unit',
	'delete_info' 	=> 'Delete checked',
	'category_edit' => 'Edit Category',
	'move_goods' 	=> 'Move Goods',
	'cat_top' 		=> 'Root',
	'show_in_nav' 	=> 'Display in navigation',
	'cat_style' 	=> 'Style sheet document classification',
	'is_show' 		=> 'Whether display',
	'show_in_index' => 'Is set to recommend home',
	'notice_show_in_index' => 'This setting can be the latest in the home, hot, Department recommend that the classification of merchandise under Recommend',
	'goods_number' 	=> 'Goods number',
	'grade' 		=> 'Price range of the number of',
	'notice_grade' 	=> 'This option indicates that the classification of merchandise under the lowest and the highest price level of the division between the number of express no grading fill 0',
	'short_grade' 	=> 'Prices rating',
	
	'nav' 			=> 'Navigation',
	'index_new' 	=> 'Latest',
	'index_best'	=> 'Boutique',
	'index_hot' 	=> 'Top',
	
	'back_list' 	=> 'Return to goods category',
	'continue_add' 	=> 'Continue to add category',
	'notice_style' 	=> 'You can for each classification of merchandise to specify a style sheet document. For example, documents stored in the themes directory then enter:themes/style.css',
	
	/* Prompting message */
	'catname_empty' => 'Please enter a category name!',
	'catname_exist' => 'The category name already exists.',
	"parent_isleaf" => 'The category can\'t be the bottom class category!',
	"cat_isleaf" 	=> 'The category can\'t be deleted, because it isn\'t the bottom class category or some product already exists.',
	"cat_noleaf" 	=> 'There are still subcategories, so you can\'t modify category for the bottom class!',
	"is_leaf_error" => 'The selected higher category can\'t be lower category of current category!',
	'grade_error' 	=> 'Quantity price classification can only be an integer within 0-10',
	
	'catadd_succed' 	=> 'Add category success!',
	'catedit_succed' 	=> 'Edit category success!',
	'catdrop_succed' 	=> 'Delete category success!',
	'catremove_succed' 	=> 'Move category success!',
	'move_cat_success' 	=> 'Move category has finished!',
	
	'cat_move_desc' 	=> 'What is move category?',
	'select_source_cat' => 'Please select category that you want to move.',
	'select_target_cat' => 'Please select category that the target.',
	'source_cat' 		=> 'From that category',
	'target_cat' 		=> 'Move to',
	'start_move_cat' 	=> 'Submit',
	'cat_move_notic' 	=> 'In add product or pruduct management, if you want to change products category, you can manage the products category by the function.',
	'cat_move_empty' 	=> 'Please select category rightly!',
	
	'sel_goods_type' 	=> 'Please choose the type of merchandise',
	'sel_filter_attr' 	=> 'Please select filter property',
	'filter_attr' 		=> 'Filter property',
	'filter_attr_notic' => 'Filter property page to the previous classification of merchandise selection',
	'filter_attr_not_repeated' => 'Filter property can`t be repeated',
	
	/*JS language item*/
	'js_languages' => array(
		'catname_empty' => 'Category name can\'t be blank!',
		'unit_empyt' 	=> 'Unit of quantity can\'t be blank!',
		'is_leafcat' 	=> "You selected category is a bottom class category. \\nThe higher category of new category can\'t be a bottom class category.",
		'not_leafcat' 	=> " You selected category isn\'t a bottom class category. \\nThe category of product transfer can just be operated between the bottom class categories.",
		'filter_attr_not_repeated' => 'Filter property can`t be repeated',
		'filter_attr_not_selected' => 'Please select a filter property',
	),
	
	//追加
	'add_goods_cat'			=> 'Add Category',
	'add_custom_success'	=> 'Add a custom section success',
	'update_fail'			=> 'Missing key parameter update failed',
	'update_custom_success'	=> 'Update successful custom section',
	'drop_custom_success'	=> 'Delete custom section success',
	'sort_edit_ok'			=> 'Sort No. edited successfully',
	'sort_edit_fail'		=> 'Sort number edit fail',
	'number_edit_ok'		=> 'Number of Units edited success',
	'number_edit_fail'		=> 'Number of Units edit fail',
	'grade_edit_ok'			=> 'Prices rating edited success',
	'grade_edit_fail'		=> 'Prices fail grading Edit',
	'drop_cat_img_ok'		=> 'Delete Category image success',
	'use_commas_separate'	=> 'Separated by commas',
	'term_meta'				=> 'Custom sections',
	'edit_term_mate'		=> 'Edit a custom section',
	'name'					=> 'Name',
	'value'					=> 'Value',
	'update'				=> 'Update',
	'remove_custom_confirm'	=> 'Are you sure you want to delete this custom section?',
	'add_term_mate'			=> 'Add a custom section',
	'add_new_mate'			=> 'Add new section',
	'promotion_info'		=> 'Promotions',
	'recommend_index'		=> 'Home recommended',
	'cat_img'				=> 'Category image',
	'select_cat_img'		=> 'Select category picture',
	'edit_cat_img'			=> 'Modify category photos',
	'drop_cat_img_confirm'	=> 'Are you sure you want to delete this category picture?',
	'tv_cat_img'			=> 'TV- Category Photos',
	'seo'					=> 'SEO optimization',
	'enter_number'			=> 'Please enter the number of units',
	'enter_grade'			=> 'Please enter a price rating',
	'enter_order'			=> 'Please enter a sort number',
	'drop_cat_confirm'		=> 'Are you sure you want to delete this category?',
	'notice'				=> 'Notice:',
	
	'label_cat_name'		=> 'Category name:',
	'label_parent_cat'		=> 'Category parent:',
	'label_measure_unit'	=> 'Quantity unit:',
	'label_grade'			=> 'Price interval number:',
	'label_filter_attr'		=> 'Filter properties:',
	'label_keywords'		=> 'Keyword:',
	'label_cat_desc'		=> 'Category description:',
	'label_edit_term_mate'	=> 'Edit custom columns:',
	'label_add_term_mate'	=> 'Add custom columns:',
	'label_sort_order'		=> 'Sort:',
	'label_is_show'			=> 'Whether display:',
	'label_recommend_index'	=> 'Home recommended:',
	'lab_upload_picture'	=> 'Upload category image:',
	'label_source_cat' 		=> 'From that category:',
	'label_target_cat' 		=> 'Move to:',
	
	'overview'              => 'Overview',
	'more_info'             => 'More information:',
	
	'goods_category_help'	=> 'Welcome to ECJia intelligent background category list page, the system will display all goods category in this list.',
	'about_goods_category'	=> 'About category list help document',
	
	'add_category_help'		=> 'Welcome to ECJia intelligent background add category page, you can add items category Info on this page.',
	'about_add_category'	=> 'About add category help document',
	
	'edit_category_help'	=> 'Welcome to ECJia intelligent background edit category page, you can edit items category Info on this page.',
	'about_edit_category'	=> 'About edit category help document',
	
	'move_category_help'	=> 'Welcome to ECJia intelligent background move category page,  you can transfer goods category operation on this page.',
	'about_move_category'	=> 'About move category help document',
);

// end