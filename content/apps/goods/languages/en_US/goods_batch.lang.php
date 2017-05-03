<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品批量上传、修改语言文件
 */
return array(
	'select_method' => 'Product method:',
	'by_cat' 		=> 'Basis product category, brand',
	'by_sn' 		=> 'Basis product No',
	'select_cat' 	=> 'Category:',
	'select_brand' 	=> 'Brand:',
	'goods_list' 	=> 'List:',
	'src_list' 		=> 'Choose product:',
	'dest_list' 	=> 'Chosen product:',
	'input_sn' 		=> 'Enter product NO:',
	'edit_method' 	=> 'Method:',
	'edit_each' 	=> 'One by one',
	'edit_all' 		=> 'Unify',
	'go_edit' 		=> 'Enter',
		
	'notice_edit' 	=> 'Member price -1 express Member price will be calculated in proportion to Member discounts grading',
	'goods_class' 	=> 'Goods Class',
		
	'g_class' => array(
		G_REAL => 'Real Goods',
		G_CARD => 'Virtual Card',
	),
	
	'goods_sn' 		=> 'NO',
	'goods_name' 	=> 'Name',
	'market_price' 	=> 'Market price',
	'shop_price' 	=> 'Shop price',
	'integral' 		=> 'Purchase Points',
	'give_integral' => 'Free points',
	'goods_number' 	=> 'Stock',
	'brand' 		=> 'Brand',
	'batch_edit_ok' => 'Batch modify successfully.',
	
	'export_format' 	=> 'Data formats',
	'export_ecshop' 	=> 'ecshop to support data formats',
	'export_taobao' 	=> 'taobao Assistant to support data formats',
	'export_taobao46' 	=> 'taobao Assistant4.6 to support data formats',
	'export_paipai' 	=> 'paipai Assistant to support data formats',
	'export_paipai3'	=> 'paipai 3.0 Assistant to support data formats',
	'goods_cat' 		=> 'Category:',
	'csv_file' 			=> 'Upload csv files:',
	'notice_file' 		=> '(The product quantity once upload had better be less than 1000 in CSV file, the CSV file size had better be less than 500K.)',
	'file_charset' 		=> 'Character set:',
	'download_file' 	=> 'Download batch CSV files(%s).',
	
	'use_help' 	=> 'Help:' .
	        '<ol>' .
	          '<Li>According to the usage habit, the download corresponds language of csv file, for example Chinese mainland customers download the simplified Chinese character language file, Hongkong and Taiwan customers download the traditional Chinese language file,</li>' .
	          '<Li>Fill in the csv file, can use the excel or text editor to open a csv file,<br />' .
	              'If "Best product" and so on, fill in numeral 0 or 1, 0 means "NO", 1 mean "YES",<br />' .
	              'Please fill in file name with path for product picture and thumbnail, the path is relative path [root directory]/images/, for example, the picture path is [root catalogue]/images/200610/abc.jpg, fill in 200610/abc.jpg,<br />'.
	              '<font style="color:#FE596A,">If Taobao Assistant cvs encoding format, make sure the code on the site, such as the code is incorrect, you can use editing software transcoding.</font></li>' .
	          '<Li>Upload the product picture and thumbnail to correspond directory, for example:[Root catalogue]/images/200610/,</li>' .
	              '<font style="color:#FE596A,">Please upload pictures of goods and commodities csv file and upload the thumbnails, or picture can not be processed.</font></li>' .
	          '<Li>Select category and file code to upload, upload the csv file.</li>'.
	        '</ol>',
	
	'js_languages' => array(
		'please_select_goods' 	=> 'Please select product.',
		'please_input_sn' 		=> 'Please enter product NO..',
		'goods_cat_not_leaf' 	=> 'Please select bottom class category.',
		'please_select_cat' 	=> 'Please select belong category.',
		'please_upload_file' 	=> 'Please upload batch csv files.',
	),
	
	// Batch upload field of product
	'upload_goods' => array(
		'goods_name' 	=> 'Name',
		'goods_sn' 		=> 'NO.',
		'brand_name' 	=> 'Brand',   // Need to be convert brand_id
		'market_price' 	=> 'Market price',
		'shop_price' 	=> 'Shop price',
		'integral' 		=> 'Points limit for buying',
		'original_img' 	=> 'Original picture',
		'goods_img' 	=> 'Picture',
		'goods_thumb' 	=> 'Thumbnail',
		'keywords' 		=> 'Keywords',
		'goods_brief' 	=> 'Brief',
		'goods_desc'	=> 'Details',
		'goods_weight' 	=> 'Weight(kg)',
		'goods_number' 	=> 'Stock quantity',
		'warn_number' 	=> 'Stock warning quantity',
		'is_best' 		=> 'Best',
		'is_new' 		=> 'New',
		'is_hot' 		=> 'Hot',
		'is_on_sale' 	=> 'On sale',
		'is_alone_sale' => 'Can be a common product sale?',
		'is_real' 		=> 'Entity',
	),
	
	'batch_upload_ok' 		=> 'Batch upload successfully.',
	'goods_upload_confirm' 	=> 'Batch upload confirmation.',
	'batch_choose_goods'	=> 'Batch Select Goods',
	'batch_edit_goods'		=> 'Batch Edit Goods',
	'not_exist_goods'		=> 'There is no goods',
	'back_last_page'		=> 'Go back to the last page',
	'batch_edit_ok'			=> 'Batch edit product success!',
	'select_please'			=> 'Please choose',
	'uniform_goods_name'	=> 'Uniform modification of the name of the goods:',
	'all_category'			=> 'All categories',
	'all_brand'				=> 'All brands',
	'filter_goods_info'		=> 'Filter to product information',
	'no_content'			=> 'No content yet',
	'choost_goods_list'		=> 'Selected Goods List',
	'one_per_line'			=> '(One per line)',
);

// end